<?php

/**
 * Retorna a raiz do projeto
 *
 * @param string $dir
 * @return string
 */
function root_path(string $dir = ''): string
{
    $root = dirname(__DIR__, 1);

    return empty($dir)
        ? $root
        : $root . DIRECTORY_SEPARATOR . ltrim($dir, '/\\');
}
