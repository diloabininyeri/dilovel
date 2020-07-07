<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Auth\Permission\Role;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $role=new Role();
        $role->create('tester');
        $user = Users::find(18);
        $user->role()->assign('developer');

        return $user->role()->removeAll();
    }
}
