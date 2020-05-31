<?php


namespace App\Components\String;

/**
 * Class Str
 * @package App\Components\String
 * @mixin StrComponent
 *
 */
class Str
{

    /**
     * @var StrComponent $strComponent
     */
    private StrComponent $strComponent;

    /**
     * @var string $string
     */
    private string $string;

    /**
     * Str constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string=$string;
        $this->strComponent=new StrComponent($string);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return is_callable($name);
    }

    /**
     * @param $name
     * @return StrComponent
     */
    public function __get($name): StrComponent
    {
        return new StrComponent($name($this->string));
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->strComponent->$name(...$arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $string=$arguments[0];
        unset($arguments[0]);
        return (new StrComponent($string))->$name(...$arguments);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->strComponent->__toString();
    }
}
