<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $table = 'home_slider';

    protected $fillable = [
        'display_order',
        'image',
        'url'
    ];

    function getNewOrder ()
    {
        $last = $this->orderBy('id', 'DESC')->first();

        if($last == null)
            return 0;
        else
        {
            $order = $last->display_order + 1;
            return $order;
        }
    }
}
