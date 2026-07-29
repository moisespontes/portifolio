<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Res;
use Psr\Http\Message\ServerRequestInterface as Req;

class Home
{
    public function index(Req $request, Res $response)
    {
        echo 'home';
        return $response;
    }
}
