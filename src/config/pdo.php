<?php

/**
 * database config settings
 */
return [

    'default' => [
        'database' => 'hmvc',
        'user' => 'admin',
        'password' => 'admin',
        'host' => 'localhost',
        'driver' => 'mysql'
    ],
    'mongodb' => [
        'database' => 'collections',
        'user' => 'root',
        'password' => null,
        'host' => 'localhost',
        'driver' => 'mongodb'
    ]
];
