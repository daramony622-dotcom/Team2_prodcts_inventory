<?php
require_once '../config/database.php';
require_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = intval($_POST['product_id']);
    $quantity       = intval($_POST['quantity']);
    $selling_price  = floatval($_POST['selling_price']);
    $stock_out_date = mysqli_real_escape_string($conn, $_POST['stock_out_date']);
    $user_id        = $_SESSION['user_id'] ?? 1;

    if ($product_id <= 0 || $quantity <= 0 || $selling_price < 0) {
        header("Location: add.php?error=Invalid input data provided.");
        exit();
    }

    // Check available stock in database before reducing
    $check_stock = "SELECT quantity FROM products WHERE id = $product_id";
    $stock_res = mysqli_query($conn, $check_stock);
    
    if ($stock_res && mysqli_num_rows($stock_res) > 0) {
        $product = mysqli_fetch_assoc($stock_res);
        $current_stock = intval($product['quantity']);

        if ($quantity > $current_stock) {
            header("Location: add.php?error=" . urlencode("Cannot stock out! Requested ($quantity) exceeds current stock ($current_stock)."));
            exit();
        }
    } else {
        header("Location: add.php?error=Product not found.");
        exit();
    }

    // Process transaction safely
    mysqli_begin_transaction($conn);

    try {
        // 1. Insert into stock_out table
        $sql = "INSERT INTO stock_out (product_id, quantity, selling_price, stock_out_date, user_id) 
                VALUES ($product_id, $quantity, $selling_price, '$stock_out_date', $user_id)";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Failed to record stock out.");
        }

        // 2. Subtract from products inventory quantity
        $update_product = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
        if (!mysqli_query($conn, $update_product)) {
            throw new Exception("Failed to reduce product inventory.");
        }

        mysqli_commit($conn);
        header("Location: index.php?success=Stock out saved and inventory updated successfully.");
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: add.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}