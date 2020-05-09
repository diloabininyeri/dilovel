<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Application\Models\Users;
use App\Components\Http\Request;

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
        //id gt 3
        return Users::min('id');
    }
}
