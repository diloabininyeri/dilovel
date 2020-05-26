<?php


namespace App\Components\Auth\User;

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
        $session->delete(Enums::USER_AUTH_SESSION_NAME);
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
