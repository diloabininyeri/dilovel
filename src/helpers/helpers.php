<?php
/**
 * @noinspection PhpIncludeInspection
 * @noinspection PhpUnused
 */

use App\Components\Arr\DotNotation;
use App\Components\Cache\Memcache\Memcache;
use App\Components\Cache\ViewCache;
use App\Components\Captcha;
use App\Components\Cart\Cart;
use App\Components\Csrf\CsrfGuard;
use App\Components\Database\InfiniteOptional;
use App\Components\Database\Optional;
use App\Components\Database\PDOAdaptor;
use App\Components\DateTime\Now;
use App\Components\Env\EnvFile;
use App\Components\Flash\FlashError;
use App\Components\Flash\HtmlFormValuesStorage;
use App\Components\Http\SingletonRequest;
use App\Components\Http\Url;
use App\Components\Lang\Lang;
use App\Components\Queue\Queue;
use App\Components\Route\GenerateRoute;
use App\Components\View\Master;
use App\Components\View\View;
use App\Components\Route\Redirect\Redirect;
use App\Components\Flash\Flash;

/**
 * @param $function
 * @return bool
 */
function fn_e($function)
{
    return function_exists($function);
}

function master(string $view)
{
    return \view($view, Master::getViewShareVariables($view));
}

function db_path($file)
{
    $relative = implode(DIRECTORY_SEPARATOR, ['Database', $file]);
    return base_path($relative);
}

function base_path($file = null)
{
    return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $file;
}

/**
 * @param $file
 * @param array $params
 * @return false|string
 * @return false|string
 */
function view($file, $params = [])
{
    return (new View($file, $params))->compile();
}

/**
 * @param array $array
 * @param $item
 * @param int $index
 * @return array
 */
function array_push_between(array $array, $item, int $index)
{
    return array_merge(array_slice($array, 0, $index), [$item], array_slice($array, $index));
}

/**
 * @param string $connectionName
 * @return PDO
 */
function pdo(string $connectionName = 'default')
{
    return PDOAdaptor::connection($connectionName);
}

/**
 * @param $file
 * @param int $time
 * @param array $compact
 * @return mixed
 */
function view_cache($file, int $time, array $compact = [])
{
    $viewCache = new ViewCache();
    if ($viewCache->get()) {
        return $viewCache->get();
    }

    $viewCache->set(\view($file, $compact), $time);
    return $viewCache->get();
}

/**
 * @param $status
 */
function abort($status)
{
    http_response_code($status);
    die(view("errors.$status"));
}

/**
 * @param null $name
 * @return mixed|Session|string
 */
function session($name = null)
{
    $session = new Session();
    if ($name === null) {
        return $session;
    }
    return $session->get($name);
}

/**
 * @return Url
 */
function url()
{
    return new Url();
}

/**
 * @param $file
 * @return string
 */
function assets($file): string
{
    return sprintf('%s/public/%s', \url()->base(), trim($file, '/'));
}

/**
 * @param $name
 * @param array $parameters
 * @return GenerateRoute
 */
function route($name, array $parameters = [])
{
    return new GenerateRoute($name, $parameters);
}

/**
 * @param $str
 * @return string
 */
function snakeToCamel($str)
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
}

/**
 * @param $string
 * @return string
 */
function pascal_to_snake($string)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
}


/**
 * @param null $name
 * @return App|mixed
 */
function app($name = null)
{
    $app = new App();
    return $name === null ? $app : $app->get($name);
}

/**
 * @param string|null $view
 * @return string
 */
function view_path(?string $view = null)
{
    $viewPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'Views';
    if ($view === null) {
        return $viewPath;
    }
    return $viewPath . DIRECTORY_SEPARATOR . trim("$view.blade.php", '/');
}

/**
 * @param null $path
 * @return string
 */
function public_path($path = null)
{
    $basePath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public';
    if ($path === null) {
        return $basePath;
    }
    $path = trim($path, '/');
    return $basePath . DIRECTORY_SEPARATOR . $path;
}

/**
 *
 */
function activate_errors()
{
    if (env('ERROR_REPORTING') === 'true') {
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 1);
    }

    ini_set('error_log', 'src/logs/error.log');
}


