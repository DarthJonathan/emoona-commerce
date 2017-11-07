<?php

namespace App\Http\Controllers\admin;

use App\TransactionDetails;
use App\Transactions;
use App\User;
use App\users_groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function userinfo (Request $req)
    {
        $id = $req->input('id');

        $users = User::with('user_info')->where('id', '=' , $id)->first();

        $data = ['user' => $users];

        return view('admin.user_info', $data);
    }

    public function userTransactions (Request $req)
    {
        $user_id = $req->input('id');

        $transactions = Transactions::with('transaction_detail', 'payment_type')->where('user_id', '=', $user_id)->get()->toArray();

        $data = ['transactions' => $transactions];

        return view('usertransaction', $data);
    }

    public function userTransactionDetails (Request $req)
    {
        try {
            $id = $req->input('id');

            $transaction_details = TransactionDetails::with('item', 'item_detail')->where('transaction_id', '=', $id)->get();

            $data = ['transactions' => $transaction_details];

            return view('admin.transactiondetails', $data);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => $e->getMessage()], 400);
        }
    }

    function demoteAdmin (Request $req)
    {
        $id = $req->id;

        $group = users_groups::where('user_id', '=', $id)->first();
        $group->group_id = 2;
        $group->save();

        return response()->json(['error' => false, 'msg' => 'User admin rights have been revoked'], 200);
    }

    function makeAdmin (Request $req)
    {
        $id = $req->id;

        $group = users_groups::where('user_id', '=', $id)->first();
        $group->group_id = 1;
        $group->save();

        return response()->json(['error' => false, 'msg' => 'User have been given admin rights'], 200);
    }

    public function suspend (Request $req)
    {
        $id = $req->id;

        $suspended = User::with('user_info')->where('id', '=', $id)->get()->toArray()[0]['user_info']['suspended'];

        if($suspended == null || $suspended == 0) {
            $to_be = 1;
            $msg = "User Suspended";
        }
        else {
            $to_be = 0;
            $msg = "User Unsuspended";
        }

        User::find($id)->user_info()->update(
            array(
                'suspended' => $to_be
            )
        );

        echo $msg;
    }

    public function removeUser (Request $req)
    {
        try
        {
            User::with('user_info', 'user_group')->where('id', $req->input('id'))->first()->delete();
            echo json_encode(['error' => false, 'msg' => 'User Removal Success!']);
        }catch(\Exception $e)
        {
            echo json_encode(['error' => true, 'msg' => $e]);
        }
    }
}
