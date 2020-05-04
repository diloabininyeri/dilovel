<?php
/**
 * @noinspection PhpIncludeInspection
 * @noinspection PhpUnused
 */

use App\Components\Arr\DotNotation;
use App\Components\DateTime\Now;
use App\Components\Env\EnvFile;
use App\Components\Http\SingletonRequest;
use App\Components\Http\Url;
use App\Components\Routers\GenerateRouter;
use App\Components\View\View;
use App\Components\Routers\Redirect\Redirect;

/**
 * @param $function
 * @return bool
 */
function fn_e($function)
{
    return function_exists($function);
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

function dd($param)
{
    var_dump($param);
    die();
}

function abort($status)
{
    http_response_code(404);
    view($status);
    die();
}

/**
 * @param null $name
 * @return mixed|Session|string|null
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
function assets($file)
{
    return sprintf('%s/public/%s', \url()->base(), trim($file, '/'));
}

/**
 * @param $name
 * @param array $parameters
 * @return string
 */
function router($name, array $parameters = [])
{
    return (new GenerateRouter())->url($name, $parameters);
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
 *
 */
function activate_errors()
{
    if (env('ERROR_REPORTING')==='true') {
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 1);
    }

    ini_set('error_log', 'src/logs/error.log');
}

/**
 * @return SingletonRequest
 */
function request()
{
    return SingletonRequest::getInstance();
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
function env($name, $default=null)
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
 * @return array|mixed|null
 */
function config(string $config)
{
    $dotConfig=explode('.', $config);
    $configArray=get_config_array($dotConfig[0]);
    $array=$dotConfig;
    unset($array[0]);

    return (new DotNotation())->getValueByKey(implode('.', $array), $configArray);
}

/**
 * @param string $name
 * @return mixed|string|null
 */
function flash(string $name)
{
    return (new App\Components\Flash\Flash())->get($name);
}