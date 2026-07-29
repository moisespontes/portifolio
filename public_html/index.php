<?php

use Slim\Factory\AppFactory;

// Importa o autoload do composer
require __DIR__ . '/../vendor/autoload.php';

// Importa configurações inicias do app
require __DIR__ . '/../config/bootstrap.php';

$app = AppFactory::create();

// Importa as rotas
require __DIR__ . '/../routes/web.php';

$app->run();
