<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudioItem;
use App\StudioCategory;
use Validator;
use DB;
use File;
use Image;
use Storage;

class StudioController extends Controller
{
    function __construct ()
    {
        ini_set('memory_limit','512M');
    }
    
    public function createCategory(Request $req){

    	$rules = [
        	'categoryName' => 'required',
        	'categoryDescription' => 'required'
    	];

    	$errors = Validator::make($req->all(), $rules);

        if($errors->fails()){
            return redirect('admin/studio')->withErrors(($errors));
        }

    	$category = new StudioCategory();
    	$category->name = $req->categoryName;
    	$category->description = $req->categoryDescription;
    	$category->template = $req->type;
    	$category->save();

    	return redirect('admin/studio');
    }

    public function deleteCategory($id){
    	$category = StudioCategory::find($id);

        $exists = StudioItem::where('category_id', '=', $id)->get();

        if($exists != null)
            return back()->withErrors('There are items in this category');

    	$category->delete();

    	return redirect('admin/studio');
    }

    public function editCategoryView ($id)
    {
        $category = StudioCategory::find($id);
        return view('admin.edit_category_studio', ['data' => $category]);
    }

    public function editCategory(Request $req){

        $rules = [
            'categoryName' => 'required',
            'categoryDescription' => 'required'
        ];

        $errors = Validator::make($req->all(), $rules);

        if($errors->fails()){
            return redirect('admin/studio')->withErrors(($errors));
        }

        $category = StudioCategory::find($req->id);
        $category->name = $req->categoryName;
        $category->description = $req->categoryDescription;
        $category->template = $req->type;
        $category->save();

        return redirect('admin/studio');

    }

    public function getCategory(Request $req){
    	$categories = StudioCategory::where('template',$req->template)->get();
		//return $category;

		foreach ($categories as $category) {
			echo "<option value='".$category->id."'>".$category->name."</option";
		}
    }

    public function addStudioItem(Request $req){
    	
    	$rules=[
    		'title' => 'required',
    		'content' => 'required',
    		'type' => 'required',
    		'category' => 'required',
    		'banner' => 'required|mimes:jpg,jpeg,png',
    		'media.*' => 'required| mimes:jpg,jpeg,png,mp4',
    		'media' => 'required'
    	];

    	$errors = Validator::make($req->all(), $rules);

        if($errors->fails()){
            return redirect('admin/studio')->withErrors($errors->messages());
        }
        else{

            try
            {
            	$path = 'app/public/img/studio/'. time();

                mkdir(storage_path($path));

            	foreach ($req->media as $file) {

                    $fileExt = $file->extension();

                    if($fileExt!='mp4'){ //mime image
                    	$img = $file->getRealPath();
                        $save_path = $path . '/' . time() . '.jpg';

                    	Image::make($img)->fit(1920, 1280)->encode('jpg', 75)->interlace()->save(storage_path($save_path));
                        // $path = $file->store(storage_path($path));
                	}
                	else{ //mime video
                        $pathForVid= 'public/img/studio/' . explode('/',$path)[4];
                		$vidpath = $file->store($pathForVid);
                	}

            	}

                $banner = $req->banner->getRealPath();
                Image::make($banner)->encode('jpg', 75)->interlace()->save(storage_path($path . '/banner.jpg'));

            	$item              = new StudioItem();
            	$item->title       = $req->title;
            	$item->content     = $req->content;
            	$item->category_id = $req->category;
            	$item->files       = $path;

            	$item->save();

        		return back();
            }catch(\Exception $e){
                return redirect('admin/studio')->withErrors($e->getmessage);
            }
        }
    }

    public function deleteStudioItem($id){

        $item = StudioItem::find($id);

        File::deleteDirectory(storage_path($item->files));

        $item->delete();

        return redirect('admin/studio')->with('success', 'Deleting studio item success!');
    }

