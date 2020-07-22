<?php


namespace App\Bootstrap;

use App\Components\Route\NotFound;

/**
 * Class App
 * @package App\Bootstrap
 */
class App
{
    /**
     * @return $this
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
     * @return string|null
     */
    public function call404IfNotFound():?string
    {
        if (NotFound::isCannotFindAny()) {
            http_response_code(404);
            return view('errors.404');
        }
        return null;
    }
}
