<?php


namespace App\Application\Listeners\Auth;

use App\Application\Models\Users;
use App\Interfaces\AuthEventListener;

/**
 * Class AuthRegisterListener
 * @package App\Application\Listeners\Auth
 */
class AuthRegisterListener implements AuthEventListener
{

    /**
     * @param Users $user
     */
    public function handle(Users $user): void
    {
        // TODO: Implement handle() method.
    }
}
