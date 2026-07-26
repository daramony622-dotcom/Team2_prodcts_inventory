<?php
require_once __DIR__ . '/../../config/config.php';

header('Content-Type: application/json');

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT p.id, p.product_name, p.product_code, p.price, p.quantity, p.image, p.description,
               c.category_name, s.supplier_name 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN suppliers s ON p.supplier_id = s.id 
        WHERE 1=1";

$params = [];
if ($category_id > 0) {
    $sql .= " AND p.category_id = :category_id";
    $params[':category_id'] = $category_id;
}

$sql .= " ORDER BY p.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'status' => 'success',
    'data' => $products
]);
exit;