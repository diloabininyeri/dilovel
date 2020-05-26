<?php


namespace App\Components\Auth\User;

use App\Components\Database\Model;
use App\Components\Http\Session;

class Login
{
    public static function user(Model $user)
    {
        $session = new Session();
        return $session->set(Enums::USER_AUTH_SESSION_NAME, $user->getPrimaryKeyValue());
    }
}
