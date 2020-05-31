<?php


namespace App\Components\String;

/**
 * Class StrComponent
 * @package App\Components\String
 * @method self strtoupper()
 * @method self mb_strtoupper()
 * @method self strtolower()
 * @method self mb_strtolower()
 * @method self lcfirst()
 * @method self ucfirst()
 * @method self  trim(string $charList)
 * @method self rtrim(string $charList)
 * @method self ltrim(string $charList)
 * @method self strchr(string $chr)
 * @method self md5()
 * @method self sha1()
 * @method self nl2br()
 * @method self str_pad($quantity,$complete)
 * @method self str_shuffle()
 *
 */
class StrComponent
{
    /**
     * @var string
     */
    private string $string;

    /**
     * StrComponent constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @param $haystack
     * @return bool
     */
    public function isContains($haystack): bool
    {
        return strpos($this->string, $haystack)!==false;
    }

    /**
     * @param string $string
     * @return false|string
     */
    public function splitAtStart(string $string)
    {
        return $this->returnSelf(strstr($this->string, $string));
    }

    /**
     * @param $string
     * @return StrComponent
     */
    public function returnSelf($string): self
    {
        return new self($string);
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public function splitAfter($string)
    {
        $split = explode($string, $this->string);
        return $this->returnSelf(end($split));
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isStartsWith(string $string): bool
    {
        return strpos($this->string, $string) === 0;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isEndsWith(string $string): bool
    {
        $length = strlen($string);
        if ($length === 0) {
            return true;
        }
        return (substr($this->string, -$length) === $string);
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get($name)
    {
        return new self($name($this->string));
    }

    /**
     * @param int $multiplier
     * @return $this
     */
    public function repeat(int $multiplier): self
    {
        return $this->returnSelf(str_repeat($this->string, $multiplier));
    }

    /**
     * @param $name
     * @param $arguments
     * @return StrComponent
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments);
        return $this->returnSelf($name($this->string, ...$arguments));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }
}
