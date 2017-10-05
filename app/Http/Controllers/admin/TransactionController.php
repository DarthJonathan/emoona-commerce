<?php

namespace App\Http\Controllers\Admin;

use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    function getAll () {
        try
        {
            $transactions = Transactions::with('User', 'payment_type')->get()->toArray();

            return response()->json(['error' => false, 'transactions' => $transactions], 200);

        }catch (\Exception $e) {

            return response()->json(['error' => true, 'errors' => 'Error getting from database!', 'errors_debug' => $e->getMessage()], 400);

        }
    }

    function confirmPayment (Request $req) {
        try
        {
            $transaction = Transactions::find($req->input('id'));

            $transaction->status = 2;

            $transaction->save();

            $res = [
                'error' => false,
                'msg'   => 'Payment Confirmed!'
            ];

            return response()->json($res, 200);

        }catch (\Exception $e)
        {
            $res = [
                'error'         => true,
                'errors'        => 'Error Confirming Payment (Err: 511)',
                'errors_debug'  => $e->getMessage()
                ];

            return response()->json($res, 400);
        }
    }
}
