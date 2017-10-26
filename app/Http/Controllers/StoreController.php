<?php

namespace App\Http\Controllers;

use App\ItemDetail;
use App\Webconfig;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    function home ()
    {
        $featured = ItemDetail::where('featured', '=', 1)->get();
        $images   = array();

        foreach($featured as $single)
        {
            $files = Storage::files('public/item_detail/' . $single->images);
            array_push($images, $files);
        }

        $webconfig = Webconfig::all();


        $data = ['datas' => $webconfig, 'featured' => $featured, 'images' => $images];
        return view('phome',$data);
    }

    function store ()
    {
        return view('pShop');
    }

    function studio ()
    {
        return view('pStudio');
    }

    function social ()
    {
        return view('pSocial');
    }

    function about ()
    {
        return view('pAbout');
    }

    function profile()
    {
        return view('pAccount');
    }
}
