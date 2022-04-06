<?php

return [
    'organization' => [
        'id' => 1,
        'name' => 'market',
        'title' => 'market',
        'description' => "mercado",
        'keywords' => "",
        'lat' => "-33.010030",
        'lng' => "-58.528410",
        'city' => "CABA",
        'province' => "CABA",
        'country' => "Argentina"
    ],
    'dbconnection' => [
        'mysql_fj' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'db',
            'port' => '3306',
            'database' => 'fj-market-demo',
            'username' => 'admin',
            'password' => 'XSslm_4n3vU',
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
        'mysql_com' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'db',
            'port' => '3306',
            'database' => 'fj-market-demo',
            'username' => 'admin',
            'password' => 'XSslm_4n3vU',
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