    /**
     * Previewing the studio item, for editing
     *
     * @param $req Gets the form request
     * @return view
     */
    function editStudioItem (Request $req)
    {
        $item = StudioItem::find($req->id);

        try {
            $data = [
                'files'     => Storage::files('public/img/studio/' . explode('/',$item->files)[4]),
                'id'        => $item->id,
                'studio'    => $item
            ];
            return view('admin.edit_studio_item', $data);
        }catch (\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error getting studio item (Err:941)'
            ], 400);
        }
    }

    /**
     * To store the edited studio item
     * 
     * @param $req The edited from inform of a Request object
     */
    function storeEditStudioItem (Request $req)
    {
        $rules = [
            'title'     => 'required',
            'content'   => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            return response()->json([
                'error'         => true,
                'errors'        => $validate->messages()
            ], 400);
        }else
        {
            try {

                $studio = StudioItem::find($req->id);

                $studio->title       = $req->title;
                $studio->content     = $req->content;

                $studio->save();

                $return = ['error' => false, 'msg' => 'Successfully edited studio item!'];

                return response()->json($return, 200);

            }catch(\Exception $e)
            {
                return response()->json([
                    'error'         => true,
                    'errors_debug'  => $e->getMessage(),
                    'errors'        => 'Error Editing Studio (Err:641)'
                ], 400);
            }
        }
    }

    /**
     * Changes the studio banner
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeBannerImageStudio(Request $req)
    {
        $rules = [
            'banner' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
            return response()->json([
                'error'         => true,
                'errors'        => $validate->messages()
            ], 400);

        try {

            $path = 'app/public/img/studio/'. $req->file_path;

            $img = $req->banner->getRealPath();
            $save_path = $path . '/banner.jpg';

            Storage::delete('public/img/studio/' . $req->file_path . '/banner.jpg');

            Image::make($img)->resize(1280, null, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); })->encode('jpg', 45)->interlace()->save(storage_path($save_path));

            return response()->json([
                'error' => false,
                'msg'   => 'Changing Studio Item Banner Success!'
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error Changing Studio Item Banner (Err:3241)'
            ], 400);
        }
    }

    /**
     * For uploading new media in the studio item
     *
     * @param Request $req
     */
    public function addStudioItemMedia(Request $req)
    {
        $rules=[
            'media.*'   => 'required| mimes:jpg,jpeg,png,mp4,JPG,JPEG,PNG,MP4',
            'media'     => 'required'
        ];

        $errors = Validator::make($req->all(), $rules);

        if($errors->fails()){
            return response()->json([
                'error'         => true,
                'errors'        => $errors->messages()
            ], 400);
        }

        try {
            $path = 'app/public/img/studio/'. $req->file_path;

            foreach ($req->media as $file) {

                $fileExt = $file->extension();

                if($fileExt!='mp4'){ //mime image
                    $img = $file->getRealPath();
                    $save_path = $path . '/' . time() . '.jpg';

                    Image::make($img)->fit(1920, 1280)->encode('jpg', 45)->interlace()->save(storage_path($save_path));
                    // $path = $file->store(storage_path($path));
                }
                else{ //mime video

                    $pathForVid= 'public/img/studio/' . explode('/',$path)[4];
                    $vidpath = $file->store($pathForVid);

                    return response()->json([
                        'error' => false,
                        'msg'   => $vidpath
                    ], 200);
                }

            }

            return response()->json([
                'error' => false,
                'msg'   => 'Adding Media Success!'
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error deleting media of an item (Err:951)'
            ], 400);
        }
    }

    /**
     * Delete media within a studio item
     *
     * @param $req the request sent by ajax
     */
    function deleteMediaItem (Request $req)
    {
        try {

            foreach($req->id as $item)
            {
                Storage::delete('public/img/studio/' . $item);
            }

            return response()->json([
                'error' => false,
                'msg'   => 'Deletion Complete'
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error deleting media of an item (Err:951)'
            ], 400);
        }
    }
}