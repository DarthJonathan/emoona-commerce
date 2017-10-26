<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDetails extends Model
{
    protected $table = 'tickets_detail';

    protected $fillable = [
        'ticket_id', 'text', 'additionals'
    ];

    function ticket ()
    {
        return $this->hasOne('App\Tickets', 'id', 'ticket_id');
    }

    function replying_user ()
    {
        return $this->hasOne('App\User', 'id', 'replying_user_id');
    }
}
