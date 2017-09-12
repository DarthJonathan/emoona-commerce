<?php

namespace App\Http\Controllers\admin;

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
                $itemDetails = ItemDetail::where('gender', '=', $req->input('id'))->get()->toArray();
                return $itemDetails;
            }break;
        }
    }
}
