<?php

namespace App;

use App\Mail\ActivateUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'activation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_info ()
    {
        return $this->hasOne('App\user_info');
    }

    public function users_groups ()
    {
        return $this->hasOne('App\users_groups', 'user_id', 'user_id');
    }

    /**
     * checkCompletion
     * check for user data completion
     *
     * @return boolean
     */
    private static function checkCompletion ()
    {
        $elsecheck = user_info::where('user_id', Auth::id())->first()->toArray();
        $data = 0;
        $completed = 0;

        //Check if user profile is completed
        if($elsecheck['address'] != null)
        {
            $completed++;
            $data++;
        }else
            $data++;

        if($elsecheck['postcode'] != null)
        {
            $completed++;
            $data++;
        }else
            $data++;

        if($elsecheck['province'] != null)
        {
            $completed++;
            $data++;
        }else
            $data++;

        if($elsecheck['country'] != null)
        {
            $completed++;
            $data++;
        }else
            $data++;

        if($elsecheck['gender'] != null)
        {
            $completed++;
            $data++;
        }else
            $data++;

        if($completed/$data == 1)
            return true;
        else
            return false;
    }

    /**
     * getNotificationTable
     * get from user_notification table
     *
     * @return: array
     *
     */
    public static function getNotificationTable ()
    {
        $notifications = array ();

        try {
            $notifications = user_notification::where('user_id', '=', Auth::id())->get()->toArray();
        } catch (ModelNotFoundException $e)
        {
            $notifications = null;
        }

        return $notifications;
    }

    public static function getNotifications ()
    {
        $checkingUser = self::find(Auth::id())->toArray();

        $notifications = array();

        //Check if user is activated
        if($checkingUser['activation_code'] != null){
            $notifications['User not activated'] = '/resend_activation';
        }

        //Check user completion
        if(!self::checkCompletion())
        {
            $notifications['User data not completed'] = '/profile/edit';
        }

        foreach(User::getNotificationTable() as $notif)
        {
            $notif_name = $notif['notification_name'];
            $notif_url = $notif['notification_url'];
            $notifications[$notif_name] = $notif_url;
        }

        return $notifications;
    }
}
