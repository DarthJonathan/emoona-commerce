<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudioItem;
use App\StudioCategory;
use Storage;

class StudioFrontController extends Controller
{
    public function viewStudioItem($id){
    	$item = StudioItem::find($id);
        $files = Storage::files(substr($item->files, 4));


    	$data= [
    		'item'    => $item,
            'files'   => $files
    	];

    	return view('pStudioBannerInside',$data);
    }

    public function getStudioData(){
    	$items = StudioItem::with('studioCategory')->get();

    	return response()->json(['error' => false, 'items' => $items], 200);

    }
}
