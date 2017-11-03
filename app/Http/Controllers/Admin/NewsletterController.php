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

                $when           = Carbon::parse($newsletter->blasted_date);
                $subcribers     = User::with('user_info')->where('newsletter', '=', 1)->get();

                foreach($subcribers as $person)
                {
                    Mail::to($person->email)->later($when, new NewsletterMail($newsletter));
                    $when = $when->addSecond(30);
                }

                return back();

            }catch (\Exception $e) {
                return back()->withErrors($e->getMessage());
            }
        }
    }

    function viewContent (Request $req)
    {
        $id = $req->id;

        $newsletter = Newsletter::find($id);

        return view('emails.newsletter',['newsletter' => $newsletter]);
    }
}
