<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
      'name', 'sku', 'description', 'price', 'hidden', 'category_id', 'preorder'
    ];

    public $dates = ['created'];

    function item_detail ()
    {
        return $this->hasMany('App\ItemDetail');
    }
}
