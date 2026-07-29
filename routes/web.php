<?php

use Slim\App;
use App\Http\Controllers\Home;

/** @var App $app */
$app->get('/', [Home::class, 'index']);
