<?php

namespace App\Http\Controllers;

use App\TicketDetails;
use App\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class SupportController extends Controller
{
    function allTickets ()
    {
        $tickets = Tickets::with('ticket_detail')->where('user_id', '=', Auth::id())->get();
        $data = ['tickets' => $tickets];
        return view('ticketing', $data);
    }

    function getTickets (Request $req)
    {
        $tickets = TicketDetails::where(['ticket_id' => $req->id])->get();
        return response()->json(['error' => false, 'tickets' => $tickets],200);
    }

    function newTicket (Request $req)
    {
        $rules = [
            'title'         => 'required',
            'category'      => 'required',
            'message'       => 'required'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            return response()->json(['error' => true, 'errors' => $validation->messages()],400);
        }else
        {
            try
            {
                $ticket = new Tickets();
                $ticket_detail = new TicketDetails();

                $ticket->title      = $req->input('title');
                $ticket->category   = $req->input('category');
                $ticket->user_id    = Auth::id();

                $ticket->save();

                $ticket_detail->ticket_id           = $ticket->id;
                $ticket_detail->text                = $req->input('message');
                $ticket_detail->replying_user_id    = Auth::id();

//                $path = 'public/support_ticket/' . $ticket->id;
//
//                if($img = $req->image)
//                {
//                    $additional = $img->store($path);
//
//                    $ticket_detail->additionals = $additional;
//                }

                $ticket_detail->save();

                return response()->json(['error' => false, 'msg' => 'New Ticket Posted!'], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => ['Error Creating Ticket (Err: 1200)'], 'errors_debug' => $e->getMessage()], 400);
            }
        }
    }

    function replyTicket (Request $req)
    {
        $rules = [
            'reply' => 'required'
        ];

        $validation = Validator::make($req->all(), $rules);

        if($validation->fails())
        {
            return response()->json(['error' => true, 'errors' => $validation->messages()],400);
        }else
        {
            try
            {
                $ticket = new TicketDetails();

                $ticket->ticket_id          = $req->id;
                $ticket->replying_user_id   = Auth::id();
                $ticket->text               = $req->reply;
                $ticket->additionals        = null;

                $ticket->save();

                return response()->json(['error' => false, 'msg' => 'Reply Posted!'], 200);

            }catch(\Exception $e)
            {
                return response()->json(['error' => true, 'errors' => 'Error Creating Reply (Err: 1200)', 'errors_debug' => $e->getMessage()], 400);
            }
        }
    }

    function viewTicket ($id)
    {
        $tickets = Tickets::with('ticket_detail')->where('user_id', '=', Auth::id())->get();
        $data = ['tickets' => $tickets, 'toggle' => $id];
        return view('ticketing', $data);
    }
}
