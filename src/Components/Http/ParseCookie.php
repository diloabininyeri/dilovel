<?php


namespace App\Components\Http;

/**
 * Class ParseCookie
 * @package App\Components\Http
 */
class ParseCookie
{

    /**
     * @var object
     */
    private object $cookie;

    /**
     * ParseCookie constructor.
     * @param object $cookie
     */
    public function __construct(object $cookie)
    {
        $this->cookie =$cookie;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->cookie->value;
    }

    /**
     * @return int
     */
    public function expire():int
    {
        return $this->cookie->expire - time();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}
