<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;

class PrevNextTest
{
    public function index()
    {
        $users = Users::find(10);
        return $users->next();
    }
}
