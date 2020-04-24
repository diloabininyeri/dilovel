<?php /** @noinspection PhpIncludeInspection */

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
 */
function view($file, $params = [])
{
    extract($params, EXTR_OVERWRITE);
    ob_start();
    include_once base_path("src\\views\\$file.php");
    return ob_get_clean();
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


function session($name = null)
{
    $session = new \App\Http\Session();
    if ($name === null) {
        return $session;
    }
    return $session->get($name);

}

/**
 * @return \App\Http\Url
 */
function url()
{
    return new \App\Http\Url();
}

function router($name)
{
    $path = \App\Components\Routers\RouterName::getName($name);
    return url()->base(). '/' . $path;
}

/**
 * @param $str
 * @return string
 */
function snakeToCamel ($str) {
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