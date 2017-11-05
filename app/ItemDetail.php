<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemCategory;
use App\Discount;

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
        return $this->hasOne('App\Item', 'id', 'item_id');
    }

    function getCategory ()
    {
        $category = $this->item()->first()->category_id;
        $category = ItemCategory::find($category);
        return $category;
    }

    function getDiscount()
    {
        $discount = Discount::where('item_detail_id', '=', $this->id)->first();

        if($discount == null)
            return 0;
        else
            return $discount->amount;
    }
}