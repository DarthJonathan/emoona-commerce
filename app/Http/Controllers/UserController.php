<?php

namespace App\Http\Controllers;

use App\User;
use App\user_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function notifications ()
    {
        return view('notifications');
    }

    public function edit ()
    {
        $data = Auth::user()->toArray();

        return view('editprofile', $data);
    }

    public function resend ()
    {
        $user_data = User::find(Auth::id())->toArray();

        if($user_data['activation_code'] == null)
        {
            Session::flash('message', 'Already Activated');
            return Redirect::home();
        }

        $mail_data = array(
            'activation_code' => $user_data['activation_code']
        );

        Mail::send('emails.activate', $mail_data, function($message) use ($user_data)
        {
            $message->from('activation@emoonastudio.com', 'Emoona Studio')
                ->to($user_data['email'], $user_data['firstname'] . $user_data['lastname'])
                ->subject('Activate Your Account');
        });

        Session::flash('message', 'Activation Code Sent, Please Check Your E-Mail');
        return Redirect::home();
    }

    public function update (Request $req)
    {
        $rules = array (
            'firstname' => 'required',
            'lastname'  => 'required',
            'address'   => 'required',
            'postcode'  => 'required|numeric',
            'province'  => 'required',
            'country'   => 'required',
            'birthday'  => 'date|required',
            'gender'    => 'required',
            'phone'     => 'required|numeric'
        );

        $this->validate($req, $rules);

        $updated_data = array (
            'address'  => $req->input('address'),
            'postcode'  => $req->input('postcode'),
            'province'  => $req->input('province'),
            'country'  => $req->input('country'),
            'birthday'  => $req->input('birthday'),
            'gender'  => $req->input('gender'),
            'phone'  => $req->input('phone'),
        );

        $updated_data_core = array (
            'firstname' => $req->input('firstname'),
            'lastname'  => $req->input('lastname')
        );

        if(user_info::where('user_id', '=', Auth::id())->update($updated_data) && Auth::user()->update($updated_data_core))
            Session::flash('message', 'Updating Data Completed');
        else
            Session::flash('message', 'Update Failed');

        return Redirect::to('home');

    }
}
