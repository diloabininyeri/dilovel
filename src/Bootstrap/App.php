<?php


namespace App\Bootstrap;

use App\Components\Routers\NotFound;
use JsonException;

/**
 * Class App
 * @package App\Bootstrap
 */
class App
{
    /**
     * @throws JsonException
     */
    public function run():self
    {
        (new System())
            ->run()
            ->loadRouterWeb()
            ->startUp();

        return $this;
    }

    /**
     * @return false|string|null
     */
    public function call404IfNotFound():?string
    {
        return NotFound::isCannotFindAny() ? view('404') : null;
    }
}
