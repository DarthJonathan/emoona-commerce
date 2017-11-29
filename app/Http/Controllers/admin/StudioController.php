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
                		$pathForVid= explode('/',$path,2);
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
     */
    function editStudioItem (Request $req)
    {
        $studio = StudioItem::find($req->id);
        return view('admin.edit_studio_item', ['studio' => $studio]);
    }

    /**
     * To store the edited studio item
     * 
     * @param $req The edited from inform of a Request object
     */
    function storeEditStudioItem (Request $req)
    {
        
    }

}