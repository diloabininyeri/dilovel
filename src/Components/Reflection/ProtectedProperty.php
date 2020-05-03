<?php


namespace App\Components\Reflection;

use ReflectionException;
use ReflectionObject;

/**
 * Class ProtectedProperty
 * @package App\Components\Reflection
 */
class ProtectedProperty
{
    /**
     * @var object
     */
    private object $object;

    /**
     * @var string
     */
    private string $property;

    /**
     * @param object $object
     * @return ProtectedProperty
     */
    public function setObject(object $object): ProtectedProperty
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @param string $property
     * @return ProtectedProperty
     */
    public function setProperty(string $property): ProtectedProperty
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return string
     */
    private function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @return object
     */
    private function getObject(): object
    {
        return $this->object;
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public function getValue()
    {
        $reflectionObject = new ReflectionObject($this->getObject());
        $property = $reflectionObject->getProperty($this->getProperty());
        $property->setAccessible(true);

        return $property->getValue($this->getObject());
    }
}
