<?php


namespace App\Bootstrap;

use App\Components\Router\AllRouterCompare;
use App\Components\Router\CurrentRouter;
use App\Components\Router\Dispatcher;
use App\Components\Router\Printable;
use App\Components\Router\RouterObject;
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
    public function run(): self
    {
        Application::run();
        return $this;
    }

    /**
     * @return $this
     */
    public function loadRouterWeb(): self
    {
        includeFile('src/Routers/web.php');
        return $this;
    }

    /**
     * @param  RouterObject $findRouterObject
     */
    private function setCurrentRouter($findRouterObject):void
    {
        if ($findRouterObject!==null) {
            CurrentRouter::set($findRouterObject);
        }
    }

    /**
     */
    public function startUp(): void
    {
        $compare = new AllRouterCompare();
        $findRouterObject = $compare->findWillWhichExecute();
        if ($findRouterObject instanceof RouterObject) {
            $this->setCurrentRouter($findRouterObject);
            if ($findRouterObject->getMainRouter()->getView() !== null) {
                echo view($findRouterObject->getMainRouter()->getView());
            } else {
                $this->printable($findRouterObject);
            }
        }
    }


    private function printable(RouterObject $findRouterObject): void
    {
        $routeResponse = (new Dispatcher())->route($findRouterObject);
        $printable = new Printable($routeResponse);
        $printable->output();
    }
}
