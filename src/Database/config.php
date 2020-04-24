<?php

namespace App\Database;
/**
 * database config settings
 */
const config = [

    'default' => [
        'database' => 'deneme',
        'user' => 'root',
        'password' => null,
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