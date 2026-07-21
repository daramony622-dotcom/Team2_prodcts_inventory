<?php
// =====================================
// Database Connection
// =====================================

$host   = "localhost";
$dbname = "inventory_db";
$user   = "root";
$pass   = "";

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    error_log('DB connection error: ' . $e->getMessage());
    throw $e;
}