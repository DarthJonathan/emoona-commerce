<?php

namespace App\Http\Controllers;

use App\Webconfig;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function termsAndCons ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 4];

        return view('pTermsCon', $data);
    }

    function returnPolicy ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 5];

        return view('pTermsCon', $data);
    }

    function shippingPolicy ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 6];

        return view('pTermsCon', $data);
    }

    function contactUs ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 7];

        return view('pTermsCon', $data);
    }
}
