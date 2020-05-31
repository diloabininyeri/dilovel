<?php


namespace App\Components\Arr;

/**
 * Class ArrayMapper
 * @package App\Components\Arr
 */
class ArrayMapper
{

    /**
     * @var array
     */
    private array $array;

    /**
     * @param array $array
     * @return $this
     */
    public function __invoke(array $array)
    {
        $this->array=$array;
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    final public function __get($name)
    {
        return $this->array[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    final public function __isset($name)
    {
        return isset($this->array[$name]);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->array[$name]=$value;
    }

    /**
     * @param $name
     */
    final public function __unset($name)
    {
        unset($this->array[$name]);
    }
}
