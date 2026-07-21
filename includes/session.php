<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/Team2_prodcts_inventory');
}

define('SESSION_TIMEOUT', 1800); // 30 minutes
define('REGEN_INTERVAL', 900);   // 15 minutes

// 1. Timeout check (Inactivity)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();

    // Check if request is AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
        exit;
    }

    header('Location: ' . BASE_URL . '/authentication/login.php');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

// 2. Periodic Session ID Regeneration
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > REGEN_INTERVAL) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}