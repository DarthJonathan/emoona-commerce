<?php

namespace App\Http\Controllers\Admin;

use App\TicketDetails;
use App\Tickets;
use App\user_notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class SupportController extends Controller
{
    function openTicketAjax (Request $req)
    {
        $data = ['id' => $req->input('id'), 'user_id' => $req->input('user_id')];
        return view('admin/tickets/open_ticket', $data);
    }

    function openTicket (Request $req)
    {
        $rules = [
            'title'     => 'required',
            'category'  => 'required',
            'content'   => 'required',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            return response()->json(['error' => true, 'errors' => $validation->messages()], 400);
        }else
        {
            try {

                $ticket = new Tickets();
                $ticket_detail = new TicketDetails();

                $ticket->title      = $req->input('title');
                $ticket->category   = $req->input('category');
                $ticket->user_id    = $req->user_id;

                $ticket->save();

                $ticket_detail->ticket_id           = $ticket->id;
                $ticket_detail->text                = $req->input('content');
                $ticket_detail->replying_user_id    = Auth::id();

                //Create new user Notification
                $notification = new user_notification();

                $notification->user_id                  = $req->user_id;
                $notification->notification_name        = "New Message From Admin (" . $ticket->id . ")";
                $notification->notification_url         = "/tickets/" . $ticket->id;

                $notification->save();

                //TO:DO
                //Mail The customer

                $path = 'public/support_ticket/' . $ticket->id;

                /*
                    if($img = $req->image)
                    {
                        $additional = $img->store($path);
                        $ticket_detail->additionals = $additional;
                    }
                */

                $ticket_detail->save();

                return response()->json(['error' => false, 'msg' => 'Success Creating a Admin Message!'], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => 'Failed Creating Support Ticket (Er: 513)', 'errors_debug' => $e->getMessage()], 400);
            }
        }
    }

    function getTickets ()
    {
        try {
            $tickets = Tickets::with('ticket_detail')->get()->toArray();

            return response()->json(['error' => false, 'tickets' => $tickets], 200);

        }catch(\Exception $e) {

            return response()->json(['error' => true, 'errors' => 'Failed Getting Tickets (Er: 510)', 'errors_debug' => $e->getMessage()], 400);

        }
    }

    function replyTicketAjax (Request $req)
    {
        $data = ['id' => $req->input('id')];
        return view('admin/tickets/reply_ticket', $data);
    }

    function replyTicket (Request $req)
    {
        $rules = [
            'content'   => 'required',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            return response()->json(['error' => true, 'errors' => $validation->messages()], 400);
        }else
        {
            try {

                $ticket = Tickets::find($req->id);

                $ticket_detail = new TicketDetails ();

                $ticket_detail->text                = $req->input('content');
                $ticket_detail->ticket_id           = $req->input('id');
                $ticket_detail->replying_user_id    = Auth::id();

//                $path = 'public/support_ticket/' . $req->id;
//
//                if($img = $req->image)
//                {
//                    $additional = $img->store($path);
//
//                    $ticket_detail->additionals = $additional;
//                }

                //Create new user Notification
                $notification = new user_notification();

                $notification->user_id                  = $ticket->user_id;
                $notification->notification_name        = "New Message From Admin (" . $req->id . ")";
                $notification->notification_url         = "/tickets/" . $req->id;

                $notification->save();

                $ticket_detail->save();

                return response()->json(['error' => false, 'msg' => 'Success Replying Support Ticket!', 'id' => $req->id], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => 'Failed Replying Support Ticket (Er: 514)', 'errors_debug' => $e->getMessage()], 400);
            }
        }
    }

    function completeTicket (Request $req)
    {
        try {

            $ticket = Tickets::find($req->id);

            $ticket->completed = date("Y-m-d H:i:s");

            $ticket->save();

            return response()->json(['error' => false, 'msg' => 'Success Replying Support Ticket!', 'id' => $req->id], 200);

        }catch(\Exception $e)
        {
            return response()->json(['error' => true, 'errors' => 'Failed Replying Support Ticket (Er: 514)', 'errors_debug' => $e->getMessage()], 400);
        }
    }
}
