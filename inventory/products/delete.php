<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();

if (!isset($_GET['id'])) {
    header('Location: ' . APP_BASE_URL . '/products/index.php');
    exit;
}

$id = (int) $_GET['id'];
$productStmt = $pdo->prepare('SELECT image FROM products WHERE id = :id');
$productStmt->execute([':id' => $id]);
$product = $productStmt->fetch(PDO::FETCH_ASSOC);

if ($product) {
    if (!empty($product['image'])) {
        $imagePath = __DIR__ . '/../../assets/uploads/products/' . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $deleteStmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
    $deleteStmt->execute([':id' => $id]);
}

header('Location: ' . APP_BASE_URL . '/products/index.php');
exit;
?>