<?php
// categories/getCategories.php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/config.php';

try {
    // Select category fields
    $stmt = $pdo->query("SELECT id, category_name AS name, description FROM categories ORDER BY id DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to retrieve categories: ' . $e->getMessage()
    ]);
}