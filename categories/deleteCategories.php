<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
$id = $_POST['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
}