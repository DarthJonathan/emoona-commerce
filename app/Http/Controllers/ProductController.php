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
        $product        = Item::with('item_category', 'item_detail')->where(['id' => $product_id])->where('deleted', '=', 0)->firstOrFail()->toArray();
        $discounts      = array();

        if(strcasecmp($product['item_category']['name'], $category_id) || strcasecmp($product['item_category']['gender'], $gender))
            abort(404);

        foreach($product['item_detail'] as $detail)
        {
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
            {
                foreach($product->item_detail as $detail)
                {
                    $path = $detail->images;

                    $files = Storage::files('public/item_detail/' . $path);

                    $product_images[$count] = $files;

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

        try {
            $products = Item::with('item_category', 'item_detail')->where('category_id', '=', $category_id)->where('deleted', '=', 0)->get();
            $product_images = array();
            $discounts = array();

            foreach ($products as $product)
            {
                foreach ($product->item_detail as $detail)
                {
                    $path = $detail->images;

                    $files = Storage::files('public/item_detail/' . $path);

                    array_push($product_images, $files);

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
                'images'        => $product_images
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

        try {

            $categories = ItemCategory::where('gender', '=', $category_id)->where('deleted', '=', 0)->get();

            foreach($categories as $key => $category) {
                array_push($products, Item::with('item_category', 'item_detail')->where('category_id', '=', $category->id)->where('deleted', '=', 0)->get());
                $product_images = array();

                foreach ($products[$key] as $product) {
                    foreach ($product->item_detail as $detail) {
                        $path = $detail->images;

                        $files = Storage::files('public/item_detail/' . $path);

                        array_push($product_images, $files);
                    }
                }

                array_push($all_images, $product_images);
            }

            return response()->json([
                'error'         => false,
                'products'      => $products,
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
