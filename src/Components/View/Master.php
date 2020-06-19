<?php


namespace App\Components\View;

use App\Components\Exceptions\MasterPageNotFound;
use Closure;

/**
 * Class Master
 * @package App\Components\View
 */
class Master
{
    private static array $viewShare;

    /**
     * @param string $view
     * @param Closure $closure
     */
    public static function page(string $view, Closure $closure): void
    {
        self::$viewShare[$view]=$closure;
    }

    /**
     * @param string $view
     * @return mixed
     */
    public static function getViewShareVariables(string $view)
    {
        if (isset(self::$viewShare[$view])) {
            return call_user_func(self::$viewShare[$view]);
        }
        throw new MasterPageNotFound("$view master page not found");
    }
}
