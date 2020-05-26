<?php


namespace App\Components\Auth\User;

use App\Application\Models\Users;

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
        return Users::create($data);
    }
}
