<?php

namespace App\Http\Controllers;

use App\HomeSlider;
use App\ItemDetail;
use App\ItemNotify;
use App\Webconfig;
use App\Social;
use App\StudioCategory;
use App\StudioItem;
use Storage;
use Auth;
use Illuminate\Http\Request;
use File;

class StoreController extends Controller
{
    function home ()
    {
        $featured   = ItemDetail::with('item')->where('featured', '=', 1)->where('deleted', '=', 0)->get();
        $images     = array();
        $slider     = HomeSlider::orderBy('display_order')->get();
        $collection = Storage::files('public/img/home-collections');

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
            'sliders'       => $slider,
            'collections'   => $collection
        ];

        return view('phome',$data);
    }

    function store ($category = null)
    {
        $data = ['category' => $category];
        return view('pShop', $data);
    }

    function studio ()
    {
        $category = StudioCategory::orderBy('template','asc')->get();
        $item = StudioItem::with('StudioCategory')->orderBy('category_id','asc')->get();
        $data = [
            'categories' => $category,
            'items' => $item
        ];
        return view('pStudio',$data);
    }

    function social ()
    {
        $socials = Social::all(); 
        $data = ['socials'=> $socials]; 
 
        return view('pSocial',$data); 
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

    function notify (Request $req)
    {
        try{

            $cat = $req->cat;
            $id = $req->id;

            $notif = new ItemNotify();

            $notif->user_id = Auth::id();
            $notif->item_id = $id;
            $notif->category = $cat;

            $notif->save();

            $return = ['error' => true, 'errors' => 'You will be notified if this item is available soon'];

            return response()->json($return, 200);

        }catch(\Exception $e)
        {
            $return = ['error' => true, 'errors' => 'Adding to notification failed', 'errors_debug' => $e->getMessage()];

            return response()->json($return, 400);
        }
    }
}
