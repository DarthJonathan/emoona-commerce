<?php

namespace App\Http\Controllers\Auth;

use App\Mail\RegisterMail;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birthday'  => 'required|date'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(isset($_POST['newsletter']))
        {$newsletter = 1;}
        else
        {$newsletter = 0;}

        $activation_code = time().uniqid();

        //Backward compability to old browsers
        $birthday = Carbon::parse($data['birthday'])->format('Y-m-d');


        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'activation_code' => $activation_code,
            'password' => bcrypt($data['password']),
        ])->user_info()->create([
            'newsletter' => $newsletter,
            'birthday' => $birthday
        ])->users_groups()->create([
            'group_id' => 2
        ]);

        Mail::to($data['email'])->send(new RegisterMail($activation_code));

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function register(Request $request)
     {
         $this->validator($request->all())->validate();
 
         event(new Registered($user = $this->create($request->all())));
 
         $this->guard()->login($user);
 
         return redirect($this->redirectPath())->with('success', 'Success Creating a new Account, please login');
     }
}