<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\ItemDetailRequest;
use App\Item;
use App\ItemCategory;
use App\ItemDetail;
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
            } catch (\Exception $e) {
                $return = ['error' => true, 'msg' => $e];
            }
        }

        echo json_encode($return);
    }

    function deleteItem (Request $req)
    {
        $item_id = $req->input('id');

        try {
            //Delete The Item
            Item::where('id', '=', $item_id)->first()->delete();

            //Delete the following item details
            ItemDetail::where('item_id', '=', $item_id)->get()->delete();

            //todo make a deletion of item detail picture

            $return = ['error' => false, 'msg' => 'Deleting item completed'];
        } catch (\Exception $e) {
            $return = ['error' => true, 'msg' => $e];
            }

        echo json_encode($return);
    }

    function deleteItemDetail (Request $req)
    {
        $item_detail_id = $req->input('id');

        try
        {
            ItemDetail::where('id' , '=', $item_detail_id)->first()->delete();

            //todo make a deletion of item detail picture

            $return = ['error' => false, 'msg' => 'Deleting item details completed'];
        }catch(\Exception $e)
        {
            $return = ['error' => true, 'msg' => $e];
        }

        echo json_encode($return);
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

        $validator = $this->validate($req, $rules);

        if($validator->fails())
        {
            $message = $validator->messages();

            return back()->withError($message);
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

                return back()->with('success', 'Successfully added a new item!');

            }catch(\Exception $e) {

                return back()->with('error', 'Storing into Database Failed (ERR: 311)');

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
        $imagePath  = $parentId . '#' . time().uniqid();

        //Create a new database record
        $itemDetail = new ItemDetail();

        $itemDetail->color  = $req->input('color');
        $itemDetail->stock  = $req->input('stock');
        $itemDetail->size   = $req->input('size');
        $itemDetail->status = $req->input('status');
        $itemDetail->image  = $imagePath;
        //$itemDetail->save();

        //Store the file
        foreach($req->image as $image)
        {
            echo $image->store($imagePath);
        }

        echo '<pre>';
        print_r($req->input());
        print_r($req->file());
    }
}
