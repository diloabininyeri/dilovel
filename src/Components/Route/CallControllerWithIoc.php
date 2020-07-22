<?php


namespace App\Components\Route;

use App\Components\Http\Request;
use App\Components\Reflection\IocContainer;
use ReflectionException;

/**
 * Class CallControllerWithIoc
 * @package App\Components\Route
 */
class CallControllerWithIoc
{

    /**
     * @var string
     */
    private string $controller;

    /**
     * @var string
     */
    private string $method;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * CallControllerWithIoc constructor.
     * @param string $controller
     * @param string $method
     * @param Request $request
     */
    public function __construct(string $controller, string $method, Request $request)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->request = $request;
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public function call()
    {
        if ($this->isNotInjectRequestRules()) {
            return call_user_func([new $this->controller, $this->method], $this->request);
        }
        return $this->createResponseWithIoContainer();
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    private function createResponseWithIoContainer()
    {
        $ioc = new IocContainer($this->request);
        return $ioc->onError(static function ($error) {
            return redirect()
                ->back()
                ->withOldInput()
                ->withFormError($error);
        })
            ->onSuccess(fn ($req) => call_user_func([new $this->controller, $this->method], $req))
            ->setController($this->controller)
            ->setMethod($this->method)
            ->call();
    }

    /**
     * @return bool
     */
    private function isNotInjectRequestRules(): bool
    {
        return get_class($this->request) === Request::class;
    }
}
