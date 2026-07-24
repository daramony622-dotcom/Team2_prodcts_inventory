<?php
header('Content-Type: application/json');
require_once __DIR__.'/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM suppliers WHERE id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
    }
}