<?php


namespace App\Application\Controllers;

use App\Components\Http\Cookie;
use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\Routers\CurrentRouter;
use Facebook\Facebook;

class Deneme
{
    public function index(Request $request)
    {
        return $request->cookie()->getOr('arr', static function (Cookie $cookie) {

            // $cookie->toArray();
            return 'cookie not found';
        });
    }
}
