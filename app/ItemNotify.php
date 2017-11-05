<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\ItemDetail;

class ItemNotify extends Model
{
    protected $table = 'item_notify';

    protected $fillable = [
        'item_id', 'user_id', 'category'
    ];

    function getItem()
    {
        if($this->category == 'preorder')
            return ItemDetail::with('item')->where('id', '=',$this->item_id)->first();
        else if($this->category == 'no-stock')
            return Item::find($this->item_id);
    }
}
