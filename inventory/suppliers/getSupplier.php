<?php
header('Content-Type: application/json');
require_once __DIR__.'/../../config/config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Fetch single row for editing
    $stmt = $pdo->prepare("SELECT * FROM suppliers WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    // Fetch all rows
    $stmt = $pdo->query("SELECT * FROM suppliers ORDER BY id DESC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}