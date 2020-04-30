<?php

use App\Bootstrap\App;


require_once 'vendor/autoload.php';

/**
 * activates errors to see errors in the app
 */
activate_errors();

/**
 *
 */
echo (new App())
    ->run()
    ->call404IfNotFound();