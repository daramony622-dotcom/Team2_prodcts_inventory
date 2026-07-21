<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

try {
    $stmt = $pdo->prepare(
        "SELECT id, category_name AS name, description FROM categories ORDER BY id DESC"
    );
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data'   => $categories
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to fetch categories.'
    ]);
}
