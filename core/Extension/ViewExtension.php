<?php

namespace Core\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ViewExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
        ];
    }

    public function asset(string $path): string
    {
        return url("assets/{$path}");
    }
}
