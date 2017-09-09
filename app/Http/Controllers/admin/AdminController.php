<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard ()
    {
        return view('admin/dashboard');
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
}
