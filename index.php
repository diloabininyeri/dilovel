<?php

use App\Bootstrap\Application;
use App\Components\NotFound;

require_once 'vendor/autoload.php';

Application::run();

include_once 'src/Routers/web.php';

echo NotFound::isCannotFindAny() ? "404":null;


