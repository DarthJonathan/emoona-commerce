<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'item_category';

    protected $fillable = [
      'name', 'description', 'gender'
    ];
}
