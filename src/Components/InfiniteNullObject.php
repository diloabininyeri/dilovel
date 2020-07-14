<?php


namespace App\Components;

/**
 * Class InfiniteNullObject
 * @package App\Components
 */
class InfiniteNullObject
{

    /**
     * @param $name
     * @return InfiniteNullObject
     */
    public function __isset($name)
    {
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return InfiniteNullObject
     */
    public function __set($name, $value)
    {
        return $this;
    }

    /**
     * @param $name
     * @return InfiniteNullObject
     */
    public function __get($name)
    {
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return InfiniteNullObject
     */
    public function __call($name, $arguments)
    {
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
