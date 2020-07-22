<?php


namespace App\Components\String;

/**
 * Class Str
 * @package App\Components\String
 * @mixin StrComponent
 * @method static StrComponent slug(string $string)
 * @method static StrComponent strtoupper(string $string)
 * @method static StrComponent mb_strtoupper(string $string)
 * @method static StrComponent strtolower(string $string)
 * @method static StrComponent mb_strtolower(string $string)
 * @method static StrComponent lcfirst(string $string)
 * @method static StrComponent ucfirst(string $string)
 * @method static StrComponent trim(string $string)
 * @method static StrComponent rtrim(string $string,string $charList)
 * @method static StrComponent ltrim(string $string,string $charlist)
 * @method static StrComponent strchr(string $chr)
 * @method static StrComponent md5(string $string)
 * @method static StrComponent sha1(string $string)
 * @method static StrComponent nl2br(string $string)
 * @method static StrComponent str_pad(string $string,int $quantity, $complete)
 * @method static StrComponent str_shuffle(string $string)
 * @method static StrComponent strlen(string $string)
 * @method static StrComponent str_replace($find,$replace,$string)
 * @method static StrComponent limit(string $string,int $length,string $threeDot=null)
 * @method static StrComponent snakeToCamel(string $string)
 * @method static bool isMail(string $string)
 * @method static bool isIp(string $string)
 * @method static bool isMacAddress(string $string)
 * @method static bool isUrl(string $string)
 * @method static bool isIp4(string $string)
 * @method static bool isIp6(string $string)
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
        $this->string = $string;
        $this->strComponent = new StrComponent($string);
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
        $string = $arguments[0];
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
