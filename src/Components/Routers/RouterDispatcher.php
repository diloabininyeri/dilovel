<?php


namespace App\Components\Routers;


use App\Http\Request;

/**
 * Class RouterDispatcher
 * @package App\Components\Routers
 * @noinspection PhpUnused
 */
class RouterDispatcher
{
    /**
     * @var array
     */
    private static array $call;


    /**
     * @param $call
     * @return mixed
     * @noinspection PhpUnused
     */
    public static function addCallable($call)
    {
        return self::$call[] = $call;
    }

    /**
     *
     * @noinspection PhpUnused
     */
    public static function call():void
    {

        foreach (self::$call as $item) {

            if (is_callable($item)) {
                self::dispatch($item(new Request()));
            }
            echo $item;
        }
    }

    /**
     * @param $item
     */
    private static function dispatch($item): void
    {
        $printable = new Printable($item);
        $printable->output();
    }
}