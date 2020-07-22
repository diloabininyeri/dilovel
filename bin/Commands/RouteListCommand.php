<?php


namespace Bin\Commands;

use App\Bootstrap\Bootstrap;
use App\Components\Route\MainRouter;
use App\Components\Route\RouterStorage;
use Bin\Components\CommandInterface;
use function Composer\Autoload\includeFile;

/**
 * Class RouteListCommand
 * @package Bin\Commands
 */
class RouteListCommand implements CommandInterface
{
    protected string $description = 'print all router list';
    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        Bootstrap::loadProviders();
        includeFile("src/Route/web.php");
        $routers=array_reverse(RouterStorage::all());
        echo   str_pad('dynamic uri', 50).str_pad('name', 50).'action'.PHP_EOL;
        echo str_repeat('-', 150);
        foreach ($routers as $router) {
            echo  PHP_EOL.str_pad($router->getDynamicUrl() ?: '/', 50). str_pad($router->getName(), 50).$this->getAction($router);
        }

        echo "\n";
    }

    /**
     * @param MainRouter $router
     * @return mixed|string
     */
    private function getAction(MainRouter $router)
    {
        if (is_object($router->getSecondParameter())) {
            return 'closure';
        }
        if (is_string($router->getSecondParameter())) {
            if ($router->getNamespace()) {
                return sprintf('%s/%s/%s', 'src/Application/Controllers', trim($router->getNamespace(), '/'), $router->getSecondParameter());
            }
            return  sprintf('%s/%s', 'src/Application/Controllers', trim($router->getSecondParameter(), '/'));
        }
        return 'view';
    }
}
