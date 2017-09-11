<?php

namespace App\Http\Controllers\admin;

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

            }break;
        }
    }
}
