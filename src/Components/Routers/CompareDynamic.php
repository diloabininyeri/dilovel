<?php


namespace App\Components\Routers;


/**
 * Class CompareDynamic
 * @package App\Components\Routers
 */
class CompareDynamic
{

    /**
     * @var bool
     */
    private bool $isMatched = false;

    /**
     * @var string|null
     */
    private ?string $urlPath;

    /**
     * @var string|null
     */
    private ?string $routeDynamicUrl;

    /**
     * CompareDynamic constructor.
     * @param MainRouter $router
     */
    public function __construct(MainRouter $router)
    {
        $this->routeDynamicUrl = $router->getDynamicUrl();
        $this->urlPath = $router->getUrlPath();
        $this->whichOneWillExecute();
    }


    /**
     * set is match true or false
     */
    public function whichOneWillExecute(): void
    {
        $realUrl = explode('/', $this->urlPath);
        $dynamicUrl = explode('/', $this->routeDynamicUrl);

    }

    /**
     * @return bool
     */
    public function isMatched(): bool
    {
        return $this->isMatched;
    }

    /**
     * @param mixed $isFound
     * @return CompareDynamic
     */
    private function setIsMatched(bool $isFound)
    {
        $this->isMatched = $isFound;
        return $this;
    }
}