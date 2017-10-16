<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserNotifications;
use App\PaymentType;
use App\TransactionDetails;
use App\Transactions;
use App\user_notification;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    function checkoutCart (Request $req)
    {
        $data = ['cart' => Cart::getContent(), 'payment_type' => PaymentType::all()];

        return view('checkout', $data);
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
            $trans_detail->item_id          = $item->id;
            $trans_detail->item_detail_id   = $item->attributes['product_detail_id'];
            $trans_detail->quantity         = $item->quantity;

            $trans_detail->save();
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

        $mail_data = array(
            'transaction_code'  => $transaction->id,
            'cart'              => $cart
        );

        Mail::send('emails.transaction', $mail_data, function($message) use ($data)
        {
            $message->from('donotreply@emoonastudio.com', 'Emoona Studio')
                ->to($data['email'], $data['firstname'] . $data['lastname'])
                ->subject('Your Transaction Today');
        });

        //Clear the cart afterwards
        Cart::clear();

        //Return the view
        switch($req->input('payment_type'))
        {
            case 1:
            {
                //Transfer
                return view('payment/transfer', $data);
            }break;

            default:
            {
                abort(404);
            }break;
        }
    }

    function transactionDetail ($id)
    {
        
    }

    function verifyPayment ($id, Request $req)
    {
        return view('payment/verify');
    }
}
