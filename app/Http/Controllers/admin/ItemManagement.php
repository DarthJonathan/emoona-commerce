<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\ItemDetailRequest;
use App\Item;
use App\ItemCategory;
use App\ItemDetail;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;

class ItemManagement extends Controller
{
    function category (Request $req)
    {
        switch($req->input('category'))
        {
            case 1:
            {
                $itemDetails = ItemCategory::where('gender', '=', $req->input('id'))->get()->toArray();

                $data = [
                    'category'  => $req->input('category'),
                    'html'      => $itemDetails
                ];

                echo json_encode($data);
            }break;

            case 2:
            {
                $itemDetails = Item::where('category_id', '=', $req->input('id'))->get()->toArray();

                $data = [
                    'category'  => $req->input('category'),
                    'html'      => $itemDetails
                ];

                echo json_encode($data);
            }break;

            case 3:
            {
                $itemDetails = ItemDetail::where('item_id', '=', $req->input('id'))->get()->toArray();

                $data = [
                    'category'  => $req->input('category'),
                    'html'      => $itemDetails
                ];

                echo json_encode($data);
            }break;
        }
    }

    function deleteCategory (Request $req)
    {
        $category_id = $req->input('id');
        $check_category = count(Item::where('category_id', '=', $category_id)->get()->toArray());

        if($check_category > 0)
            $return = ['error' => true, 'msg' => 'There are items in this category'];
        else
        {
            try {
                ItemCategory::where('id', '=', $category_id)->first()->delete();
                $return = ['error' => false, 'msg' => 'Deleting category completed'];

                return response()->json($return, 200);
            } catch (\Exception $e) {
                $return = ['error' => true, 'msg' => $e->getMessage()];

                return response()->json($return, 400);
            }
        }
    }

    function deleteItem (Request $req)
    {
        $item_id = $req->input('id');

        try {
            //Delete The Item
            Item::where('id', '=', $item_id)->first()->delete();

            //Delete the following item details
            $details = ItemDetail::where('item_id', '=', $item_id)->get();

            if($details->isNotEmpty()) {
                foreach ($details as $detail) {

                    $image_path = 'public/item_detail/' . $detail->images;

                    //Delete Image Folder
                    Storage::deleteDirectory($image_path);

                    $detail->delete();
                }
            }

            $return = ['error' => false, 'msg' => 'Deleting item completed', 'next' => json_encode(['id' => $item_id, 'next' => 2])];

            return response()->json($return, 200);
        } catch (\Exception $e)
        {
            $return = ['error' => true, 'msg' => $e->getMessage()];

            return response()->json($return, 400);
        }
    }

    function deleteItemDetail (Request $req)
    {
        $item_detail_id = $req->input('id');

        try
        {
            $detail = ItemDetail::where('id' , '=', $item_detail_id)->first();

            $image_path = 'public/item_detail/' . $detail->images;

            $parent = $detail->item_id;

            Storage::deleteDirectory($image_path);

            $detail->delete();

            $return = ['error' => false, 'msg' => 'Deleting item details completed', 'next' => ['id' => $parent, 'next' => 3]];

            return response()->json($return, 200);
        }catch(\Exception $e)
        {
            $return = ['error' => true, 'msg' => $e->getMessage()];

            return response()->json($return, 400);
        }
    }

    function newItemAjax (Request $req)
    {
        $data =[
            'categories'    => json_encode(ItemCategory::all()->toArray())
        ];
        return view('admin.new_item', $data);
    }

