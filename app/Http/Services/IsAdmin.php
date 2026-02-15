<?php

namespace App\Http\Services;

class IsAdmin
{
    public static function check()
    {
        $user = \Auth::user();
        if ($user->role_id == 1) {
            return true;
        }

        return false;
    }
}