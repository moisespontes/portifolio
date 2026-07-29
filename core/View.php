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

    public function render(Response $response, string $template, array $data = []): Response
    {
        return $this->twig->render($response, $template, $data);
    }

    public function getTwig(): Twig
    {
        return $this->twig;
    }
}
