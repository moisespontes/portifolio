<?php

/**
 * Retona uma variavel de ambiente
 */
function env(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false || $value === null) {
        return $default;
    }

    return match (strtolower((string) $value)) {
        'true', '(true)'   => true,
        'false', '(false)' => false,
        'null', '(null)'   => null,
        'empty', '(empty)' => '',
        default            => $value,
    };
}

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

// ##### URLs #####

/**
 * Base URL
 */
function url(string $path = ''): string
{
    $url = env('APP_URL');

    if ($path == '') {
        return $url;
    }

    return $url . '/' . ltrim($path, '/');
}
