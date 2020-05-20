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
        return  Users::find(19)->book()->update(['name'=>"19 nolu kitaptan alıntı"]);
    }
}
