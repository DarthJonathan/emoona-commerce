<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewsletterMail;
use App\Newsletter;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Mail;

class NewsletterController extends Controller
{
    function newNewsletter (Request $req)
    {
        $rules = [
            'title'     => 'required',
            'blast'     => 'required|date',
            'content'   => 'required'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            $message = $validation->messages();
            return back()->withErrors($message);
        }else
        {
            try {

                $newsletter = new Newsletter();

                $newsletter->title          = $req->title;
                $newsletter->content        = $req->input('content');
                $newsletter->blasted_date   = $req->blast;

                $newsletter->save();

                $when = Carbon::parse($req->blast);

                $time_difference = $when->diffInDays(Carbon::now());
                $subcribers     = User::whereHas('user_info', function ($query) {
                                    $query->where('newsletter', '=', 1);
                                  })->get();;

                foreach($subcribers as $person)
                {
                    Mail::to($person->email)->queue((new NewsletterMail($newsletter))->delay($time_difference));
                    $time_difference = $when->addSeconds(30)->diffInDays(Carbon::now());
                }

                return back();

            }catch (\Exception $e) {
                return $e->getMessage();
                return back()->withErrors($e->getMessage());
            }
        }
    }

    function viewContent (Request $req)
    {
        $id = $req->id;

        $newsletter = Newsletter::find($id);

        return new NewsletterMail($newsletter);
    }
}
