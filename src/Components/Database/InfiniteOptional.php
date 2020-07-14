<?php


namespace App\Components\Database;

use App\Components\InfiniteNullObject;
use App\Components\NullObject;

/**
 * Class InfiniteOptional
 * @package App\Components\Database
 */
class InfiniteOptional
{
    private $data;

    /**
     * Optional constructor.
     * @param object $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->data, $name)) {
            return $this->data->$name(...$arguments);
        }
        return new InfiniteNullObject();
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data->$name=$value;
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->data->$name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->data->$name ??  new InfiniteNullObject();
    }
}
