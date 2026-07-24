<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($name === '') {
    echo json_encode(['status' => 'error', 'message' => 'Name is required.']);
    exit;
}

try {
    if ($id) {
        $stmt = $pdo->prepare("UPDATE categories SET category_name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
    }

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save category.']);
}