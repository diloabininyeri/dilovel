<?php


namespace App\Components\Reflection;

use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

class DependencyInject
{
    /**
     * @var object
     */
    private object $object;
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string  $class;

    /**
     * @param object $object
     * @return DependencyInject
     */
    public function setObject(object $object): DependencyInject
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @param string $method
     * @return DependencyInject
     */
    public function setMethod(string $method): DependencyInject
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return ReflectionParameter[]
     * @throws ReflectionException
     */
    public function getParameters():array
    {
        $reflectionMethod = new ReflectionMethod(get_class($this->object) ?: $this->class, $this->method);
        return $reflectionMethod->getParameters();
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getAllInjectClass(): array
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
     * @return mixed|null
     * @throws ReflectionException
     */
    public function getFirstInjectClass():?string
    {
        return $this->getAllInjectClass()[0] ?? null;
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public function callMethod()
    {
        return call_user_func_array([$this->object,$this->method], array_map(fn ($class) =>new $class, $this->getAllInjectClass()));
    }

    /**
     * @param string $class
     * @return DependencyInject
     */
    public function setClass(string $class): DependencyInject
    {
        $this->class = $class;
        return $this;
    }
}
