<?php


namespace App\Components;


use App\Http\Request;

/**
 * Class isEqualRouterParamUrlParam
 * @package App\Components
 */
class isEqualRouterParamUrlParam
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
     * @return isEqualRouterParamUrlParam
     */
    private function setDynamicUrlRouterParams(string $routeUrlParameter): isEqualRouterParamUrlParam
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
     * @return isEqualRouterParamUrlParam
     */
    public function setUrlParams(): isEqualRouterParamUrlParam
    {
        $this->dynamicUrlRouterParams = $this->arrayValues(explode('/', (new Request())->url()->path()));
        return $this;
    }
}