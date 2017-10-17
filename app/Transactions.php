<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'status', 'notes', 'transfer_proof'
    ];

    protected $dates = [
        'created',
        'finished'
    ];

    function user ()
    {
        return $this->belongsTo('App\User');
    }

    function payment_type ()
    {
        return $this->hasOne('App\PaymentType','id', 'payment_type_id');
    }

    function transaction_detail ()
    {
        return $this->hasMany('App\TransactionDetails', 'transaction_id', 'id');
    }
}
