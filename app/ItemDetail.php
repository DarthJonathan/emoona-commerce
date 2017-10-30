<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemCategory;

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
}
