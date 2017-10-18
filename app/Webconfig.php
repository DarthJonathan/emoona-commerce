<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webconfig extends Model
{
    protected $fillable = [
        'name', 'value_1', 'value_2', 'value_3'
    ];

    protected $table = 'webconfig';
}
