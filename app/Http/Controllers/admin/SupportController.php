<?php

namespace App\Http\Controllers\Admin;

use App\TicketDetails;
use App\Tickets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

                $ticket->save();

                $ticket_detail->ticket_id = $ticket->id;
                $ticket_detail->text = $req->input('content');

                $path = 'public/support_ticket/' . $ticket->id;

                if($img = $req->image)
                {
                    $additional = $img->store($path);

                    $ticket_detail-$additional = $additional;
                }
                $ticket_detail->save();

                return response()->json(['error' => false, 'msg' => 'Success Creating a Support Ticket!'], 200);

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

                $ticket_detail = new TicketDetails ();

                $ticket_detail->text        = $req->input('content');
                $ticket_detail->ticket_id   = $req->input('id');

                $path = 'public/support_ticket/' . $req->id;

                if($img = $req->image)
                {
                    $additional = $img->store($path);

                    $ticket_detail-$additional = $additional;
                }
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
