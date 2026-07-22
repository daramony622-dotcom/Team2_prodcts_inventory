<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

if (isset($_GET['id'])) {
    $id = (int) ($_GET['id'] ?? 0);

    try {
        $fetchStmt = $pdo->prepare('SELECT product_id, quantity FROM stock_ins WHERE id = :id LIMIT 1');
        $fetchStmt->execute([':id' => $id]);
        $row = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            header('Location: ' . BASE_URL . '/stock_in/index.php?error=Record not found.');
            exit();
        }

        $product_id = (int) $row['product_id'];
        $quantity = (int) $row['quantity'];

        $pdo->beginTransaction();

        $updateStmt = $pdo->prepare(
            'UPDATE products
            SET quantity = quantity - :quantity
            WHERE id = :product_id'
        );
        $updateStmt->execute([
            ':quantity' => $quantity,
            ':product_id' => $product_id,
        ]);

        $deleteStmt = $pdo->prepare('DELETE FROM stock_ins WHERE id = :id');
        $deleteStmt->execute([':id' => $id]);

        $pdo->commit();
        header('Location: ' . BASE_URL . '/stock_in/index.php?success=Stock-in record deleted and product inventory updated successfully.');
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header('Location: ' . BASE_URL . '/stock_in/index.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ' . BASE_URL . '/stock_in/index.php');
    exit();
}