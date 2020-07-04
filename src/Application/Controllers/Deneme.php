<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cache;
use App\Components\Cache\Redis\Redis;
use App\Components\Database\BuilderQuery;
use App\Components\Http\Cookie;
use App\Components\Http\Http;
use App\Components\Http\Request;
use App\Components\Image\Color;
use App\Components\Lang\Lang;
use App\Components\NullObject;
use App\Components\Routers\CurrentRouter;
use Carbon\Carbon;
use Facebook\Facebook;
use Locale;

class Deneme
{
    public function index(TcNoVerifyRequest $request)
    {
        $request->location('89.78.15.8')->country();

        return Cache::remember('users', fn () =>Users::get());
    }
}
