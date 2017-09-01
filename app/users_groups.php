<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class users_groups extends User
{
    protected $table = 'users_groups';

    protected $fillable = [
        'group_id'
    ];

    public $timestamps = false;

    public function user ()
    {
        return $this->belongsTo('App\User');
    }
}
