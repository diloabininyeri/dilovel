<?php


namespace App\Components\Database;

/**
 * Class Optional
 * @package App\Components\Database
 */
class Optional
{

    /**
     * @var object
     */
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
        return null;
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get($name)
    {
        return $this->data->$name ?? null;
    }
}
