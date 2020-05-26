<?php


namespace App\Components\Auth\Hash;

/**
 * Class Hash
 * @package App\Components\Auth\Hash
 */
class Hash
{

    /**
     * @param $password
     * @return false|string|null
     */
    public static function make($password)
    {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }


    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function check($password, $hash): bool
    {
        return password_verify($password, $hash);
    }
}
