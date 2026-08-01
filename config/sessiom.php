<?php

// Mitiga session fixation via cookie forjado
ini_set('session.use_strict_mode', '1');
// Aceita o ID da sessão apenas via cookies
ini_set('session.use_only_cookies', '1');
// Tempo que a sessão pode permanecer no servidor sem atividade
ini_set('session.gc_maxlifetime', '86400');

session_name('app_sessid');

session_set_cookie_params([
    'lifetime' => 86400,
    'path'     => '/',
    'domain'   => env('APP_DOMAIN') ?: '',
    'secure'   => env('APP_ENV') === 'prod',
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
