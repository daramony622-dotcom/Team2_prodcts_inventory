<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = (int) ($_POST['product_id'] ?? 0);
    $quantity       = (int) ($_POST['quantity'] ?? 0);
    $selling_price  = (float) ($_POST['selling_price'] ?? 0);
    $stock_out_date = date('Y-m-d', strtotime($_POST['stock_out_date'] ?? date('Y-m-d')));
    $user_id        = (int) ($_SESSION['user_id'] ?? 0);

    if ($product_id <= 0 || $quantity <= 0 || $selling_price < 0 || $stock_out_date === false) {
        header('Location: ' . APP_BASE_URL . '/stock_out/add.php?error=Invalid input data provided.');
        exit();
    }

    try {
        $checkStmt = $pdo->prepare('SELECT quantity FROM products WHERE id = :product_id LIMIT 1');
        $checkStmt->execute([':product_id' => $product_id]);
        $product = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header('Location: ' . APP_BASE_URL . '/stock_out/add.php?error=Product not found.');
            exit();
        }

        $current_stock = (int) $product['quantity'];
        if ($quantity > $current_stock) {
            header('Location: ' . BASE_URL . '/stock_out/add.php?error=' . urlencode("Cannot stock out! Requested ($quantity) exceeds current stock ($current_stock)."));
            exit();
        }

        $pdo->beginTransaction();

        $insertStmt = $pdo->prepare(
            'INSERT INTO stock_outs (product_id, quantity, selling_price, stock_out_date, user_id)
             VALUES (:product_id, :quantity, :selling_price, :stock_out_date, :user_id)'
        );
        $insertStmt->execute([
            ':product_id' => $product_id,
            ':quantity' => $quantity,
            ':selling_price' => $selling_price,
            ':stock_out_date' => $stock_out_date,
            ':user_id' => $user_id,
        ]);

        $updateStmt = $pdo->prepare(
            'UPDATE products
             SET quantity = quantity - :quantity
             WHERE id = :product_id'
        );
        $updateStmt->execute([
            ':quantity' => $quantity,
            ':product_id' => $product_id,
        ]);

        $pdo->commit();
        header('Location: ' . APP_BASE_URL . '/stock_out/index.php?success=Stock out saved and inventory updated successfully.');
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header('Location: ' . APP_BASE_URL . '/stock_out/add.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ' . APP_BASE_URL . '/stock_out/index.php');
    exit();
}