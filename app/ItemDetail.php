<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    protected $table = 'item_detail';

    protected $fillable = [
        'color',
        'stock',
        'image',
        'size',
        'status'
    ];

    function item ()
    {
        return $this->belongsTo('App\Item');
    }


}
