<?php

use Dotenv\Dotenv;

// ---------------------------------------------------------------------
// Environment
// ---------------------------------------------------------------------
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ---------------------------------------------------------------------
// Timezone
// ---------------------------------------------------------------------
date_default_timezone_set('America/Sao_Paulo');

// ---------------------------------------------------------------------
// Session configuration
// ---------------------------------------------------------------------
ini_set('session.use_strict_mode', '1'); // mitiga session fixation via cookie forjado

session_name('app_sessid');

session_set_cookie_params([
    'lifetime' => 86400,
    'path'     => '/',
    'domain'   => $_ENV['APP_DOMAIN'] ?: '',
    'secure'   => $_ENV['APP_ENV'] === 'prod',
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
