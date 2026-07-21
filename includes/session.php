<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
    ]);
}

define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds
define('REGEN_INTERVAL', 900);   // 15 minutes in seconds

// 1. Timeout check (Inactivity)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// 2. Periodic Session ID Regeneration (Prevents Session Fixation)
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > REGEN_INTERVAL) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}