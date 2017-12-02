<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewsletterMail;
use App\Newsletter;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;
use Mail;
use Image;

class NewsletterController extends Controller
{
    function __construct ()
    {
        ini_set('memory_limit','512M');
    }

    function newNewsletter (Request $req)
    {
        $rules = [
            'title'     => 'required',
            'blast'     => 'required|date',
            'content'   => 'required',
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image.*'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            $message = $validation->messages();
            return redirect('/admin/newsletter')->withErrors($message);
        }else
        {
            try {

                $newsletter = new Newsletter();
                
                $path = time();
                $fullpath = storage_path('app/public/newsletter/' . $path);

                $newsletter->title          = $req->title;
                $newsletter->content        = $req->input('content');
                $newsletter->blasted_date   = $req->blast;

                if($req->image)
                {
                    $newsletter->images         = $path;
                    mkdir($fullpath);
                    Image::make($req->image->getRealPath())->encode('jpg', 75)->interlace()->save($fullpath . '/image.jpg');
                }else
                {
                    $newsletter->images         = null;
                }

                $newsletter->save();

                $when = Carbon::parse($req->blast);

                $time_difference = $when->diffInDays(Carbon::now());
                $subcribers     = User::whereHas('user_info', function ($query) {
                                    $query->where('newsletter', '=', 1);
                                  })->get();;

                foreach($subcribers as $person)
                {
                    Mail::to($person->email)->queue((new NewsletterMail($newsletter, $person->id))->delay($time_difference));
                    $time_difference = $when->addSeconds(30)->diffInDays(Carbon::now());
                }

                return redirect('/admin/newsletter')->with('msg', 'Newsletter created!');

            }catch (\Exception $e) {
                return redirect('/admin/newsletter')->withErrors($e->getMessage());
            }
        }
    }

    function viewContent (Request $req)
    {
        $id = $req->id;

        $newsletter = Newsletter::find($id);

        return new NewsletterMail($newsletter, '0');
    }

    function previewNewsletter (Request $req)
    {
        $newsletter = new Newsletter();

        $newsletter->title      = $req->title;
        $newsletter->content    = $req->content;
        $newsletter->images     = 'preview';

        return new NewsletterMail($newsletter, '0');
    }

    function changeNewsletterBanner (Request $req)
    {
        $rules = [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image.*'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            return back()->withErrors($validation->messages());
        }else{
            try {
                $fullpath = storage_path('app/public/newsletter/banner.jpg');

                Storage::delete('public/newsletter/banner.jpg');

                Image::make($req->image->getRealPath())
                    ->encode('jpg', 75)
                    ->interlace()
                    ->fit(1440, 200)
                    ->save($fullpath);

                return back()->with('success', 'Newsletter Header Changed!');
            }catch(\Exception $e)
            {
                return back()->withErrors($e->getMessage());
            }
        }
    }
}
