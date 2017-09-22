<?php

namespace App\Http\Controllers\admin;

use App\Item;
use App\ItemCategory;
use App\ItemDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            Item::where('id', '=', $item_id)->first()->delete();
            $return = ['error' => false, 'msg' => 'Deleting item completed'];
        } catch (\Exception $e) {
            $return = ['error' => true, 'msg' => $e];
            }

        echo json_encode($return);
    }
}
