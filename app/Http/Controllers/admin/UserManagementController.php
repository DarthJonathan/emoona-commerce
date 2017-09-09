<?php

namespace App\Http\Controllers\admin;

use App\TransactionDetails;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function userinfo (Request $req)
    {
        $id = $req->input('id');

        $users = User::with('user_info')->where('id', '=' , $id)->get()->toArray()[0];

        echo json_encode($users);
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
        $id = $req->input('id');

        $transaction_details = TransactionDetails::with('item', 'item_detail')->where('transaction_id', '=', $id)->get()->toArray();

        echo json_encode($transaction_details);
    }

    public function suspend ()
    {
        $id = 22;

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

    public function confirmDelete (Request $req)
    {
        $data = array('type' => $req->input('type'), 'id' => $req->input('id'));
        return view('confirm', $data);
    }

    public function removeUser (Request $req)
    {
        User::with('user_info', 'user_group')->where('id', $req->input('id'))->first()->delete();
        echo 'Delete Complete';
    }
}
