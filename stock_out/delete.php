<?php
require_once '../config/database.php';
require_once '../includes/session.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch stock_out entry details first
    $fetch_query = "SELECT product_id, quantity FROM stock_out WHERE id = $id";
    $result = mysqli_query($conn, $fetch_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        mysqli_begin_transaction($conn);

        try {
            // 1. Return stock quantity back to product inventory
            $update_product = "UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id";
            if (!mysqli_query($conn, $update_product)) {
                throw new Exception("Failed to restore product quantity.");
            }

            // 2. Delete stock_out record
            $delete_query = "DELETE FROM stock_out WHERE id = $id";
            if (!mysqli_query($conn, $delete_query)) {
                throw new Exception("Failed to delete stock out record.");
            }

            mysqli_commit($conn);
            header("Location: index.php?success=Record deleted and quantity restored to inventory.");
            exit();

        } catch (Exception $e) {
            mysqli_rollback($conn);
            header("Location: index.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: index.php?error=Record not found.");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
