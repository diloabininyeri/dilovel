<?php


namespace App\app\Controllers;


use App\app\Request\TcNoVerifyRequest;
use App\Http\Request;
use App\app\Models\Users;


/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @param TcNoVerifyRequest $request
     * @return false|string
     */
    public function index(TcNoVerifyRequest $request)
    {
        $users=Users::get();
        return view('index', compact('users'));


    }
}