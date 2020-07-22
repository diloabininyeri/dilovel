<?php


namespace App\Components\Route;

/**
 * Class RouterObject
 * @package App\Components\Route
 */
class RouterObject
{

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
    public function getRouteName(): ?string
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
     * @return array
     */
    public function getAuthorize():array
    {
        return $this->mainRouter->getAuthorize();
    }


    /**
     * @return RouterGroup
     */
    public function getGroup(): RouterGroup
    {
        return $this->mainRouter->getGroup();
    }

    /**
     * @return MainRouter
     */
    public function getMainRouter(): MainRouter
    {
        return $this->mainRouter;
    }
}
