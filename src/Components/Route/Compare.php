<?php


namespace App\Components\Route;

/**
 * Class Compare
 * @package App\Components\Route
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
