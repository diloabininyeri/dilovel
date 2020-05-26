<?php


namespace App\Application\Listeners\Auth;

use App\Application\Models\Users;
use App\Interfaces\AuthEventListener;

/**
 * Class AuthLoginListener
 * @package App\Application\Listeners\Auth
 */
class AuthLoginListener implements AuthEventListener
{

    /**
     * @param Users $user
     */
    public function handle(Users $user):void
    {
        $user->last_login_at=now();
        $user->save();
        //redirect()->router('home');
    }
}
