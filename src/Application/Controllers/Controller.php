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
     * @param TcNoVerifyRequest $request
     * @return false|string
     */
    public function index(TcNoVerifyRequest $request)
    {
        /**
         * add extra property to objects
         */
        return  Users::get()->filter(fn ($item) =>$item->id>30)->each(fn ($item) =>$item->city='urfa');
    }
}
