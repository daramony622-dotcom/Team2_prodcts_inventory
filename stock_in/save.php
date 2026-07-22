<?php
require_once '../config/database.php';
require_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = intval($_POST['product_id']);
    $quantity       = intval($_POST['quantity']);
    $purchase_price = floatval($_POST['purchase_price']);
    $stock_in_date  = mysqli_real_escape_string($conn, $_POST['stock_in_date']);
    $user_id        = $_SESSION['user_id'] ?? 1; // Fallback to user ID 1 if session is unassigned

    if ($product_id <= 0 || $quantity <= 0 || $purchase_price < 0) {
        header("Location: add.php?error=Invalid input data provided.");
        exit();
    }

    // Use transaction to ensure data integrity
    mysqli_begin_transaction($conn);

    try {
        // 1. Insert stock_in record
        $sql = "INSERT INTO stock_in (product_id, quantity, purchase_price, stock_in_date, user_id) 
                VALUES ($product_id, $quantity, $purchase_price, '$stock_in_date', $user_id)";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Failed to insert stock-in record.");
        }

        // 2. Update product quantity
        $update_product = "UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id";
        if (!mysqli_query($conn, $update_product)) {
            throw new Exception("Failed to update product quantity.");
        }

        mysqli_commit($conn);
        header("Location: index.php?success=Stock successfully added and product quantity updated.");
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