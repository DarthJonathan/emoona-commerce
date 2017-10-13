<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
      'title', 'category'
    ];

    function ticket_detail ()
    {
        return $this->hasMany('App\TicketDetails', 'ticket_id', 'id');
    }
}
