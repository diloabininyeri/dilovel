<?php
include_once 'vendor/autoload.php';

use Blade\Blade;

error_reporting(E_STRICT | E_ALL);
ini_set('display_errors', 1);


function e($string)
{
    return htmlspecialchars($string);
}


$template = file_get_contents('deneme.blade.php');
$template = iconv("ISO-8859-9", 'UTF-8', $template);

$blade = new Blade();
$output = $blade->render($template);


file_put_contents('deneme.php', $output);

include_once 'deneme.php';
