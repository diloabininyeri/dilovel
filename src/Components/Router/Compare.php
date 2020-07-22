<?php


namespace App\Components\Router;

/**
 * Class Compare
 * @package App\Components\Router
 */
class Compare
{

    /**
     * @var MainRouter
     */
    private MainRouter $mainRouter;

    /**
     * @param MainRouter $mainRouter
     * @return $this
     */
    public function url(MainRouter $mainRouter): Compare
    {
        $this->mainRouter = $mainRouter;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEqual(): bool
    {
        return $this->mainRouter->getUrlPath() === $this->mainRouter->getDynamicUrl();
    }
}
