<?php

use Slim\App;
use App\Http\Controllers\Home;

$home = new Home($view);

/** @var App $app */
$app->get('/', [$home, 'index']);
