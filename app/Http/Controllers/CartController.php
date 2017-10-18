<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    function addToCart (Request $req)
    {
        try
        {
            Cart::add([
                'id' => $req->input('product_id'),
                'name' => $req->input('product_name'),
                'price' => $req->input('product_price'),
                'quantity' => $req->input('quantity'),
                'attributes' => [
                    'product_detail_id' => $req->input('product_detail_id'),
                    'product_image'     => $req->product_image
                ]
            ]);

            return response()->json(['error' => false, 'msg' => 'Item Added to Cart'], 200);

        }catch(\Exception $e) {

            return response()->json(['error' => false, 'errors' => 'Adding Item to Cart Failed', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function cart ()
    {
        $data = ['contents' => Cart::getContent()];
        return view('transaction.cart', $data);
    }

    function getCartContent ()
    {
        if(Cart::isEmpty())
            $content = null;
        else
        {
            $content = Cart::getContent();
            $quantity = Cart::getTotalQuantity();
            $total = Cart::getTotal();
        }

        return response()->json(
            [
                'error'     => false, 
                'cart'      => $content,
                'quantity'  => $quantity,
                'total'     => $total
            ], 200);
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
