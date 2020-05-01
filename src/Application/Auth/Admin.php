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
     * @throws JsonException
     */
    public function isAuth(Request $request): bool
    {

        $request->session()->set('admin', Users::find(1)->toArray());

        if ($request->session()->exists('admin')) {
            return true;
        }
        return false;

    }

}