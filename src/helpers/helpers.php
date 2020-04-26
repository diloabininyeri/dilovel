<?php /** @noinspection PhpIncludeInspection */

use App\Components\Http\Url;
use App\Components\Routers\RouterName;

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
    return  (new \App\Components\View\View($file,$params))->compile();
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
 * @return string
 */
function router($name)
{
    $path = RouterName::getName($name);
    return url()->base() . '/' . $path;
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