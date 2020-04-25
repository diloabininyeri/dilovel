<?php


namespace Bin\Components;


use RuntimeException;

/**
 * Class CustomCommandCall
 * @package Bin\Components
 */
abstract class  CustomCommandCall
{

    /**
     * @var array
     */
    private array $signals;

    /**
     * @var int
     */


    /**
     * CustomCommandCall constructor.
     * @param $params
     * @param $count
     */
    public function __construct($params, $count)
    {
        if ($count < 3) {
            throw  new RuntimeException('too few parameters !!!');
        }
        $this->signals = array_slice($params, 1);

    }

    /**
     * @return mixed
     *
     */
    public function run(): void
    {
        $commandClass = $this->getCommands($this->signals[0]);
        echo $commandClass;
        if (class_exists($commandClass)) {
            (new $commandClass())->handle(array_slice($this->signals, 1));
        } else {
            echo 'Command Not found';
        }

    }

    /**
     * @param null $key
     * @return mixed
     */
    private function getCommands($key = null)
    {
        if ($key === null) {
            return $this->commands;
        }
        return $this->commands[$key] ?? null;
    }


}