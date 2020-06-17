<?php
/**
$multiple_servers = array(
array(
'host' => '127.0.0.1',
'port' => 6379,
'database' => 15,
'alias' => 'first',
),
array(
'host' => '127.0.0.1',
'port' => 6380,
'database' => 15,
'alias' => 'second',
),
);

 */
return [

    'host'=>env('REDIS_HOST', '127.0.0.1'),
    'port'=>env('REDIS_PORT', 6379),
    'database'=>2,
    'alias'=>'hmvc'
];
