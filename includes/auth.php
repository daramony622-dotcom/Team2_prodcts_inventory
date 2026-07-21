<?php
require_once __DIR__ . '/session.php';

// Base URL path matching your project folder
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Team2_prodcts_inventory');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

// Redirect logged-in users away from login/register pages
function redirectIfLogin(): void
{
    if (isLoggedIn()) {
        $role = strtolower($_SESSION['user_role'] ?? '');
        
        if ($role === 'admin') {
            header('Location: ' . BASE_URL . '/dashboard/index.php');
        } else {
            header('Location: ' . BASE_URL . '/client/pages/index.php');
        }
        exit;
    }
}

// Restrict access to specific pages
function requiredLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/authentication/login.php');
        exit;
    }
}

function requiredAdmin(): void
{
    requiredLogin();

    if (strtolower($_SESSION['user_role'] ?? '') !== 'admin') {
        header('Location: ' . BASE_URL . '/client/pages/index.php');
        exit;
    }
}

function login(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user_id']       = $user['id'];
    $_SESSION['username']      = $user['username'];
    $_SESSION['user_role']     = $user['role'];
    $_SESSION['LAST_ACTIVITY'] = time();
    $_SESSION['CREATED']       = time();
}

function logout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();

    header('Location: ' . BASE_URL . '/client/pages/index.php');
    exit;
}