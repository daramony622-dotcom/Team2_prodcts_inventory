<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
    }
    header("Location: ./client/pages/index.php");
    exit();
?>