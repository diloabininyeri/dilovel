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
 * @method self str_pad($quantity, $complete)
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
     * @param $str
     * @return string
     */
    public function snakeToCamel():string
    {
        $str= lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->string))));
        return $this->returnSelf($str);
    }

    /**
     * @return string
     */
    public function pascalToSnake():string
    {
        $str= strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->string));
        return $this->returnSelf($str);
    }


    /**
     * @param $haystack
     * @return bool
     */
    public function isContains($haystack): bool
    {
        return strpos($this->string, $haystack) !== false;
    }

    /**
     * @return self
     */
    public function length(): self
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
    public function split(string $delimiter, int $limit = null): ?array
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
    private function returnSelf($string): self
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
    public function addToBeginning(string $string): self
    {
        return $this->returnSelf("$string$this->string");
    }

    /**
     * @param string $string
     * @return $this
     */
    public function addToEnd(string $string): self
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
     * @param null $separator
     * @return $this
     */
    public function repeat(int $multiplier, $separator = null): self
    {
        $string = str_repeat($this->string . $separator, $multiplier - 1) . $this->string;
        return $this->returnSelf($string);
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
    public function deleteNumeric(): self
    {
        $replaceString = preg_replace('/\d/', '', $this->string);
        return $this->returnSelf($replaceString);
    }

    /**
     * @return $this
     * @noinspection NotOptimalRegularExpressionsInspection
     */
    public function deleteLetters(): self
    {
        $replaceString = preg_replace('/[a-zA-Z-ğüşöçİĞÜŞÖÇ]+/', '', $this->string);
        return $this->returnSelf($replaceString);
    }

    /**
     * @return $this
     *
     */
    public function slug(): self
    {
        $string = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->string)));
        return $this->returnSelf($string);
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isMail(): bool
    {
        return filter_var($this->string, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return bool
     */
    public function isMacAddress():bool
    {
        return (bool) filter_var($this->string, FILTER_VALIDATE_MAC);
    }
    /**
     * @return bool
     */
    public function isIp():bool
    {
        return (bool)filter_var($this->string, FILTER_VALIDATE_IP);
    }

    /**
     * @return bool
     */
    public function isUrl():bool
    {
        return (bool) filter_var($this->string, FILTER_VALIDATE_URL);
    }

    /**
     * @return bool
     */
    public function isIp4():bool
    {
        return  (bool)filter_var($this->string, FILTER_FLAG_IPV4);
    }

    /**
     * @return bool
     */
    public function isIp6():bool
    {
        return (bool)filter_var($this->string, FILTER_FLAG_IPV6);
    }
    /**
     * @param int $length
     * @param null $treeDot
     * @return StrComponent
     */
    public function limit(int $length, $treeDot = '...'): self
    {
        return $this->returnSelf(mb_strimwidth($this->string, 0, $length, $treeDot));
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
