<?php

namespace App\Http\Controllers;

use App\Webconfig;
use App\Mail\whisperMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\user_info;
use Auth;

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
        $data = ['page_title' => 'Contact Us'];
        return view('contactUs', $data);
    }

    function contactUsSend (Request $req)
    {
        $rules = [
            'firstname' => 'required|alpha',
            'lastname'  => 'required|alpha',
            'email'     => 'required|email',
            'subject'   => 'required',
            'message'   => 'required|min:20'
        ];


        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            return response()->json(['error' => true, 'errors' => $validate->messages()], 400);
        }else
        {
            try
            {
                $data = [
                    'email'     => $req->email,
                    'subject'   => $req->subject,
                    'name'      => $req->firstname . ' ' . $req->lastname,
                    'message'   => $req->message
                ];

                Mail::to('whisper@emoonastudio.com')->send(new whisperMail($data));
                
                return response()->json(['error' => false, 'msg' => 'Message sent, please check your email for replies.'], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => $e->getMessage()], 400);
            }
        }
    }

    function signUpNewsLetter (Request $req)
    {
        $rules = [
            'firstname' => 'required|alpha',
            'lastname'  => 'required|alpha',
            'email'     => 'required|email'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
        {
            $message = $validate->messages();
            return back()->withErrors($message);
        }else
        {
            if(Auth::check())
            {
                if($req->email != Auth::user()->email)
                    return back()->withErrors("Email doesnt match!");

                $user = user_info::where('user_id', '=', Auth::id())->first();
                $user->newsletter = 1;
                $user->save();
                return redirect('/')->with('success', 'You have signed Up to our newsletter!');
            }
            else
                return redirect('/register')->withInputs($req->all());
        }
    }

    /**
     * Unsubscribe for news letter
     * 
     * @param $id is the user id
     */
    function unsubscribeNewsletter($id = null)
    {
        if($id == null)
            redirect('/');

        $user = user_info::where('user_id', '=', $id)->first();

        $user->newsletter = 0;

        $user->save();

        return redirect('/')->with('msg', 'You have Successfully Unsubscribe From Our Newsletter');
    }
}
