<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cache;
use App\Components\Cache\Redis\Redis;
use App\Components\Collection\Collection;
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

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    /**
     * @param TcNoVerifyRequest $request
     * @return Collection
     */
    public function index(TcNoVerifyRequest $request)
    {
        return Users::get()->when($request->has('humans'), new self());
    }

    /**
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke(Collection $collection)
    {
        return $collection->toDiffForHumans();
    }
}
