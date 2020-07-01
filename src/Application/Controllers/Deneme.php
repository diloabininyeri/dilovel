<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cache\Redis\Redis;
use App\Components\Http\Cookie;
use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\Routers\CurrentRouter;
use Carbon\Carbon;
use Facebook\Facebook;

class Deneme
{
    public function index(TcNoVerifyRequest $request)
    {
        return Users::filter()->get();
    }
}
