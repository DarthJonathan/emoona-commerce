<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_notification extends Model
{
    protected $table = "user_notification";
    protected $fillable = [
        'notification_name', 'notification_url'
    ];
    public $timestamps = false;
}