<?php

use App\Bootstrap\Application;
use App\Components\Routers\AllRouterCompare;
use App\Components\Routers\Dispatcher;
use App\Components\Routers\NotFound;
use App\Components\Routers\Printable;

require_once 'vendor/autoload.php';

activate_errors();
Application::run();

include_once 'src/Routers/web.php';

$compare = new AllRouterCompare();
$find=$compare->findWillWhichExecute();
$routeResponse = (new Dispatcher())->route($find);
$printable = new Printable($routeResponse);
$printable->output();

echo NotFound::isCannotFindAny() ? view('404') : null;


