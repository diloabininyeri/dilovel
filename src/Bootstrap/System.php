<?php


namespace App\Bootstrap;


use App\Components\Routers\AllRouterCompare;
use App\Components\Routers\Dispatcher;
use App\Components\Routers\Printable;
use App\Components\Routers\RouterObject;
use JsonException;
use function Composer\Autoload\includeFile;

/**
 * Class System
 * @package App\Bootstrap
 */
class System
{

    /**
     * @return $this
     */
    public function run():self
    {
        Application::run();
        return $this;
    }

    /**
     * @return $this
     */
    public function loadRouterWeb():self
    {
        includeFile('src/Routers/web.php');
        return $this;
    }

    /**
     * @throws JsonException
     */
    public  function startUp():void
    {
        $compare = new AllRouterCompare();
        $find = $compare->findWillWhichExecute();
        if ($find instanceof RouterObject) {
            $routeResponse = (new Dispatcher())->route($find);
            $printable = new Printable($routeResponse);
            $printable->output();
        }

    }
}