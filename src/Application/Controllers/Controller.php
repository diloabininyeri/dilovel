<?php


namespace App\Application\Controllers;


use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Http\Request;

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
    public function index(TcNoVerifyRequest $request)
    {
        return  Users::get('id')->implode(); //1,2,5.....
    }
}
