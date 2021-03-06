<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserNotifications;
use App\ItemDetail;
use App\PaymentType;
use App\TransactionDetails;
use App\Transactions;
use App\user_notification;
use App\Mail\TransactionMail;
use App\Webconfig;
use Cart;
use Validator;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Image;
use Session;

class TransactionController extends Controller
{
    function checkoutCart (Request $req)
    {
        $data = ['cart' => Cart::getContent(), 'payment_type' => PaymentType::all()];

        return view('transaction.pCheckout', $data);
    }

    function payment (Request $req)
    {
        $cart = Cart::getContent();
        $data = ['cart' => $cart];

        $transaction = new Transactions();

        $transaction->user_id           = Auth::id();
        $transaction->payment_type_id   = $req->input('payment_type');
        $transaction->status            = 0;
        $transaction->notes             = null;

        $transaction->save();

        //Create new Transaction detail for every item purchased
        foreach($cart as $item)
        {
            $trans_detail = new TransactionDetails();

            $trans_detail->transaction_id   = $transaction->id;
            $trans_detail->item_id          = $item->attributes['product_id'];
            $trans_detail->item_detail_id   = $item->attributes['product_detail_id'];
            $trans_detail->quantity         = $item->quantity;

            $trans_detail->save();

            //Decrease the stock
            $item_detail = ItemDetail::find($trans_detail->item_detail_id);
            $item_detail->stock = $item_detail->stock - 1;
            $item_detail->save();
        }

        //Make a new User Notification to pay
        $notification = new user_notification();

        $notification->user_id              = Auth::id();
        $notification->notification_name    = "Transaction Number " . $transaction->id;
        $notification->notification_url     = '/transactions/' . $transaction->id;

        $notification->save();

        //Email the customer for making a new transaction
        $data['email']          = Auth::user()->email;
        $data['firstname']      = Auth::user()->firstname;
        $data['lastname']       = Auth::user()->lastname;

        $data['transaction']    = [
            'transaction_code'  => $transaction->id,
            'cart'              => $cart
        ];

        Mail::to($data['email'])->send(new TransactionMail($data));

        Session::put('payment_type', $req->payment_type);
        return redirect('/payment.screen');
    }

    function paymentScreen(Request $req)
    {
        //Clear the cart afterwards
        Cart::clear();

        switch(Session::get('payment_type'))
        {
            case 1:
            {
                //Transfer
                $data = ['info' => PaymentType::find(1)];
                return view('payment/transfer', $data);
            }break;

            default:
            {
                abort(404);
            }break;
        }
    }

    function transferInformation ()
    {
        return view('payment/transfer');
    }

    function transactionDetail ($id)
    {
        try
        {
            $transaction        = Transactions::with('transaction_detail', 'payment_type')->where('id', '=', $id)->first();
            $transaction_detail = TransactionDetails::with('item', 'item_detail')->where('transaction_id', '=', $id)->get();

            if($transaction->user_id != Auth::id())
                return redirect('/');

            $data = ['transaction' => $transaction, 'transaction_detail' => $transaction_detail];

            return view('transaction/transaction', $data);

        }catch(\Exception $e)
        {
            abort(404);
        }
    }

    function verifyPayment ($id, Request $req)
    {
        $config = PaymentType::find(1);
        $data = ['id' => $id, 'payment' => $config];
        return view('transaction/verify_payment', $data);
    }

    function verifyPaymentSubmit (Request $req)
    {
        try {
            $rules = [
                'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPG,JPEG,PNG'
            ];

            $validator = Validator::make($req->all(), $rules);

            if($validator->fails())
            {
                $message = $validator->messages();

                $return = ['error' => true, 'errors' => $message];

                return response()->json($return, 400);
            }else {

                $path = 'public/payment_verification/' . $req->input('id') . '/' . uniqid() . '.jpg';

                if(!file_exists(storage_path('app/public/payment_verification/' . $req->id)))
                    mkdir(storage_path('app/public/payment_verification/' . $req->id));

                $saved_path = $req->image->getRealPath();
                Image::make($saved_path)
                    ->resize(1000, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                    ->encode('jpg', 45)
                    ->interlace()
                    ->save(storage_path('app/' . $path));

                $transaction = Transactions::find($req->id);

                //Delete The Old One
                if($transaction->transfer_proof != null)
                    Storage::delete($transaction->transfer_proof);

                //Write the transfer proof path
                $transaction->transfer_proof = $path;
                $transaction->status = 1;
                $transaction->save();

                $return = ['error' => false, 'msg' => 'Payment Verification Image Uploaded!'];

                return response()->json($return, 200);

            }

        }catch(\Exception $e) {

            $return = ['error' => true, 'errors' => 'Uploading Verification Image Error', 'errors_debug' => $e->getMessage()];

            return response()->json($return, 400);

        }
    }

    function viewPaymentProof (Request $req)
    {
        $transaction = Transactions::find($req->id);

        $data = ['file' => $transaction->transfer_proof];

        return view('transaction.payment_proof', $data);
    }

    function orderHistory()
    {
        $orders = Transactions::with('transaction_detail', 'payment_type')->where('user_id','=', Auth::id())->get();

        $data = ['orders' => $orders, 'title' => 'Order History'];

        return view('order_history', $data);
    }

    function pendingOrders ()
    {
        $orders = Transactions::with('transaction_detail', 'payment_type')->where([['user_id','=', Auth::id()], ['status','<', '3']])->get();

        $data = ['orders' => $orders, 'title' => 'Pending Orders'];

        return view('order_history', $data);
    }
}
