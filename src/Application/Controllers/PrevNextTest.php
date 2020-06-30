<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;

class PrevNextTest
{
    public function index()
    {
        $user = Users::find(25);

        return $user->prev();
        return   $user->next();
    }
}
