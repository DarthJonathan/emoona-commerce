<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    function home ()
    {
        return view('phome');
    }

    function store ()
    {
        return view('pShop');
    }

    function studio ()
    {
        return view('pStudio');
    }

    function social ()
    {
        return view('pSocial');
    }

    function about ()
    {
        return view('pAbout');
    }
}