    function newItem (Request $req)
    {
        $rules = [
            'itemName'      => 'required',
            'itemPrice'     => 'required|numeric',
            'category'      => 'required',
            'sku'           => 'required',
            'description'   => 'required',
            'preorder'      => 'nullable'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            $message = $validator->messages();

            $return = ['error' => true, 'errors' => $message];

            return response()->json($return, 400);
        }else
        {
            $data = [
                'name'          => $req->input('itemName'),
                'price'         => $req->input('itemPrice'),
                'category_id'   => $req->input('category'),
                'sku'           => $req->input('sku'),
                'description'   => $req->input('description'),
                'preorder'      => $req->input('preorder')==null?0:1
            ];

            try
            {
                $item = new Item();

                $item->category_id  = $data['category_id'];
                $item->name         = $data['name'];
                $item->price        = $data['price'];
                $item->sku          = $data['sku'];
                $item->description  = $data['description'];
                $item->preorder     = $data['preorder'];
                $item->hidden       = 0;

                $item->save();

                $return = ['error' => false, 'msg' => 'Successfully added a new item!', 'id' => $data['category_id']];

                return response()->json($return, 200);

            }catch(\Exception $e) {

                $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 311)', 'errors_debug' => $e->getMessage()];

                return response()->json($return, 400);

            }
        }
    }

    function newItemDetailAjax (Request $req)
    {
        $data = ['id' => $req->input('id')];
        return view('admin.new_item_detail', $data);
    }

    function newItemDetail (ItemDetailRequest $req)
    {
        $parentId   = $req->input('id');
        $imageName  =  $parentId . '.' . time().uniqid();
        $imagePath  = 'public/item_detail/' . $imageName;
        $singularPath = array();

        try {
            //Create a new database record
            $itemDetail = new ItemDetail();

            $itemDetail->item_id = $parentId;
            $itemDetail->color = $req->input('color');
            $itemDetail->stock = $req->input('stock');
            $itemDetail->size = $req->input('size');
            $itemDetail->status = $req->input('status');
            $itemDetail->images = $imageName;
            $itemDetail->save();

            //Store the file
            foreach($req->image as $image)
            {
                array_push($singularPath, $image->store($imagePath));
            }

            $return = ['error' => false, 'msg' => 'Successfully added a new item detail!', 'id' => $parentId];

            return response()->json($return, 200);

        }catch(\Exception $e) {

            $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 211)', 'errors_debug' => $e->getMessage()];

            return response()->json($return, 400);

        }
    }

    function editItemAjax (Request $req)
    {
        $item = Item::with('item_category')->where('id', '=', $req->input('id'))->first()->toArray();
        $categories = ItemCategory::all()->toArray();

        $data = [
            'id'            => $req->input('id'),
            'item'          => $item,
            'item_json'     => json_encode($item),
            'categories'    => json_encode($categories)
        ];
        return view('admin.edit_item', $data);
    }

    function editItem (Request $req)
    {
        $rules = [
            'itemName'      => 'required',
            'itemPrice'     => 'required|numeric',
            'category'      => 'required',
            'sku'           => 'required',
            'description'   => 'required',
            'preorder'      => 'nullable'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            $message = $validator->messages();

            $return = ['error' => true, 'errors' => $message];

            return response()->json($return, 400);
        }else
        {
            try {
                $item = Item::find($req->input('id'));

                $item->name = $req->input('itemName');
                $item->category_id = $req->input('category');
                $item->price = $req->input('itemPrice');
                $item->sku = $req->input('sku');
                $item->description = $req->input('description');
                $item->preorder = $req->input('preorder')==null?0:1;

                $item->save();

                return response()->json([
                    'error' => false,
                    'msg' => 'Editing Item Data Success',
                    'id' => $req->input('id')
                    ], 200);

            }catch (\Exception $e) {
                return response()->json([
                    'error'     => false,
                    'errors'    => 'Error inserting Into Database (Err: 443)',
                    'errors_debug'    => $e->getMessage()
                    ], 400);
            }
        }
    }

    function editItemDetailAjax (Request $req)
    {
        $id     = $req->input('id');
        $field  = $req->input('field');
        $value  = $req->input('value');

        try
        {
            $itemDetail = ItemDetail::findOrFail($id);

            switch($field)
            {
                case 'color':
                {
                    $itemDetail->color = $value;
                }break;

                case 'size':
                {
                    $itemDetail->size = $value;
                }break;

                case 'status':
                {
                    $itemDetail->status = $value;
                }break;

                case 'stock':
                {
                    $itemDetail->stock  = $value;
                }break;

                case 'featured':
                {
                    if($itemDetail->featured == 0)
                        $itemDetail->featured = 1;
                    else
                        $itemDetail->featured = 0;
                }
            }

            $itemDetail->save();

            return response()->json([
                'error' => false,
                'msg'   => 'Success!'
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error inputting into database (Err:442)'
            ], 400);
        }
    }

    function editItemDetailImageAjax (Request $req)
    {
        $path = $req->input('id');

        try {
            $data = ['files' => Storage::files('public/item_detail/' . $path), 'id' => $path];

            return view('admin.image_view', $data);
        }catch (\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error getting image files (Err:441)'
            ], 400);
        }
    }

    function deleteItemDetailImage (Request $req)
    {
        $path = $req->input('id');

        try {

            foreach($path as $count => $single)
            {
                Storage::delete('public/item_detail/' . $single);
            }

            return response()->json([
                'error' => false,
                'msg'   => 'Deletion Complete'
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'error'         => true,
                'errors_debug'  => $e->getMessage(),
                'errors'        => 'Error deleting image files (Err:441)'
            ], 400);
        }
    }

    function addImageItemDetail (Request $req)
    {
        try {

            $rules = [
                'image'     => 'required',
                'image.*'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];

            $validator = Validator::make($req->all(), $rules);

            if($validator->fails())
            {
                $message = $validator->messages();

                $return = ['error' => true, 'errors' => $message];

                return response()->json($return, 400);
            }else {

                $path = 'public/item_detail/' . $req->input('id');
                $singularPath = array();

                //Store the file
                foreach ($req->image as $image) {
                    array_push($singularPath, $image->store($path));
                }

                $return = ['error' => false, 'msg' => 'Successfully added a new item detail image!'];

                return response()->json($return, 200);
            }

        }catch(\Exception $e) {

            $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 111)', 'errors_debug' => $e->getMessage()];

            return response()->json($return, 400);

        }

    }
}
