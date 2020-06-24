<?php


namespace App\Components\Http;

/**
 * Class Url
 * @package App\Http
 */
class Url
{

    /**
     * @var array
     */
    private array  $server;

    /**
     * Url constructor.
     */
    public function __construct()
    {
        $this->server = $_SERVER;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'))) . '://';
    }

    /**
     * @return string
     */
    public function base(): string
    {
        $base = sprintf(
            '%s%s',
            $this->getSchema(),
            $_SERVER['SERVER_NAME'],
        );
        $port = $this->port();
        if (isset($port)) {
            $base = rtrim($base, '/');
            return "$base:$port";
        }
        return $base;
    }

    public function port()
    {
        return $this->server['SERVER_PORT'];
    }

    /**
     * @return string
     */
    public function full(): string
    {
        return sprintf('%s%s', $this->base(), rtrim($this->server['REQUEST_URI'], '/'));
    }

    /**
     * @return array|false|int|string|null
     */
    public function parse()
    {
        return parse_url($this->full());
    }

    /**
     * @return string
     */
    public function withoutQueries(): string
    {
        return sprintf('%s%s', $this->base(), rtrim($this->path(), '/'));
    }

    /**
     * @return array
     */
    public function query(): array
    {
        parse_str($this->parse()['query'] ?? '', $array);
        return $array;
    }

    /**
     * @param mixed ...$except
     * @return array
     */
    public function except(...$except): ?array
    {
        $array = [];
        foreach ($this->query() as $key => $value) {
            if (!in_array($key, $except, true)) {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * @param string $charList
     * @return string
     */
    public function pathWithTrim(string $charList='/'):string
    {
        return trim($this->path(), $charList);
    }

    /**
     * @return mixed|string
     */
    public function path()
    {
        return $this->parse()['path'];
    }
}
