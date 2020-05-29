<?php


namespace App\Components\Http;

/**
 * Class Cookie
 * @package App\Components\Http
 */
class Cookie
{

    /**
     * @var array
     */
    private array $cookie;

    /**
     * Cookie constructor.
     */
    public function __construct()
    {
        $this->cookie =& $_COOKIE;
    }


    /**
     * @param string $name
     * @param $value
     * @param int $time
     * @return bool
     */
    public function set(string $name, $value, $time = 3600): bool
    {
        return setcookie($name, $value, time() + $time);
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function get(string $name, $default = null)
    {
        return $this->cookie[$name] ?? $default;
    }

    /**
     * @param $name
     * @return bool
     */
    public function exists($name): bool
    {
        return isset($this->cookie[$name]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool
    {
        return setcookie($name, null, time() - 3600);
    }
}
