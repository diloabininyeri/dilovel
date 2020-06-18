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
 * @method self trim(string $charList)
 * @method self rtrim(string $charList)
 * @method self ltrim(string $charList)
 * @method self strchr(string $chr)
 * @method self md5()
 * @method self sha1()
 * @method self nl2br()
 * @method self str_pad($quantity,$complete)
 * @method self str_shuffle()
 * @method self strlen()
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
     * @return self
     */
    public function length():self
    {
        return $this->strlen();
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
     * @param string $delimiter
     * @param int|null $limit
     * @return array|null
     */
    public function split(string $delimiter, int $limit=null):?array
    {
        if ($limit) {
            return explode($delimiter, $this->string, $limit);
        }
        return explode($delimiter, $this->string);
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
     * @return $this
     */
    public function addToBeginning(string $string):self
    {
        return $this->returnSelf("$string$this->string");
    }

    /**
     * @param string $string
     * @return $this
     */
    public function addToEnd(string $string):self
    {
        return $this->returnSelf("$this->string$string");
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
     * @param $search
     * @param $replace
     * @return StrComponent
     */
    public function replace($search, $replace): StrComponent
    {
        return $this->returnSelf(str_replace($search, $replace, $this->string));
    }

    /**
     * @return $this
     */
    public function deleteNumeric():self
    {
        $replaceString = preg_replace('/\d/', '', $this->string);
        return $this->returnSelf($replaceString);
    }

    /**
     * @return $this
     * @noinspection NotOptimalRegularExpressionsInspection
     */
    public function deleteLetters():self
    {
        $replaceString = preg_replace('/[a-zA-Z-ğüşöçİĞÜŞÖÇ]+/', '', $this->string);
        return $this->returnSelf($replaceString);
    }

    /**
     * @return $this
     *
     */
    public function slug():self
    {
        $string= strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->string)));
        return $this->returnSelf($string);
    }

    /**
     * @param string $string1
     * @param string $string2
     * @return $this
     */
    public function diff(string $string1, string $string2):self
    {
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
