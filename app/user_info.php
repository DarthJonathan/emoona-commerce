<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class user_info extends User
{
    protected $table = "user_info";
    protected $fillable = [
        'address', 'postcode', 'province', 'country', 'birthday', 'gender', 'suspended', 'newsletter'
    ];
    public $timestamps = false;

    public function user ()
    {
        return $this->belongsTo('App\User');
    }
}
