<?php

namespace App\Http\Controllers\Admin;

use App\ItemDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Webconfig;
use Image;
use Validator;
use Storage;

class WebconfigController extends Controller
{
    function collectionsCard (Request $req)
    {
        try
        {
            $woman          = Webconfig::find('1');
            $man            = Webconfig::find('2');
            $accessories    = Webconfig::find('3');

            $woman->value_1 = $req->woman_collection;
            $man->value_1 = $req->man_collection;
            $accessories->value_1 = $req->accessories_collection;

            $woman->save();
            $man->save();
            $accessories->save();

            return response()->json(['error' => false, 'msg' => 'Success Updating Collections Texts'],200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Error Updating Collections Texts', 'errors_debug' => $e->getMessage(),400]);
        }
    }

    function getFeatured ()
    {
        try {
            $featured = ItemDetail::where('featured', '=', 1)->get();
            $images   = array();

            foreach($featured as $single)
            {
                $files = Storage::files('public/item_detail/' . $single->images);
                array_push($images, $files);
            }

            return response()->json([
                    'error'     => false,
                    'featured'  => $featured,
                    'images'    => $images
                ], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => $e->getMessage()], 400);
        }
    }

    function removeFeatured (Request $req)
    {
        $items = $req->items;

        foreach($items as $item)
        {
            $item = ItemDetail::find($item);

            $item->featured = 0;

            $item->save();
        }

        return response()->json(['msg' => 'Removing Featured Completed' ],200);
    }

    function editTexts (Request $req)
    {
        switch($req->what)
        {
            case 'about':
            {
                $config = Webconfig::find(9);
                $config->value_1 = $req->data;
            }break;

            case 'tnc':
            {
                $config = Webconfig::find(5);
                $config->value_1 = $req->data;
            }break;

            case 'return':
            {
                $config = Webconfig::find(6);
                $config->value_1 = $req->data;
            }break;

            case 'shipping':
            {
                $config = Webconfig::find(7);
                $config->value_1 = $req->data;
            }break;

            case 'contact' :
            {
                $config = Webconfig::find(8);
                $config->value_1 = $req->data;
            }break;
        }

        $config->save();

        return response()->json(['msg' => 'Changes Saved'], 200);
    }

    function removeSlider(Request $req)
    {
        $images = $req->items;

        foreach($images as $image)
        {
            Storage::delete('public/img/home-slider/' . $image );
        }

        return response()->json(['msg' => 'Changes Saved'], 200);
    }

    function addSlider ()
    {
        return view('admin.webconfig.new_image_slider');
    }

    function storeSliderImage(Request $req)
    {
        $rules = [
            'image'         => 'required',
            'image.*'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $valid = Validator::make($req->all(), $rules);

        if($valid->fails())
        {
            $message = $valid->messages();

            $return = ['error' => true, 'errors' => $message];

            return response()->json($return, 400);
        }else
        {
            $path = 'public/img/home-slider/';

            try
            {
                $images = $req->image;

                foreach($images as $image) {
                    $image->store($path);
                }

                $return = ['error' => false, 'msg' => 'Adding Slider Image Success!'];

                return response()->json($return, 200);

            }catch(\Exception $e)
            {
                $return = ['error' => true, 'errors' => 'Adding Slider Image Failed! (ERR: 90)', 'errors_debug' => $e->getMessage()];

                return response()->json($return, 400);
            }
        }
    }

    function changeCollectionImages (Request $req)
    {
        $rules = [
            'image0'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            $message = $validation->messages();
            $return = ['error' => true, 'errors' => $message];
            return response()->json($return, 400);
        }else
        {
            try
            {
                if($req->image0 != null)
                {
                    //Save the image first
                    $img0 = $req->image0->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img0)->fit(500)->save(storage_path('app/public/img/home-collections/1.jpg'));
                }

                if($req->image1 != null)
                {
                    //Save the image first
                    $img1 = $req->image1->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img1)->fit(500)->save(storage_path('app/public/img/home-collections/2.jpg'));
                }

                if($req->image2 != null)
                {
                    //Save the image first
                    $img2 = $req->image2->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img2)->fit(500)->save(storage_path('app/public/img/home-collections/3.jpg'));
                }

                $return = ['error' => false, 'msg' => 'Changing Collection Image Success!'];
                return response()->json($return, 200);

            }catch(\Exception $e)
            {
                $return = ['error' => true, 'errors' => 'Changing Collections Image Failed! (ERR: 91)', 'errors_debug' => $e->getMessage()];
                return response()->json($return, 400);
            }
        }
    }
}
