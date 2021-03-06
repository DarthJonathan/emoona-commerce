<?php

namespace App\Http\Controllers;

use App\Discount;
use App\ItemCategory;
use App\ItemDetail;
use Illuminate\Http\Request;
use App\Item;
use Cart;
use Storage;

class ProductController extends Controller
{
    function viewProduct($gender, $category_id, $product_id)
    {
        $product        = Item::with('item_category', 'item_detail')->where(['id' => $product_id, 'deleted' => 0])->where('deleted', '=', 0)->firstOrFail();
        $discounts      = array();

        if(strcasecmp($product['item_category']['name'], $category_id) || strcasecmp($product['item_category']['gender'], $gender))
            abort(404);

        foreach($product->item_detail as $key => $detail)
        {
            //Remove the deleted item detail
            if($detail->deleted == 1) {
                unset($product->item_detail[$key]);
                continue;
            }

            $discount = Discount::where('item_detail_id', '=', $detail['id'])->first();

            if($discount != null)
            {
                $discounts[$detail['id']] = $discount->amount;
            }
        }

        $data = [
            'product'       => $product,
            'discounts'     => $discounts
            ];

        return view('pproduct', $data);
    }

    function frontPage ()
    {
        try
        {
            $products           = Item::with('item_category', 'item_detail')->where('deleted', '=', 0)->limit(30)->get();
            $categories         = ItemCategory::where('deleted', '=', 0)->get();
            $product_images     = array();
            $discounts          = array();

            foreach($products as $count => $product)
                $product_images[$count] = array();

            foreach($products as $count => $product)
            {
                foreach($product->item_detail as $key => $detail)
                {
                    if($detail->deleted == 1)
                    {
                        unset($product->item_detail[$key]);
                        continue;                        
                    }

                    $path = $detail->images;

                    $files = Storage::files('public/item_detail/' . $path);

                    $product_images[$count] += $files;
                    // $product_images = $files;

                    $discount = Discount::where('item_detail_id', '=', $detail->id)->first();

                    if($discount != null)
                    {
                        $discounts[$detail->id] = $discount->amount;
                    }
                }
            }

            return response()->json([
                'error'         => false,
                'products'      => $products,
                'discounts'     => $discounts,
                'images'        => $product_images,
                'categories'    => $categories
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Error getting products from database! (Err: 224)', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function categoryProducts(Request $req)
    {
        $category_id = $req->category_id;
        $all_images = [];

        try {
            $products = Item::with('item_category', 'item_detail')->where('category_id', '=', $category_id)->where('deleted', '=', 0)->get();
            $product_images = array();
            $discounts = array();
        

            foreach ($products as $key => $product)
            {
                $product_images = [];
                foreach ($product->item_detail as $detail)
                {
                    if($detail->deleted == 1)
                    {
                        unset($product->item_detail[$key]);
                        continue;                        
                    }

                    $path = $detail->images;

                    $files = Storage::files('public/item_detail/' . $path);

                    $product_images += $files;

                    $discount = Discount::where('item_detail_id', '=', $detail->id)->first();

                    if($discount != null)
                    {
                        $discounts[$detail->id] = $discount->amount;
                    }
                }

                array_push($all_images, $product_images);
            }

            return response()->json([
                'error'         => false,
                'products'      => $products,
                'discounts'     => $discounts,
                'images'        => $all_images
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Error getting products from database! (Err: 225)', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function categoryProductsAll(Request $req)
    {
        $category_id        = $req->category_id;
        $products           = array();
        $cate               = ItemCategory::where('deleted', '=', 0)->get();
        $all_images         = array();
        $discounts          = array();

        try {
            $categories = ItemCategory::where('gender', '=', $category_id)->where('deleted', '=', 0)->get();

            foreach($categories as $key => $category) {
                array_push($products, Item::with('item_category', 'item_detail')->where('category_id', '=', $category->id)->where('deleted', '=', 0)->get());
                $product_images = array();

                foreach ($products[$key] as $key_2 => $product) {
                    $product_images[$key_2] = [];

                    foreach ($product->item_detail as $key_3 => $detail) {
                    
                        if($detail->deleted == 1)
                        {
                            unset($product->item_detail[$key_3]);
                            continue;       
                        }

                        $path = $detail->images;

                        $files = Storage::files('public/item_detail/' . $path);
                        $discount = Discount::where('item_detail_id', '=', $detail->id)->first();

                        if($discount != null)
                        {
                            $discounts[$detail->id] = $discount->amount;
                        }

                        array_push($product_images[$key_2], $files);
                    }
                }

                array_push($all_images, $product_images);
            }

            return response()->json([
                'error'         => false,
                'products'      => $products,
                'discounts'     => $discounts,
                'images'        => $all_images,
                'categories'    => $cate
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Error getting products from database! (Err: 225)', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function loadOnSale ()
    {
        try {

            $discounts = Discount::all();
            $products = array();
            $product_images = array();
            $counter = 0;

            foreach($discounts as $count => $discount)
            {
                $item_detail = ItemDetail::with('item')->where('id', '=', $discount->item_detail_id)->where('deleted', '=', 0)->first();

                if($item_detail == null)
                    continue;
                else if($item_detail->deleted == 1)
                    continue;

                $products[$counter]['item'] = $item_detail;
                $products[$counter]['category'] = $item_detail->getCategory();
                $counter++;
            }

            foreach ($products as $product)
            {
                $path = $product['item']['images'];

                $files = Storage::files('public/item_detail/' . $path);

                array_push($product_images, $files);
            }

            return response()->json([
                'error'         => false,
                'products'      => $products,
                'images'        => $product_images
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Error getting products from database! (Err: 225)', 'errors_debug' => $e->getMessage()], 400);
        }
    }
}
