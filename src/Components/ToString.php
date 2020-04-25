<?php


namespace App\Components;


trait ToString
{
    /**
     * StringUtil constructor.
     * @param string $string
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