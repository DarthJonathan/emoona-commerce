<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $table = 'transaction_detail';
    protected $fillable = [
        'quantity'
    ];

    public function transaction ()
    {
        return $this->belongsTo('App\Transactions','transaction_id', 'id');
    }

    function item ()
    {
        return $this->hasOne('App\Item', 'id', 'item_id');
    }

    function item_detail ()
    {
        return $this->hasOne('App\ItemDetail', 'id', 'item_detail_id');
    }
}
