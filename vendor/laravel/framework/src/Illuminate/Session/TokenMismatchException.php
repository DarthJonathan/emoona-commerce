<?php

namespace Illuminate\Session;

use Exception;
use Illuminate\Http\Request;

class TokenMismatchException extends Exception
{
    public function render(Request $request, Exception $e)
    {
        if($e instanceof \Illuminate\Session\TokenMismatchException)
        {
            return redirect()
                ->back()
                ->withInput($request->except('password'))
                ->with([
                    'message' => 'Session Timed Out',
                    'message-type' => 'danger']);
        }

        return parent::render($request, $e);
    }
}
