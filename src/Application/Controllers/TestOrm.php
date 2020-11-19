<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Cache\Redis\Event;

/**
 * Class TestOrm
 * @package App\Application\Controllers
 */
class TestOrm
{


    /**
     * @return mixed|object|null
     */
    public function index()
    {

        // return Event::publish(json_encode($_SERVER));
        return Users::findOr(18, fn () =>[response()->toJson(['data'=>[],'status'])]);
    }
}
