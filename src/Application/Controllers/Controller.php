<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Http\Request;
use App\Components\Http\Session;

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

         Session::flash()->set('name','dılo');
         echo Session::flash()->get('name');

        return  Users::get('id')->implode(); //1,2,5.....
    }
}
