<?php


namespace App\Components;

/**
 * Trait ToString
 * @package App\Components
 */
trait ToString
{
    /**
     * StringUtil constructor.
     * @param string $string
     * @noinspection PhpUndefinedFieldInspection
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @param $name
     * @param $arguments
     * @return self
     */
    public function __call($name, $arguments)
    {
        return new self($name($this->string));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }
}
