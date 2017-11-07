<?php

namespace App\Http\Controllers\admin;

use App\ItemDetail;
use App\Newsletter;
use App\PaymentType;
use App\User;
use Analytics;
use Spatie\Analytics\Period;
use Storage;
use App\Webconfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $slider     = Storage::files('public/img/home-slider');
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
        $data = ['newsletters' => $newsletters];
        return view('admin.newsletter.home', $data);
    }
}
