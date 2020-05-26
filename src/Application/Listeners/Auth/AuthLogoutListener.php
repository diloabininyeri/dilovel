<?php


namespace App\Application\Listeners\Auth;

use App\Application\Models\Users;
use App\Interfaces\AuthEventListener;

class AuthLogoutListener implements AuthEventListener
{
    public function handle(Users $user):void
    {
        dd($user);
    }
}
