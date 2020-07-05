<?php


namespace App\Components\Http;

use Carbon\Carbon;

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
     * @return string|null
     */
    public function expireForHumans():?string
    {
        if ($this->expire()!==0) {
            return Carbon::parse(date('Y/m/d H:i:s', $this->expire()))->diffForHumans();
        }
        return null;
    }
    /**
     * @return int
     */
    public function expire():int
    {
        return $this->cookie->expire;
    }

    /**
     * @return string
     */
    public function createdAtForHumans():string
    {
        return Carbon::parse(date('Y/m/d H:i:s', $this->createdAt()))->diffForHumans();
    }
    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->cookie->created_at;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}
