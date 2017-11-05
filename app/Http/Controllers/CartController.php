<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Item;
use App\ItemDetail;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    function addToCart (Request $req)
    {
        try
        {
            $product = ItemDetail::with('item')->where('id', '=', $req->product_detail_id)->first();
            $discount = Discount::where('item_detail_id', '=', $req->product_detail_id)->first();

            $price = $product->item->price;

            //Check if the item is in preoder mode
            if($product->status == 'preorder')
                return response()->json(['error' => false, 'errors' => 'Adding Item to Cart Failed (Item is available for preorder)'], 400);

            if($discount != null)
                $price = $price - ($price * $discount->amount);

            Cart::add([
                'id' => $req->input('product_id') . $req->product_detail_id,
                'name' => $req->input('product_name') . ' (' . $product->color . ')',
                'price' => $price,
                'quantity' => $req->input('quantity'),
                'attributes' => [
                    'product_detail_id' => $req->input('product_detail_id'),
                    'product_id'        => $req->input('product_id'),
                    'product_image'     => $req->product_image
                ]
            ]);

            return response()->json(['error' => false, 'msg' => 'Item Added to Cart'], 200);

        }catch(\Exception $e) {

            return response()->json(['error' => false, 'errors' => 'Adding Item to Cart Failed', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function getCartContent ()
    {
        if(Cart::isEmpty()) {
            $content = null;

            return response()->json(['error' => false, 'cart' => null], 200);
        }
        else
        {
            $content = Cart::getContent();
            $quantity = Cart::getTotalQuantity();
            $total = Cart::getTotal();

            return response()->json(
                [
                    'error'     => false,
                    'cart'      => $content,
                    'quantity'  => $quantity,
                    'total'     => $total
                ], 200);
        }
    }

    function clearCart ()
    {
        Cart::clear();

        return response()->json(['error' => false, 'msg' => 'Cart Cleared'], 200);
    }

    function removeItem (Request $req)
    {
        Cart::remove($req->input('id'));

        return response()->json(['error' => false, 'msg' => 'Item Removed'], 200);
    }
}
