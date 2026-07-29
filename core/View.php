<?php

namespace Core;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;

class View
{
    private Twig $twig;

    public function __construct()
    {
        $this->twig = Twig::create(
            root_path('resources/views'),
            ['cache' => false]
        );
    }

    public function render(Response $response, string $view, array $data = [], string $ext = 'html.twig'): Response
    {
        $view = str_replace('.', '/', $view) . '.' . $ext;
        return $this->twig->render($response, $view, $data);
    }

    public function getTwig(): Twig
    {
        return $this->twig;
    }
}
