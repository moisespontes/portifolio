<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/environment.php';

return [
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds'      => 'db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'development',

        'development' => [
            'adapter'   => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 3306),
            'name'      => env('DB_NAME'),
            'user'      => env('DB_USER', 'root'),
            'pass'      => env('DB_PASS', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ],

    'version_order' => 'creation',
];
