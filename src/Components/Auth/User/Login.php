<?php


namespace App\Components\Auth\User;

use App\Application\Models\Users;
use App\Components\Auth\Listener;
use App\Components\Database\Model;
use App\Components\Http\Session;

class Login
{
    public static function user(Model $user)
    {
        $session = new Session();
        $session->set(Enums::USER_AUTH_SESSION_NAME, $user->getPrimaryKeyValue());
        if ($session->get(Enums::USER_AUTH_SESSION_NAME)) {
            Listener::fire('login', $user);
        }
        return $session->exists(Enums::USER_AUTH_SESSION_NAME);
    }
}
