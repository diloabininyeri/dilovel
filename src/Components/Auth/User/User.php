<?php


namespace App\Components\Auth\User;


class User
{


    public function login(array $user): Login
    {
        return new Login();
    }

    public function logout(): Logout
    {
        return new Logout();
    }

    public function register(): Register
    {
        return new Register();
    }

    public function check():bool
    {

    }

    public function get()
    {

    }
}
