<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserNotifications;
use App\User;
use App\user_info;
use App\user_notification;
use Validator;
use Hash;
use App\Mail\RegisterMail;
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
        $notifications = User::getNotifications();
        $data = ['notifications' => $notifications];
        return view('notifications', $data);
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
            return redirect('/');
        }

        $activation_code = $user_data['activation_code'];

        Mail::to($user_data['email'])->send(new RegisterMail($activation_code));

        return redirect('/profile')->with('success', 'Activation Code Sent, Please Check Your E-Mail');
    }

    function removeNotification ($id)
    {
        $notification = user_notification::find($id)->first();

        $notification->delete();

        return back();
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

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            $message = $validation->messages();

            return back()->withError($message);
        }else
        {
            $updated_data = array (
                'address'       => $req->input('address'),
                'postcode'      => $req->input('postcode'),
                'province'      => $req->input('province'),
                'country'       => $req->input('country'),
                'birthday'      => $req->input('birthday'),
                'gender'        => $req->input('gender'),
                'phone'         => $req->input('phone'),
                'newsletter'    => $req->input('newsletter') ? 1 : 0
            );

            $updated_data_core = array (
                'firstname' => $req->input('firstname'),
                'lastname'  => $req->input('lastname')
            );

            if(user_info::where('user_id', '=', Auth::id())->update($updated_data) && Auth::user()->update($updated_data_core))
            {
                if(Session::has('backUrl'))
                    return redirect(Session::pull('backUrl'))->with('success', 'Updating Data Completed');

                return back()->with('success', 'Updating Data Completed');
            }
            else
                return back()->withErrors('Update Failed');            
        }
    }

    function editPassword ()
    {
        return view('auth.passwords.edit');
    }

    function storePassword (Request $req)
    {
        $rules = [
            'old_password'      => 'required',
            'password'          => 'required|confirmed'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            $message = $validation->messages();
            return back()->withError($message);
        }else
        {
            try{
                $old = $req->old_password;
                $new = $req->password;

                if(!Hash::check($old, Auth::user()->password))
                    return back()->withErrors('Old password is incorrect');

                $user = Auth::user();

                $user->password = Hash::make($new);
                $user->save();

                return redirect('/profile')->with('success','Password Change was successful!');

            }catch(\Exception $e) {
                return back()->withErrors($e->getMessage());
            }
        }
    }
}
