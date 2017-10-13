<?php

namespace App\Http\Controllers\Admin;

use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

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

    function addTrackingCodeAjax (Request $req)
    {
        $data = ['transaction_id' => $req->input('id')];

        return view('admin.transactions.add_tracking_code', $data);
    }

    function addTrackingCode (Request $req)
    {
        $rules = [
            'transaction_id' => 'required',
            'code'           => 'required|alpha_num'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails()) {

            $message = $validation->messages();

            $return = ['error' => true, 'errors' => $message];

            return response()->json($return, 400);

        }else {

            try {

                $transaction_id = $req->input('transaction_id');
                $tracking_code  = $req->input('code');

                $transaction = Transactions::find($transaction_id);

                $transaction->shipping_codes = $tracking_code;
                $transaction->status = 3;

                $transaction->save();

                return response()->json(['error' => false, 'msg' => 'Setting Tracking Code Completed']);

            }catch(\Exception $e) {

                $return = ['error' => true, 'errors' => 'Storing into Database Failed (ERR: 011)', 'errors_debug' => $e->getMessage()];

                return response()->json($return, 400);

            }
        }
    }
}
