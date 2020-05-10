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
        $user->name='eşref soyan ';
        $user->country=1000;
        $user->surname='barbaros';
        return $user->save();

        $users=new Users();
        $users->name='bertan ';
        $users->country=200;
        $users->surname='korkmaz';
        return $users->save();
    }
}
