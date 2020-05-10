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
        $user->country=408;
        $user->surname='barbaros';
        $user->created_at=now();
        $user->updated_at=now()->addWeek(1);
        return $user->save();
    }
}
