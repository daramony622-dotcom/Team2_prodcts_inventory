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
    echo json_encode(['success' => true, 'message' => 'Database connection established successfully.']);
} catch (PDOException $e) {
    error_log('DB connection error: ' . $e->getMessage());
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}