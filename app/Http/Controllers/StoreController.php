<?php

namespace App\Http\Controllers;

use App\ItemDetail;
use App\Webconfig;
use Storage;
use Illuminate\Http\Request;
use File;

class StoreController extends Controller
{
    function home ()
    {
        $featured   = ItemDetail::with('item')->where('featured', '=', 1)->get();
        $images     = array();
        $slider     = Storage::files('public/img/home-slider');
        $collection = Storage::files('public/img/home-collections');

        //Deprecated
//        $slider     = File::allFiles(public_path('img\home-slider'));
//        $collection = File::allFiles(public_path('img\home-collections'));

        foreach($featured as $single)
        {
            $files = Storage::files('public/item_detail/' . $single->images);
            array_push($images, $files);
        }

        $webconfig = Webconfig::all();

        $data = [
            'datas'         => $webconfig,
            'featured'      => $featured,
            'images'        => $images,
            'slider'        => $slider,
            'collections'   => $collection
        ];

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
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig];

        return view('pAbout', $data);
    }

    function profile()
    {
        return view('pAccount');
    }
}
