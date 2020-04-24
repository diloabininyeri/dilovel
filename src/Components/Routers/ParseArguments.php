<?php


namespace App\Components\Routers;


/**
 * Class ParseArguments
 * @package App\Components
 */
class ParseArguments
{
    /**
     * @var mixed
     */
    /**
     * @var mixed
     */
    public $parameter,
        $callback;

    /**
     * ParseArguments constructor.
     * @param $arguments
     */
    public function __construct($arguments)
    {
        $this->parameter = $arguments[0];
        $this->callback = $arguments[1];
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameter;
    }
}