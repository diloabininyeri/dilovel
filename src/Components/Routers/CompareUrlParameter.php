<?php


namespace App\Components\Routers;


use App\Components\Http\Request;

/**
 * Class isEqualRouterParamUrlParam
 * @package App\Components
 */
class CompareUrlParameter
{
    /**
     * @var array
     */
    private array $dynamicUrlRouterParams = [];
    /**
     * @var array
     */
    private array $urlParams = [];
    /**
     * @var int
     */
    private int $iterable = 0;

    /**
     * isEqualRouterParamUrlParam constructor.
     * @param $routeUrlParameter
     */
    public function __construct($routeUrlParameter)
    {
        $this->setUrlParams();
        $this->setDynamicUrlRouterParams($routeUrlParameter);

    }

    /**
     * @param $callback
     * @return mixed
     */
    public function callUserFunc($callback)
    {
        if ($this->isEqualUrlWithRouterParam()) {
            return (new ExecuteRouter())->callUserFunc($callback);
        }
        return false;
    }

    /**
     * @param array $array
     * @return array
     */
    private function arrayValues(array $array): array
    {
        return array_values(
            array_filter($array)
        );
    }

    /**
     * @return bool
     */
    public function isEqualUrlWithRouterParam(): bool
    {
        if ($this->isEqualCount()) {
            $index = 0;
            foreach ($this->dynamicUrlRouterParams as $key) {
                if ($key === $this->urlParams[$index]) {
                    ++$this->iterable;
                } else if (strpos($key, ':') !== false) {
                    ++$this->iterable;
                } else {
                    --$this->iterable;
                }
                ++$index;
            }
        }
        return $this->iterable === count($this->dynamicUrlRouterParams);

    }

    /**
     * @param string $routeUrlParameter
     * @return CompareUrlParameter
     */
    private function setDynamicUrlRouterParams(string $routeUrlParameter): CompareUrlParameter
    {
        $this->dynamicUrlRouterParams = $this->arrayValues(explode('/', (string)$routeUrlParameter));
        return $this;
    }

    /**
     * @return bool
     */
    private function isEqualCount(): bool
    {
        return count($this->dynamicUrlRouterParams) === count($this->urlParams);
    }

    /**
     * @return CompareUrlParameter
     */
    public function setUrlParams(): CompareUrlParameter
    {
        $this->dynamicUrlRouterParams = $this->arrayValues(explode('/', (new Request())->url()->path()));
        return $this;
    }
}