<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds

// Timeout check — log out and send back to login page
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php"); // adjust path to your actual login page
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['CREATED'])) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}