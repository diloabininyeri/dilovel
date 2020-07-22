<?php


namespace App\Components\Reflection;

use ReflectionClass;
use ReflectionException;
use ReflectionObject;

/**
 * Class RuleAnnotation
 * @package App\Components\Reflection
 */
class RuleAnnotation
{
    /**
     * @var object
     */
    private ?object  $object=null;


    /**
     * @var string
     */
    private ?string $class=null;


    /**
     * @var string
     */
    private string $property;

    /**
     * @var string
     */
    private string $method;

    /**
     * @param object $object
     */
    public function setObject(object $object): void
    {
        $this->object = $object;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return ReflectionClass|ReflectionObject
     * @throws ReflectionException
     */
    private function reflection()
    {
        if ($this->class) {
            return new ReflectionClass($this->class);
        }
        return new ReflectionObject($this->object);
    }

    /**
     * @return string
     */
    private function getRegexPattern(): string
    {
        return '/\s?@rule\((?P<parameters>.*)\)/m';
    }


    /**
     * @return array|null
     * @throws ReflectionException
     */
    public function read():?array
    {
        if ($this->method) {
            $annotation = $this->reflection()->getMethod($this->method)->getDocComment();
        } else {
            $annotation = $this->reflection()->getProperty($this->property)->getDocComment();
        }
        preg_match_all($this->getRegexPattern(), $annotation, $matches, PREG_SET_ORDER, 0);
        return array_map(fn ($i) => $i['parameters'], $matches);
    }

    /**
     * @param string $property
     * @return RuleAnnotation
     */
    public function setProperty(string $property): RuleAnnotation
    {
        $this->property = $property;
        return $this;
    }
}
