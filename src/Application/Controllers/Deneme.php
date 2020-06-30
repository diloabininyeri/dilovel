<?php


namespace App\Application\Controllers;

use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\Routers\CurrentRouter;
use Facebook\Facebook;

class Deneme
{
    public function index(Request $request)
    {
        $cookie1=  $request->cookie()->get('arr');
        echo  $cookie1->expire();

        return $cookie1->value();
    }
}
