<?php


namespace App\Application\Controllers;

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
        $request->cookie()->set('aaa', range(1, 5), 55);
        return $request->cookie()->get('aaa')->expireForHumans();
    }
}
