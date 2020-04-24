<?php


namespace App\app\Controllers;


use App\Http\Request;
use App\app\Models\Users;
use const App\Database\config;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function index(Request $request)
    {
        $users=Users::get();
        return view('index', compact('users'));


    }
}