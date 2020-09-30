<?php

// Value objects are used to reference parameters and services in the container

use core\Config;
use core\Reference\ParameterReference as PR;
use core\Reference\ServiceReference as SR;

return [
    Response::class => [
        'class' => Response::class,
    ]
    // MySql::class => [
    //     'arguments' => [
    //         'connection'    => ,
    //         'host'          => 'localhost',
    //         'port'          => '3306',
    //         'database'      => 'phpmvc',
    //         'username'      => 'root',
    //         'password'      => 'root',
    //         'dsn'           => '/Applications/MAMP/tmp/mysql/mysql.sock'
    //     ]
    // ]
];