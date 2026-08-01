<?php

use Dotenv\Dotenv;

$root_path = root_path();

$dotenv = Dotenv::createImmutable($root_path);

if (file_exists("{$root_path}/.env")) {
    $dotenv->load();
}

$dotenv->required([
    'APP_ENV',
    'DB_HOST',
    'DB_USER',
    'DB_PASS',
    'DB_NAME',
    'DB_PORT',
]);
