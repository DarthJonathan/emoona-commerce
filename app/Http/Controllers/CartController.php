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
            $id = Cart::add([
                'id' => 2,
                'name' => $req->input('product_name'),
                'price' => $req->input('product_price'),
                'quantity' => $req->input('quantity'),
                'attributes' => [
                    'product_id'        => $req->input('product_id'),
                    'product_detail_id' => $req->input('product_detail_id')
                ]
            ]);

            return response()->json(['error' => false, 'msg' => 'Item Added to Cart', 'id' => $id], 200);

        }catch(\Exception $e) {

            return response()->json(['error' => false, 'errors' => 'Adding Item to Cart Failed', 'errors_debug' => $e->getMessage()], 400);
        }
    }

    function getCartContent ()
    {
        $content = Cart::getContent()->toJson();

        return response()->json(['error' => false, 'msg' => $content], 200);
    }

    function clearCart ()
    {

    }
}
