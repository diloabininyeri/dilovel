<?php


namespace App\Components\Http;

use App\Interfaces\ArrayAble;

/**
 * Class Cookie
 * @package App\Components\Http
 */
class Cookie implements ArrayAble
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
        $cookie = serialize(['value' => $value, 'expire' => $time + time(),'created_at'=>time()]);
        return setcookie($name, $cookie, time() + $time);
    }

    /**
     * @param string $name
     * @param null $default
     * @return ParseCookie
     */
    public function get(string $name, $default = null): ParseCookie
    {
        if (isset($this->cookie[$name]) && $this->isSerializedString($this->cookie[$name])) {
            return new ParseCookie((object)unserialize($this->cookie[$name], ['allowed_classes' => true]));
        }

        if (isset($this->cookie[$name])) {
            return new ParseCookie((object)['value' => $this->cookie[$name], 'expire' => 0,'created_at'=>0]);
        }

        return new ParseCookie((object)['value' => $default, 'expire' => 0,'created_at'=>0]);
    }

    /**
     * @param string $name
     * @param \Closure $closure
     * @return mixed
     */
    public function getOr(string $name, \Closure $closure)
    {
        return $this->get($name)->value() ?: $closure($this);
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

    private function isSerializedString($string): bool
    {
        return ($string === 'b:0;' || @unserialize($string, ['allowed_classes' => true]) !== false);
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->cookie as $name => $value) {
            if ($this->isSerializedString($value)) {
                $objectCookie = unserialize($value, ['allowed_classes' => true]);
                $array[] = [

                    'name' => $name,
                    'value' => $objectCookie['value'],
                    'expire' => $objectCookie['expire'],
                    'remaining_time'=>$objectCookie['expire'] - time(),
                    'created_at'=>$objectCookie['created_at']
                ];
            } else {
                $array[]=[
                    'name'=>$name,
                    'value'=>$value,
                    'expire'=>0,
                    'remaining_time'=>0,
                    'created_at'=>0
                ];
            }
        }
        return $array;
    }
}
