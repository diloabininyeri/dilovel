<?php


namespace App\Components\Routers;


use Closure;

/**
 * Class RouterObject
 * @package App\Components\Routers
 */
class RouterObject
{

    /**
     * @var string
     */
    private string $routeName;

    /**
     * @var Closure
     */
    private Closure $callable;

    /**
     * @var
     */
    private $secondParameter;

    /**
     * @var array
     */
    private array $middleware;

    /**
     * @var MainRouter $mainRouter
     */
    private MainRouter $mainRouter;


    /**
     * RouterObject constructor.
     * @param MainRouter $router
     */
    public function __construct(MainRouter $router)
    {
        $this->mainRouter = $router;
    }


    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->mainRouter->getMiddleware();
    }

    /**
     * @return mixed
     */
    public function getSecondParameter()
    {
        return $this->mainRouter->getSecondParameter();
    }


    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->mainRouter->getName();
    }

    /**
     * @return bool
     */
    public function isCallableSecondParameter(): bool
    {
        return is_callable($this->mainRouter->getSecondParameter());
    }


    /**
     *
     */
    public function __destruct()
    {
        NotFound::$isNotFound++;
    }

}