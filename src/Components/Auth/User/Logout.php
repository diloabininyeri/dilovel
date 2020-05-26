<?php


namespace App\Components\Auth\User;

use App\Application\Models\Users;
use App\Components\Auth\Listener;
use App\Components\Http\Session;
use Closure;

/**
 * Class Logout
 * @package App\Components\Auth\User
 */
class Logout
{

    /**
     * Logout constructor.
     */
    public function __construct()
    {
        $session=new Session();
        $userId = $session->get(Enums::USER_AUTH_SESSION_NAME);
        $session->delete(Enums::USER_AUTH_SESSION_NAME);
        if ($userId) {
            Listener::fire('logout', Users::find($userId));
        }
    }

    /**
     * @param Closure $closure
     * @return mixed
     */
    public function after(Closure $closure)
    {
        return $closure();
    }
}
