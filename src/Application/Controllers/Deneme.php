<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cache\Redis\Redis;
use App\Components\Database\BuilderQuery;
use App\Components\Http\Cookie;
use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\NullObject;
use App\Components\Routers\CurrentRouter;
use Carbon\Carbon;
use Facebook\Facebook;

class Deneme
{
    public function index(TcNoVerifyRequest $request)
    {
        $users= Users::where('id', 68, '>')->get();

        return $users
            ->withDefault(['surname'=>'surucu','add'=>'655'])
            ->withAttributes(['doesnt_exist'=>random_int(1, 555)]);
    }
}
