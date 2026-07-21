<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Get Product
$sql = "SELECT image FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($product = mysqli_fetch_assoc($result)) {

    // Delete image file
    if (!empty($product['image'])) {

        $imagePath = __DIR__ . "/../assets/uploads/products/" . $product['image'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete product
    $delete = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;
?>