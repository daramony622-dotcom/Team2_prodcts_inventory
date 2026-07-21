<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds
    
    if(isset($_SESSION['LAST_ACTIVITY'])){
        if(time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT){
            session_unset();
            session_destroy();
            header("Location: /client/index.php");
            exit();
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
    if(!isset($_SESSION['CREATED'])){
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }
?>