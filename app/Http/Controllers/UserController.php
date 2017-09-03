<?php

namespace App\Http\Controllers;

use App\User;
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
        return view('editprofile');
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

    }
}
