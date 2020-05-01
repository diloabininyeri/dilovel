<?php


namespace App\Application\Auth;


use App\Components\Http\Request;

/**
 * Class RouterAuth
 * @package App\Application\Auth
 */
class Admin
{

    /**
     * for specific router auth for example
     * @return bool
     */
    public function isAuth():bool
    {
        return false;
    }

}