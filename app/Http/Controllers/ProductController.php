<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Cart;

class ProductController extends Controller
{
    function viewProduct($gender, $category_id, $product_id)
    {
        $product = Item::with('item_category', 'item_detail')->where('id', '=', $product_id)->firstOrFail()->toArray();

        if(strcasecmp($product['item_category']['name'], $category_id) || strcasecmp($product['item_category']['gender'], $gender))
            abort(404);

        $data = ['product' => $product];

        return view('pproduct', $data);
    }

}
