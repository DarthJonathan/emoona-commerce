<?php

namespace App\Http\Controllers\Admin;

use App\ItemDetail;
use App\Newsletter;
use App\PaymentType;
use App\HomeSlider;
use App\User;
use Analytics;
use App\user_info;
use Spatie\Analytics\Period;
use Storage;
use App\Webconfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Social; 
use App\StudioCategory; 
use App\StudioItem; 

class AdminController extends Controller
{
    public function dashboard ()
    {
        $last_week      = Analytics::fetchTotalVisitorsAndPageViews(Period::days(6));
        $most_visited   = Analytics::fetchMostVisitedPages(Period::days(1), 2);
        $user_type      = Analytics::fetchUserTypes(Period::days(1));

        $data = [
            'last_week'     => $last_week,
            'most_visited'  => $most_visited,
            'user_type'     => $user_type
            ];

        return view('admin/dashboard', $data);
    }

    public function accounts ()
    {
        $data = array (
            'accounts' => User::with('user_info')
                            ->whereHas('user_group', function ($query){
                                $query->where('group_id', '=', 2);
                            })
                            ->get()
                            ->toArray(),
            'admins'   =>  User::with('user_info')
                                ->whereHas('user_group', function ($query){
                                    $query->where('group_id', '=', 1);
                                })
                                ->get()
                                ->toArray()
        );

        return view('admin/accounts', $data);
    }

    public function items()
    {
        return view('admin/items');
    }

    public function confirmDelete (Request $req)
    {
        $data = array('type' => $req->input('type'), 'id' => $req->input('id'));
        return view('confirm', $data);
    }

    public function prompt (Request $req)
    {
        $data = ['id' => $req->input('id'), 'type' => $req->input('type')];
        return view('admin/prompt', $data);
    }

    public function tickets ()
    {
        return view('admin/tickets/tickets');
    }

    public function transactions ()
    {
        return view('admin/transactions/transactions');
    }

    public function webConfiguration ()
    {
        $slider     = HomeSlider::orderBy('display_order')->get();
        $collection = Storage::files('public/img/home-collections');
        $payment    = PaymentType::all();

        $data = [
            'settings'      => Webconfig::all(),
            'slider'        => $slider,
            'collections'   => $collection,
            'payment'       => $payment
        ];

        return view('admin/webconfig/main', $data);
    }

    public function newsletter ()
    {
        $newsletters = Newsletter::limit(30)->get();
        $subscribers = user_info::with('User')->where('newsletter', '=', 1)->get();

        $data = [
            'newsletters'   => $newsletters,
            'subscribers'   => $subscribers
        ];
        return view('admin.newsletter.home', $data);
    }

    function editProfile ()
    {
        $data = Auth::user()->toArray();

        return view('editprofile', $data);
    }

    function changePassword ()
    {
        return view('auth.passwords.edit');
    }

    function storeProfile (Request $req)
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
                return redirect('/admin')->with('success', 'Admin user data updated!');
            else
                return redirect('/admin')->with('error', 'Admin user data update failed!');
        }
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

                return redirect('/admin')->with('success','Password Change was successful!');

            }catch(\Exception $e) {
                return back()->withErrors($e->getMessage());
            }
        }
    }

    public function studio() 
    { 
        $category = StudioCategory::orderBy('template','asc')->get(); 
        $item = StudioItem::orderBy('category_id','asc')->get(); 
        $data = [ 
            'categories' => $category, 
            'items' => $item 
            ]; 
        return view('admin.studio',$data); 
    } 
 
    public function social() 
    { 
        $photos = Social::get(); 
        $data = ['photos' => $photos]; 
 
        return view('admin.social', $data); 
    } 
}
