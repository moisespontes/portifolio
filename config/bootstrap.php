<?php

// time zone
date_default_timezone_set('America/Sao_Paulo');

// mitiga session fixation via cookie forjado
ini_set('session.use_strict_mode', '1');

// session name
session_name('app_sessid');

// configura sessão ANTES de iniciar
session_set_cookie_params([
    'lifetime' => 86400,
    'path'     => '/',
    'domain'   => $_ENV['APP_DOMAIN'] ?? '',
    'secure'   => $_ENV['APP_ENV'] === 'prod',
    'httponly' => true,
    'samesite' => 'Lax',
]);

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
