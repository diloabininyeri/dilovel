<?php


namespace App\Components\Http;


use App\Http\Request;

/**
 * Class MiddlewareAbstract
 * @package App\Components\Http
 */
abstract class MiddlewareAbstract
{

    /**
     * @var array|null $middlewareRoutes
     */
    private ?array $middlewareRoutes = [];

    /**
     * @var $response
     */
    private $response;

    /**
     * @var bool $isInstanceOfRequest
     */
    private bool $isInstanceOfRequest = true;


    /**
     * MiddlewareAbstract constructor.
     * @param mixed ...$names
     */
    public function __construct(...$names)
    {
        $this->middlewareRoutes = $this->getMiddlewareRoute($names);
    }

    /**
     * @param $names
     * @return array
     */
    private function getMiddlewareRoute($names): array
    {
        return array_map(function ($name) {
            return $this->middleware[$name];
        }, $names);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function call(Request $request): self
    {
        foreach ($this->middlewareRoutes as $middlewareRoute) {

            if ($request instanceof Request) {
                $request = $this->callMiddleware($middlewareRoute, $request);
            } else {
                $this->isInstanceOfRequest = false;
                $this->response = $request;
                return $this;
            }
        }
        $this->isInstanceOfRequest = true;
        $this->response = $request;
        return $this;

    }

    /**
     * @param $middleware
     * @param $request
     * @return mixed
     */
    private function callMiddleware($middleware, $request)
    {
        return (new $middleware())->handle(fn($response) => $response, $request);
    }

    /**
     * @return bool
     */
    public function isInstanceOfRequest(): bool
    {
        return $this->isInstanceOfRequest;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}