<?php
header('Content-Type: application/json');
require_once __DIR__. '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id            = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $supplier_name = trim($_POST['supplier_name'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $address       = trim($_POST['address'] ?? '');

    if (empty($supplier_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Supplier name is required.']);
        exit;
    }

    try {
        if ($id) {
            // UPDATE
            $sql = "UPDATE suppliers SET supplier_name = :sname, phone = :phone, email = :email, address = :address WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':sname'   => $supplier_name,
                ':phone'   => $phone,
                ':email'   => $email,
                ':address' => $address,
                ':id'      => $id
            ]);
        } else {
            // INSERT
            $sql = "INSERT INTO suppliers (supplier_name, phone, email, address) VALUES (:sname, :phone, :email, :address)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':sname'   => $supplier_name,
                ':phone'   => $phone,
                ':email'   => $email,
                ':address' => $address
            ]);
        }

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}