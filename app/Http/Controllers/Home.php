<?php

namespace App\Http\Controllers;

use Core\Controller;
use Psr\Http\Message\ResponseInterface as Res;
use Psr\Http\Message\ServerRequestInterface as Req;

class Home extends Controller
{
    public function index(Req $request, Res $response)
    {
        return $this->view->render($response, 'web.home');
    }
}
