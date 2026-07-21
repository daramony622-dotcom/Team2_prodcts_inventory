<?php
    require_once __DIR__ . '/session.php';

// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../authentication/login.php');
//     exit;
// }
    // Check whether the user is logged in.
    function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
    
    // Protect private pages
    function requiredLogin(): void{
        if(!isLoggedIn()){
            header("Location: ./client/index.php");
            exit();
        }
    }
    
    // Redirect logged-in users away from the login page.
    function redirectIfLogin(): void{
        if(isLoggedIn()){
            header("Location: ./dashboard/index.php");
            exit();
        }
    }
    

  // Save user information into the session after successful login.

function login(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    $_SESSION['LAST_ACTIVITY'] = time();
}

    // Destroy the session and log the user out.
function logout(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
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

    header("Location: ../page/index.php");
    exit();
}
?>