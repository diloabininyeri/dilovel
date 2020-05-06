<?php


namespace App\Application\Auth;

use App\Application\Models\Users;
use App\Components\Http\Request;
use JsonException;

/**
 * Class RouterAuth
 * @package App\Application\Auth
 */
class Admin
{

    /**
     * for specific router auth for example
     * @param Request $request
     * @return bool
     *"
     */
    public function isAuth(Request $request): bool
    {
        return  true;
    }
}
