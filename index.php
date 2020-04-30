<?php

use App\Bootstrap\App;


require_once 'vendor/autoload.php';

activate_errors();

echo (new App())
    ->run()
    ->call404IfNotFound();