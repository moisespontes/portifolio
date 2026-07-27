<?php

use Dotenv\Dotenv;

// Importa o autoload do composer
require __DIR__ . '/../vendor/autoload.php';

// .env init
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Importa configurações inicias do app
require __DIR__ . '/../config/bootstrap.php';

ob_end_flush();
