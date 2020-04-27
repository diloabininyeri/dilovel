<?php

namespace App\Components\Http;


use App\Components\ResponseCollection;
use App\interfaces\ArrayAble;
use App\interfaces\toJson;
use JsonException;

/**
 * Class Request
 * @package App\Http
 */
class Request implements ArrayAble, toJson
{
    /**
     * @var array
     */
    private array $request;

    /**
     * @var  array $get
     */
    private array $get;

    /**
     * @var array $post
     */
    private array $post;

    /**
     * @var array
     */
    private array  $server = [];


    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = array_map('trim', $_REQUEST);
        $this->get = array_map('trim', $_GET);
        $this->post = array_map('trim', $_POST);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function post($name, $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function merge(array $array): self
    {
        array_merge($this->request, $array);
        return $this;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->request;
    }

    /**
     * @return string|null
     * @throws JsonException
     */
    public function toJson(): ?string
    {
        return (new ResponseCollection($this->request))->toJson();
    }

    /**
     * @return array|false
     */
    public function getHeaders()
    {
        return getallheaders();
    }

    /**
     * @return array
     */
    public function server(): array
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function method(): string
    {

        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return Session
     */
    public function session(): Session
    {
        return new Session();
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFile($name): bool
    {
        return isset($_FILES[$name]);
    }

    /**
     * @param string $file
     * @return File
     */
    public function file(string $file): File
    {
        return new File($file);
    }

    /**
     * @return Url
     */
    public function url(): Url
    {
        return new Url();
    }


}