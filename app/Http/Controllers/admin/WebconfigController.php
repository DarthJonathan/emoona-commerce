<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Webconfig;

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
}
