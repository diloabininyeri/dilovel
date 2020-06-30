<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Cache\Redis\Redis;
use App\Components\Http\Cookie;
use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\Routers\CurrentRouter;
use Carbon\Carbon;
use Facebook\Facebook;

class Deneme
{
    public function index(Request $request)
    {
        return redirect()->router('other.news');
    }
}
