<?php

return [
    'organization' => [
        'id' => 1,
        'name' => 'Bridgestone Latam',
        'title' => 'Bridgestone Latam',
        'description' => "Neumáticos",
        'keywords' => "",
        'lat' => "-33.010030",
        'lng' => "-58.528410",
        'city' => "CABA",
        'province' => "CABA",
        'country' => "Argentina"
    ],
    'dbconnection' => [
        'mysql_jla' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'fj-oms',
            'username' => 'root',
            'password' => 'ayd352008',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'mysql_online' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'localhost',
            'port' => '3306',
            'database' => '',
            'username' => '',
            'password' => '',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]
    ]
];
