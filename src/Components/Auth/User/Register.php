<?php


namespace App\Components\Auth\User;

use App\Application\Listeners\Auth\AuthRegisterListener;
use App\Application\Models\Users;
use App\Components\Auth\Listener;

/**
 * Class Register
 * @package App\Components\Auth\User
 */
class Register
{

    /**
     * @param array $data
     * @return bool|mixed|object|null
     */
    public static function user(array $data)
    {
        $user= Users::create($data);
        if ($user) {
            Listener::fire('register', $user);
        }
        return $user;
    }
}
