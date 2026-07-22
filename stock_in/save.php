<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = (int) ($_POST['product_id'] ?? 0);
    $quantity       = (int) ($_POST['quantity'] ?? 0);
    $purchase_price = (float) ($_POST['purchase_price'] ?? 0);
    $stock_in_date  = date('Y-m-d', strtotime($_POST['stock_in_date'] ?? date('Y-m-d')));
    $user_id        = (int) ($_SESSION['user_id'] ?? 0);

    if ($product_id <= 0 || $quantity <= 0 || $purchase_price < 0 || $stock_in_date === false) {
        header('Location: ' . BASE_URL . '/stock_in/stock_in_add.php?error=Invalid input data provided.');
        exit();
    }

    try {
        $productStmt = $pdo->prepare('SELECT id FROM products WHERE id = :product_id LIMIT 1');
        $productStmt->execute([':product_id' => $product_id]);

        if (!$productStmt->fetch(PDO::FETCH_ASSOC)) {
            header('Location: ' . BASE_URL . '/stock_in/stock_in_add.php?error=Product not found.');
            exit();
        }

        $pdo->beginTransaction();

        $insertStmt = $pdo->prepare(
            'INSERT INTO stock_ins (product_id, quantity, purchase_price, stock_in_date, user_id)
            VALUES (:product_id, :quantity, :purchase_price, :stock_in_date, :user_id)'
        );
        $insertStmt->execute([
            ':product_id' => $product_id,
            ':quantity' => $quantity,
            ':purchase_price' => $purchase_price,
            ':stock_in_date' => $stock_in_date,
            ':user_id' => $user_id,
        ]);

        $updateStmt = $pdo->prepare(
            'UPDATE products
            SET quantity = quantity + :quantity
            WHERE id = :product_id'
        );
        $updateStmt->execute([
            ':quantity' => $quantity,
            ':product_id' => $product_id,
        ]);

        $pdo->commit();
        header('Location: ' . BASE_URL . '/stock_in/index.php?success=Stock successfully added and product quantity updated.');
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header('Location: ' . BASE_URL . '/stock_in/stock_in_add.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ' . BASE_URL . '/stock_in/index.php');
    exit();
}