function request()
{
    return SingletonRequest::get();
}

/**
 * @return Redirect
 */
function redirect()
{
    return new Redirect();
}

/**
 * @param $name
 * @param null $default
 * @return mixed|null
 */
function env($name, $default = null)
{
    return (new EnvFile('.env'))->getValue($name) ?: $default;
}

/**
 * @return Now
 */
function now()
{
    return new Now();
}

/**
 * @return string
 */
function config_path()
{
    return sprintf('%s/%s', getcwd(), 'src/config/');
}

/**
 * @param $configFile
 * @return mixed
 */
function get_config_array($configFile)
{
    return require sprintf('%s/%s.php', config_path(), $configFile);
}


/**
 * @param string $config
 * @return mixed
 */
function config(string $config)
{
    $dotConfig = explode('.', $config);
    $configArray = get_config_array($dotConfig[0]);
    $array = $dotConfig;
    unset($array[0]);

    return (new DotNotation())->getValueByKey(implode('.', $array), $configArray);
}

/**
 * @param string $name
 * @param null $type
 * @return mixed|string|null
 */
function flash(string $name, $type = null)
{
    return (new Flash())->get($name, $type);
}

/**
 * @param array $array
 * @return bool
 */
function is_assoc(array $array)
{
    if (array() === $array) {
        return false;
    }
    return array_keys($array) !== range(0, count($array) - 1);
}

/**
 * @param array $array
 * @return bool
 */
function is_multi(array $array)
{
    $rv = array_filter($array, 'is_array');
    return (count($rv) > 0);
}


/**
 * @param object $object
 * @return mixed
 * @throws JsonException
 */
function object_to_array(object $object)
{
    return json_decode(json_encode($object, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
}

/**
 * @return FlashError
 */
function error()
{
    return new FlashError();
}

/**
 * @return Cart
 */
function cart()
{
    return new Cart();
}

/**
 * @param $string
 * @return bool
 */
function is_json($string)
{
    return !empty($string) && is_string($string) && is_array(json_decode($string, true)) && json_last_error() == 0;
}

/**
 * @param $data
 */
function p_p($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function user()
{
    return new App\Components\Auth\User\User();
}

/**
 * @return Memcache
 */
function memcached()
{
    return Memcache::connection();
}

/**
 * @param $haystack
 * @param $needle
 * @return bool
 */
function starts_with($haystack, $needle)
{
    return (strpos($haystack, $needle) === 0);
}

/**
 * @param $haystack
 * @param $needle
 * @return bool
 */
function ends_with($haystack, $needle)
{
    $length = strlen($needle);
    if ($length === 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

/**
 * @return CsrfGuard
 */
function csrf()
{
    return new CsrfGuard();
}


function lang(string $dotNotation, $default = null)
{
    return Lang::get($dotNotation, $default);
}


function captcha()
{
    return (new Captcha())->inline();
}


function array_uunique(array $array, callable $comparator): array
{
    return array_unique_callback($array, $comparator);
}

function array_unique_callback(array $array, callable $comparator): array
{
    $unique_array = [];
    while (count($array) > 0) {
        $element = array_shift($array);
        $unique_array[] = $element;

        $array = array_udiff(
            $array,
            [$element],
            $comparator
        );
    }

    return $unique_array;
}


function response()
{
    return new App\Components\Http\Response\Response();
}

/**
 * @param $data
 * @return Optional
 */
function optional($data)
{
    return new Optional($data);
}

function infinite_optional($data)
{
    return new InfiniteOptional($data);
}
/**
 * @param array $array
 * @return array
 */
function array_flatten(array $array): array
{
    $return = array();
    array_walk_recursive($array, static function ($a) use (&$return) {
        $return[]=$a;
    });
    return $return;
}

/**
 * @param string $input
 * @param null $default
 * @return mixed|null
 */
function old(string $input, $default=null)
{
    return HtmlFormValuesStorage::getInstance()->get($input) ?: $default;
}

/**
 * @param string $queueName
 * @return Queue
 *
 */
function queue(string $queueName='default'): Queue
{
    return new Queue($queueName);
}
