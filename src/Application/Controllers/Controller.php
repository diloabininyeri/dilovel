<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Application\Models\Users;
use App\Components\Http\Request;
use http\Client\Curl\User;

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
        $user=Users::find(25);
        echo $user->createdDate('fr'); //il y a 18 minutes
        echo $user->createdDate('en'); //18 minutes ago
        echo $user->createdDate('tr'); //18 dakika önce

        return  base_path();
    }
}
