<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Image;
use App\Social;
use Storage;

class SocialController extends Controller
{
    function __construct ()
    {
        ini_set('memory_limit','512M');
    }

    public function saveImages(Request $req)
    {

    	$rules = [
        'images'        => 'required',
        'images.*'      => 'required|image|mimes:jpg,jpeg,png'
    	];

    	$errors = Validator::make($req->all(), $rules);

        if($errors->fails()){
            return redirect('admin/social')->withErrors(($errors));
        }
        else{
        	foreach ($req->images as $image) {
                $filename = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
                $path = 'app/public/img/social/' . time() .$filename. '.jpg';
                $img = $image->getRealPath();
                Image::make($img)->fit(500)->encode('jpg', 75)->interlace()->save(storage_path($path));

	            $social = new Social();
	            $social->image = $path;
	            $social->save();
        	}
        	return redirect('admin/social');
        }
    		
    }

    public function removeImage($id){

        $social = Social::find($id);
        $truelink = explode('/',$social->image,2);
        Storage::delete('/'.$truelink[1]);
        $social->delete();

        return redirect('admin/social');
    }
    
}
