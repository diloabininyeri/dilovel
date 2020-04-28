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
        $urlPath = explode('/', $this->urlPath);
        $routerUrl = explode('/', $this->routeDynamicUrl);
        if ($this->isEqual($urlPath, $routerUrl)) {

            $this->setIsMatched(true);
        }


    }

    /**
     * @param $urlPath
     * @param $routerUrl
     * @return bool
     */
    private function isEqual($urlPath, $routerUrl): bool
    {
        $stepMatched = 0;
        foreach ($routerUrl as $key => $routeParam) {
            if (strpos($routeParam, ':') === 0) {

                ++$stepMatched;
                $this->setQueryString($routeParam, $urlPath[$key]);
            } else if ($urlPath[$key] === $routeParam) {
                ++$stepMatched;
            }

        }

        return count($urlPath) === $stepMatched;

    }

    /**
     * @param $name
     * @param $value
     */
    private function setQueryString($name, $value): void
    {
        $name = str_replace(':', '', $name);
        RouterQueryString::set($name, $value);
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
    private function setIsMatched(bool $isFound): CompareDynamic
    {
        $this->isMatched = $isFound;
        return $this;
    }
}