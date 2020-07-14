<?php


namespace App\Application\Controllers;

use App\Application\Models\Role;
use App\Application\Models\Users;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $users=Users::with('roles')->get();
        dd($users);
    }
}
