<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ActivateAccountController extends Controller
{
    public function activate ($activation_code)
    {
        try {

            $user = User::where('activation_code', '=', $activation_code)->firstOrFail();

            $user->activation_code = null;

            $user->save();

        }catch (ModelNotFoundException $e)
        {
            return abort(404);
        }

        return view ('activated');
    }
}
