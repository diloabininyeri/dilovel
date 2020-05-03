<?php /** @noinspection PhpUnused*/


namespace App\Components\Reflection;

use App\Components\Http\Request;
use App\Interfaces\FormRequestInterface;
use App\Interfaces\RuleInterface;
use Closure;
use Exception;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

/**
 * Class IocContainer
 * @package App\Components\Reflection
 */
class IocContainer
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
     * @var array
     */
    private array $requestErrors;

    /**
     * @var Closure
     */
    private Closure $onSuccessCallback;

    /**
     * @var Closure
     */
    private Closure $onErrorCallback;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * IocContainer constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $controller
     * @return IocContainer
     */
    public function setController(string $controller): IocContainer
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @param string $method
     * @return IocContainer
     */
    public function setMethod(string $method): IocContainer
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    private function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    private function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function onSuccess(callable $callback): self
    {
        $this->onSuccessCallback = $callback;
        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function onError(callable $callback): self
    {
        $this->onErrorCallback = $callback;
        return $this;
    }

    /**
     * @return ReflectionParameter[]
     * @throws ReflectionException
     */
    private function getParameters(): array
    {
        $reflectionMethod = new ReflectionMethod($this->getController(), $this->getMethod());
        return $reflectionMethod->getParameters();
    }


    /**
     * @return array|FormRequestInterface
     * @throws ReflectionException
     */
    private function getParameterAsClassName(): array
    {
        $params = [];
        foreach ($this->getParameters() as $parameter) {
            if ($parameter->getClass()->getName()) {
                $params[] = $parameter->getClass()->getName();
            }
        }
        return $params;
    }


    /**
     * @param RuleInterface[] $rules
     */
    private function callRules($rules): void
    {
        foreach ($rules as $rule) {
            if (!$rule->valid($this->request)) {
                $this->requestErrors[] = $rule->message();
            }
        }
    }


    /**
     * @throws ReflectionException
     */
    private function callCustomRequests(): void
    {
        foreach ($this->getParameterAsClassName() as $class) {
            $customRequest = new $class();
            if (!($customRequest instanceof FormRequestInterface)) {
                throw  new RuntimeException('ioc class must be instance of ' . FormRequestInterface::class);
            }

            $this->callRules($customRequest->rules());
        }
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function call()
    {
        $this->callCustomRequests();
        if (empty($this->requestErrors)) {
            return call_user_func($this->onSuccessCallback, $this->request);
        }
        return call_user_func($this->onErrorCallback, $this->requestErrors);
    }
}
