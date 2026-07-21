<?php
require_once __DIR__ . '/session.php';

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

// Protect private pages — call this explicitly at the top of any page that needs login.
function requiredLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /Team2_prodcts_inventory/authentication/login.php');
        exit;
    }
}
// Redirect logged-in users away from login/register pages, based on role.
function redirectIfLogin()
{
    if (isLoggedIn()) {
        if (strtolower($_SESSION['user_role'] ?? '') === 'admin') {
            header('Location: /Team2_prodcts_inventory/dashboard/index.php');
        } else {
            header('Location: /Team2_prodcts_inventory/client/pages/index.php');
        }
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
}

// Destroy the session and log the user out.
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

    header('Location: /Team2_prodcts_inventory/client/pages/index.php');
    exit();
}