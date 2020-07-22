<?php


namespace App\Components\Route;

use App\Components\Route\Validators\ValidateRouter;

/**
 * Class CompareDynamic
 * @package App\Components\Route
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
            if (strpos($routeParam, ':') !== false) {
                if ($this->isRequiredValidate($routeParam)) {
                    if ($this->validateRouterParamType($routeParam, $urlPath[$key])) {
                        ++$stepMatched;
                        $this->setQueryString($this->getDynamicRouterName($routeParam), $urlPath[$key]);
                    }
                } else {
                    ++$stepMatched;
                    $this->setQueryString($routeParam, $urlPath[$key]);
                }
            } elseif ($urlPath[$key] === $routeParam) {
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

    /**
     * @param $routerParameter
     * @return string
     */
    private function getDynamicRouterName($routerParameter): string
    {
        return $this->findTypeAndName($routerParameter)['router_dynamic_param_name'];
    }

    /**
     * @param $routerParameter
     * @param $value
     * @return bool
     */
    private function validateRouterParamType($routerParameter, $value): bool
    {
        $find = $this->findTypeAndName($routerParameter);
        $validator = new ValidateRouter();
        return $validator->validate($value, $find['validate_type']);
    }

    /**
     * @param $routerParameter
     * @return bool
     */
    private function isRequiredValidate($routerParameter):bool
    {
        $find = $this->findTypeAndName($routerParameter);
        return (isset($find['validate_type']) && !empty($find['validate_type']));
    }

    /**
     * @param $routerParam
     * @return array
     */
    private function findTypeAndName($routerParam): array
    {
        $re = '/(?P<validate_type>.*):(?P<router_dynamic_param_name>.*)/m';
        preg_match_all($re, $routerParam, $matches, PREG_SET_ORDER, 0);
        return $matches[0];
    }
}
