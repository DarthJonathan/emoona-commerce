<?php

namespace App\Http\Controllers\Admin;

use App\Discount;
use App\Item;
use App\ItemCategory;
use App\ItemDetail;
use App\ItemNotify;
use App\user_notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Monolog\Logger;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use Image;

class ItemManagement extends Controller
{
    function __construct ()
    {
        ini_set('memory_limit','512M');
    }

    function category (Request $req)
    {
        switch($req->input('category'))
        {
            case 1:
            {
                $itemDetails = ItemCategory::where('gender', '=', $req->input('id'))->where('deleted', '=', 0)->get()->toArray();

                $data = [
                    'category'  => $req->input('category'),
                    'html'      => $itemDetails
                ];

                echo json_encode($data);
            }break;

            case 2:
            {
                $itemDetails = Item::where(['category_id' => $req->id, 'deleted' => 0])->get()->toArray();

                $data = [
                    'category'  => $req->input('category'),
                    'html'      => $itemDetails
                ];

                echo json_encode($data);
            }break;

            case 3:
            {
                $itemDetails = ItemDetail::where(['item_id' => $req->id, 'deleted' => 0])->get()->toArray();

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
        $check_category = count(Item::where(['category_id' => $category_id, 'deleted' => 0])->get()->toArray());

        if($check_category > 0)
            $return = ['error' => true, 'msg' => 'There are items in this category'];
        else
        {
            try {
                $category = ItemCategory::where('id', '=', $category_id)->first();
                $gender = $category->gender;
                $category->deleted = 1;
                $category->save();

                $return = ['error' => false, 'msg' => 'Deleting category completed', 'next' => ['id' => $gender, 'next' => 1]];

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
            $deleted = Item::where('id', '=', $item_id)->first();

            $deleted->deleted = 1;
            $deleted->save();

            //Delete the following item details
            $details = ItemDetail::where('item_id', '=', $item_id)->get();

            if($details->isNotEmpty()) {
                foreach ($details as $detail) {

                    $image_path = 'public/item_detail/' . $detail->images;

                    //Delete Image Folder
                    Storage::deleteDirectory($image_path);

                    $detail->deleted = 1;
                    $detail->save();
                }
            }

            $return = ['error' => false, 'msg' => 'Deleting item completed', 'next' => ['id' => $item_id, 'next' => 2]];

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

            $detail->deleted = 1;
            $detail->save();

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
            'categories'    => json_encode(ItemCategory::where('deleted', '=', 0)->get()->toArray())
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

    function newItemDetail (Request $req)
    {
        $rules = [
            'color'     => 'required',
            'size'      => 'required',
            'stock'     => 'required|min:1',
            'image'     => 'required',
            'image.*'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $messages = [
            'color.required'    => 'Item color is required',
            'size.required'     => 'Item size is required',
            'stock.required'    => 'Item stock is required',
            'stock.min'         => 'Item stock cannot be 0',
            'image.*.mimes'     => 'Item image file type is invalid',
            'image.*.image'     => 'Item image file uploaded is not an image',
            'image.*.max:2048'  => 'Item image maximum file size is 2 MB',
            'image.max'         => 'Item image maximum file size is 2 MB'
        ];

        $validate = Validator::make($req->all(), $rules, $messages);

        if($validate->fails())
        {
            $return = ['error' => true, 'errors' => $validate->messages()];
            return response()->json($return, 400);
        }

//        Check if item detail exists
        $exists = ItemDetail::where(
            [
                'color'     => $req->color, 
                'size'      => $req->size, 
                'deleted'   => 0,
                'item_id'   => $req->id
            ])->first();
        
            if($exists != null)
            return response()->json(['error' => true, 'errors' => 'Item Exists!'], 400);

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

            //Send notification
            $this->sendNotification($parentId);

            //Make the directory
            if(!file_exists(storage_path('app/' . $imagePath . '/'))) {
                mkdir(storage_path('app/' . $imagePath . '/'), 777, true);
            }

            //Store the file
            foreach($req->image as $image)
            {
                // array_push($singularPath, $image->store($imagePath));
                Image::make($image->getRealPath())->encode('jpg', 75)->interlace()->save(storage_path('app/' . $imagePath . '/' . time() . '.jpg'));
            }

            $return = ['error' => false, 'msg' => 'Successfully added a new item detail!', 'id' => $parentId];

            return response()->json($return, 200);

        }catch(\Exception $e) {

            $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 211)', 'errors_debug' => $e->getMessage()];

            Log::error("Error storing file into database [" . $e . "]");

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

    function sendNotificationDetail($id)
    {
        $notifs = ItemNotify::where(['item_id' => $id, 'category' => 'preorder'])->get();

        foreach($notifs as $notif)
        {
            $item = ItemDetail::with('item')->where('id', '=',$notif->item_id)->first();
            $item_cate = $item->getCategory();

            $user_notif = new user_notification();

            $user_notif->user_id = $notif->user_id;
            $user_notif->notification_name = "The item " . $item->item->name . " is now available";
            $user_notif->notification_url = '/product/' . $item_cate->gender . '/' . $item_cate->name . '/' . $item->item->id;

            $user_notif->save();

            $notif->delete();
        }
    }

    function sendNotification($id)
    {
        $notifs = ItemNotify::where(['item_id' => $id, 'category' => 'no-stock'])->get();

        foreach($notifs as $notif)
        {
            $item = Item::with('item_category')->where('id', '=', $notif->item_id)->first();

            $user_notif = new user_notification();

            $user_notif->user_id = $notif->user_id;
            $user_notif->notification_name = "The item " . $item->name . " is now available";
            $user_notif->notification_url = '/product/' . $item->item_category->gender . '/' . $item->item_category->name . '/' . $item->id;

            $user_notif->save();

            $notif->delete();
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

                    if($value == 'available')
                    {
                        $this->sendNotificationDetail($id);
                    }
                }break;

                case 'stock':
                {
                    $itemDetail->stock  = $value;

                    if($value > 0)
                    {
                        $this->sendNotificationDetail($id);
                    }
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
            ], 200);
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

            $messages = [
                'image.*.mimes'     => 'Item image file type is invalid',
                'image.*.image'     => 'Item image file uploaded is not an image',
                'image.*.max:2048'  => 'Item image maximum file size is 2 MB',
                'image.max:2048'    => 'Item image maximum file size is 2 MB'
            ];

            $validator = Validator::make($req->all(), $rules, $messages);

            if($validator->fails())
            {
                $message = $validator->messages();

                $return = ['error' => true, 'errors' => $message];

                return response()->json($return, 400);
            }else {

                $path = 'public/item_detail/' . $req->input('id');
                $singularPath = array();

                if(!file_exists(storage_path('app/' . $path . '/'))) {
                    mkdir(storage_path('app/' . $path . '/'), 777, true);
                }

                //Store the file
                foreach ($req->image as $image) {
                    // array_push($singularPath, $image->store($path));
                    Image::make($image->getRealPath())->encode('jpg', 75)->interlace()->save(storage_path('app/' . $path . '/' . time() . '.jpg'));
                }

                $return = ['error' => false, 'msg' => 'Successfully added a new item detail image!'];

                return response()->json($return, 200);
            }

        }catch(\Exception $e) {

            $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 111)', 'errors_debug' => $e->getMessage()];

            Log::error("Error storing file into database [" . $e . "]");

            return response()->json($return, 400);

        }

    }

    //Cesa's Work
    function editCategory (Request $req)
    {
        //tinggal di ambil data dr input form trus save db
        $data = [
            'name' => $req->input('categoryName'),
            'description' => $req->input('categoryDescription'),
            'gender' => $req->input('gender')
        ];

        $item = ItemCategory::findOrFail($req->input('id'));
        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->gender = $data['gender'];
        $item->save();

        return back();
    }

    function editCategoryAjax (Request $req)
    {
        $category_id = $req->input('id');

        try {

            $itemCategory = ItemCategory::find($category_id);
            $data = [
                'category' => $itemCategory
            ];

            return view('admin.edit_category', $data);


        } catch (Exception $e) {
            $return = ['error' => true, 'msg' => $e->getMessage()];

            return response()->json($return, 400);
        }
    }

    function newCategoryAjax (Request $req)
    {
        return view('admin.new_category');
    }

    function newCategory (Request $req)
    {
        $rules = [
            'categoryName'          => 'required',
            'categoryDescription'   => 'required',
            'gender'                => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            return back()->withError($validate->messages());
        }else
        {
            $data = [
                'name' => $req->input('categoryName'),
                'description' => $req->input('categoryDescription'),
                'gender' => $req->input('gender')
            ];
    
            $category = new ItemCategory();
            $category->name = $data['name'];
            $category->description = $data['description'];
            $category->gender = $data['gender'];
            $category->save();
    
            return back();
        }
    }

    function salesStatus (Request $req)
    {
        $sales = Discount::where('item_detail_id', '=', $req->id)->first();
        $data = ['id' => $req->id, 'sales' => $sales];
        return view('admin.add_sale', $data);
    }

    function storeSale (Request $req)
    {
        $rules = [
            'sale'  => 'required|integer|max:100'
//            'valid' => 'required|date|after:today'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            $message = $validate->messages();
            $return = ['error' => true, 'errors' => $message];
            return response()->json($return, 400);
        }else {
            try
            {
                $discount = Discount::where('item_detail_id', '=', $req->id)->first();

                if($discount == null)
                    $discount = new Discount();

                $discount->amount           = $req->sale/100;
//                $discount->valid_until      = $req->valid;
                $discount->valid_until      = Carbon::now();
                $discount->item_detail_id   = $req->id;

                $discount->save();

                return response()->json(['error' => false, 'msg' => 'Saving Discount on Item Success!'],200);

            }catch(\Exception $e)
            {
                $return = ['error' => true, 'errors' => $e->getMessage()];
                return response()->json($return, 400);
            }
        }
    }

    function removeSale (Request $req)
    {
        try
        {
            $discount = Discount::where('item_detail_id', '=', $req->id)->first();

            $discount->delete();

            return response()->json(['error' => false, 'msg' => 'Delete Discount on Item Success!'],200);

        }catch(\Exception $e)
        {
            $return = ['error' => true, 'errors' => $e->getMessage()];
            return response()->json($return, 400);
        }
    }
}