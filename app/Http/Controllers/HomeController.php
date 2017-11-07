<?php

namespace App\Http\Controllers;

use App\Webconfig;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    function termsAndCons ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 4, 'page_title' => 'Terms and Conditions'];

        return view('pTermsCon', $data);
    }

    function returnPolicy ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 5, 'page_title' => 'Return Policy'];

        return view('pTermsCon', $data);
    }

    function shippingPolicy ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 6, 'page_title' => 'Shipping Policy'];

        return view('pTermsCon', $data);
    }

    function contactUs ()
    {
        $webconfig = Webconfig::all();

        $data = ['webconfig' => $webconfig, 'link' => 7, 'page_title' => 'Contact Us'];

        return view('pTermsCon', $data);
    }

    function signUpNewsLetter (Request $req)
    {
        $rules = [
            'firstname' => 'required|alpha',
            'lastname'  => 'required|alpha',
            'email'     => 'required|email|unique:users,email'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            $message = $validate->messages();
            return back()->withErrors($message);
        }else
        {
            return redirect('/register')->with($req->all());
        }
    }

    function checkMail ()
    {
        $data = ['activation_code' => 'aaa'];
        return view('emails.activate', $data);
    }
}
