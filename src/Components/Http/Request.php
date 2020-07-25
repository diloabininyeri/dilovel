<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Components\Http;

use App\Components\Auth\User\User;
use App\Components\Route\RouterQueryString;
use App\Components\Traits\ConditionAble;
use App\Components\Traits\Singleton;
use App\Interfaces\ArrayAble;
use App\Interfaces\RequestInterface;
use App\Interfaces\ToJson;
use Detection\MobileDetect;
use JsonException;

/**
 * Class Request
 * @package App\Http
 * @method  bool isMobile()
 * @method  bool isTablet()
 * @method  bool isiOS()
 * @method  bool isAndroidOS()
 */
class Request implements ArrayAble, ToJson, RequestInterface
{
    use ConditionAble,Singleton;
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
    private array  $server;


    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = array_map('trim', $_REQUEST);
        $this->get = array_map('trim', $_GET);
        $this->post = array_map('trim', $_POST);
        $this->server = $_SERVER;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return RouterQueryString::get($key, $this->get[$key] ?? $default);
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
        $this->request=array_merge($this->request, $array);
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
        return json_encode($this->request, JSON_THROW_ON_ERROR);
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
     * @return object
     */
    public function serverObject(): object
    {
        return (object)array_change_key_case($this->server(), CASE_LOWER);
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method):bool
    {
        return (strtolower(trim($method))===strtolower($this->method()));
    }

    /**
     * @return Session
     */
    public function session(): Session
    {
        return new Session();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return !empty($this->post($name)) ?: $this->get($name) ?: false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFile(string $name): bool
    {
        $tmpName=$_FILES[$name]['tmp_name'] ?? false;
        if ($tmpName === false) {
            return  false;
        }

        if (isset($_FILES[$name]['tmp_name']) && !is_array($tmpName)) {
            return file_exists($_FILES[$name]['tmp_name']);
        }
        return  false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFiles(string $name):bool
    {
        $tmpName=$_FILES[$name]['tmp_name'] ?? false;
        if ($tmpName === false) {
            return  false;
        }
        if (isset($_FILES[$name]['tmp_name'][0]) && is_array($tmpName)) {
            return file_exists($_FILES[$name]['tmp_name'][0]);
        }
        return false;
    }

    /**
     * @param string $file
     * @return File
     */
    public function file(string $file): File
    {
        return new File($_FILES[$file]);
    }

    /**
     * @param string $file
     * @return array|File[]
     */
    public function files(string $file):array
    {
        $fileArray = array();
        $files=$_FILES[$file];
        $fileCount = count($files['name']);
        $fileKeys = array_keys($files);

        for ($i=0; $i<$fileCount; $i++) {
            foreach ($fileKeys as $key) {
                $fileArray[$i][$key] = $files[$key][$i];
            }
        }

        return  array_map(fn ($item) =>new File($item), $fileArray);
    }

    /**
     * @return Url
     */
    public function url(): Url
    {
        return new Url();
    }

    /**
     * @return mixed
     */
    public function browser()
    {
        return $this->server()['HTTP_USER_AGENT'];
    }


    /**
     * @return mixed
     */
    public function ip()
    {
        if (!empty($this->server()['HTTP_CLIENT_IP'])) {
            return $this->server()['HTTP_CLIENT_IP'];
        }

        if (!empty($this->server()['HTTP_X_FORWARDED_FOR'])) {
            return $this->server()['HTTP_X_FORWARDED_FOR'];
        }

        return $this->server()['REMOTE_ADDR'];
    }

    /**
     * @param null $ip
     * @return Location
     * @throws JsonException
     */
    public function location($ip=null):Location
    {
        return new Location($ip ?: $this->ip());
    }

    /**
     * @param mixed ...$exceptKeys
     * @return array
     */
    public function except(...$exceptKeys): array
    {
        $exceptArray = $this->request;
        foreach ($exceptKeys as $except) {
            unset($exceptArray[$except]);
        }

        return $exceptArray;
    }

    /***
     * @return array
     */
    public function all(): array
    {
        return $this->request;
    }

    /**
     * @param string $input
     * @param null $default
     * @return mixed|null
     */
    public function input(string $input, $default=null)
    {
        return $this->post($input, $default);
    }

    /**
     * @return array|null
     */
    public function phpInput(): ?array
    {
        parse_str(file_get_contents('php://input'), $phpInput);
        return $phpInput;
    }

    /**
     * @param null $name
     * @param null $default
     * @return array|mixed|null
     */
    public function json($name = null, $default=null)
    {
        return ($name === null ? $this->phpInput() : $this->phpInput()[$name] ?? $default);
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return new User();
    }


    /**
     * @param string $device
     * @return bool|int|null
     */
    public function is(string $device): ?bool
    {
        return $this->device()->is($device);
    }

    /**
     * this method is not very safe
     * @return bool
     */
    public function isAjax(): bool
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && $this->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @return MobileDetect
     */
    public function device(): MobileDetect
    {
        return new MobileDetect();
    }

    /**
     * @return Cookie
     */
    public function cookie(): Cookie
    {
        return new Cookie();
    }

    /**
     * @param array $rules
     * @return ValidateRequests
     */
    public function validateWithRules(array $rules): ValidateRequests
    {
        return (new ValidateRequests($this))
            ->rules($rules)
            ->validate();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->device()->$name(...$arguments);
    }

    /**
     * @return false|string
     * @throws JsonException
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString()
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /**
     * @param array $data
     * @return AdvanceValidateRequest
     */
    public function check(array $data): AdvanceValidateRequest
    {
        return (new AdvanceValidateRequest($data, $this));
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->post($name) ?: $this->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name=$value;
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->$name);
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }
}
