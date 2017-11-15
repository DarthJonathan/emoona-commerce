<?php

namespace App\Http\Controllers\Admin;

use App\HomeSlider;
use App\ItemDetail;
use App\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Webconfig;
use Image;
use Validator;
use Storage;

class WebconfigController extends Controller
{
    function __construct ()
    {
        ini_set('memory_limit','512M');
    }

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
            return response()->json(['error' => false, 'errors' => $e->getMessage()], 400);
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
            $path = 'public/img/home-slider/' . $image ;
            $db = HomeSlider::where('image', '=', 'app/' . $path)->first();
            Storage::delete($path);
            $db->delete();
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
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048'
        ];

        $messages = [
            'image.required'      => 'You must select a file',
            'image.image'         => 'File have to be an image',
            'image.mimes'         => 'Image have to be either jpg, png, gif, or svg',
            'image.max'           => 'Max file size is 5 MB',
            'url'                 => 'Must be a valid URL'
        ];

        $valid = Validator::make($req->all(), $rules, $messages);

        if($valid->fails())
        {
            $message = $valid->messages();

            return redirect('/admin/configuration')->withError($message);
        }else
        {
            $path = 'app/public/img/home-slider/' . time() . '.jpg';

            try
            {
                $image = $req->image;

                $slider = new HomeSlider();

                $slider->display_order = $slider->getNewOrder();
                $slider->image = $path;

                if($req->url == null)
                    $slider->url   = '#';
                else
                    $slider->url   = $req->url;

                $img = $image->getRealPath();
                Image::make($img)->fit(1920, 1280)->encode('jpg', 75)->interlace()->save(storage_path($path));

                $slider->save();

                return redirect('/admin/configuration');

            }catch(\Exception $e)
            {
//                return redirect('/admin/configuration')->withError('Adding Slider Image Failed!');
                return redirect('/admin/configuration')->withError($e->getMessage());
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
//            $return = ['error' => true, 'errors' => $message];
//            return response()->json($return, 400);

            return redirect('admin/configuration')->withError($message);
        }else
        {
            try
            {
                if($req->image0 != null)
                {
                    //Save the image first
                    $img0 = $req->image0->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img0)->fit(500)->interlace()->save(storage_path('app/public/img/home-collections/1.jpg'));
                }

                if($req->image1 != null)
                {
                    //Save the image first
                    $img1 = $req->image1->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img1)->fit(500)->interlace()->save(storage_path('app/public/img/home-collections/2.jpg'));
                }

                if($req->image2 != null)
                {
                    //Save the image first
                    $img2 = $req->image2->getRealPath();
                    //Crop and Fit the image to 1:1
                    Image::make($img2)->fit(500)->interlace()->save(storage_path('app/public/img/home-collections/3.jpg'));
                }

//                $return = ['error' => false, 'msg' => 'Changing Collection Image Success!'];
                return redirect('admin/configuration');

            }catch(\Exception $e)
            {
                return redirect('admin/configuration')->withError($e->getMessage());
            }
        }
    }

    function changeTransferText (Request $req)
    {
        $rules = [
            'value'     => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            return response()->json(['error' => true, 'errors' => $validate->messages()], 400);
        }else
        {
            try {

                $value = $req->value;

                $transfer = PaymentType::find(1);

                $transfer->value = $value;

                $transfer->save();

                return response()->json(['error' => false, 'msg' => 'Changes are saved!'], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => $e->getMessage()], 400);
            }
        }
    }

    function reorderSliders (Request $req)
    {
        try {
            $old_order = $req->old;
            $new_order = $req->new;

            $sliders = HomeSlider::orderBy('display_order')->get();

            $sliders[$old_order]->display_order = $new_order;
            $sliders[$new_order]->display_order = $old_order;

            $sliders[$old_order]->save();
            $sliders[$new_order]->save();

            return response()->json([
                'error' => false,
                'msg' => 'Reordering Success!'
            ], 200);
        }catch(\Exception $e)
        {
            return response()->json(['error' => true,'errors' => 'Reordering Error!', 'errors_debug' => $e->getMessage()], 400);
        }
    }
}
