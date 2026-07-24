<?php
/**
 * viewDetail/detailProducts.php
 * Returns a single product's details as JSON for the "View Details" modal.
 *
 * Expects: GET ?id=123
 * Adjust the require path, table name, and column names to match your schema.
 */

session_start();
header('Content-Type: application/json');

// ---- Auth guard (match the pattern used in your other AJAX endpoints) ----
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

require_once __DIR__ . '/../../config/config.php';

// ---- Validate input ----
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product id']);
    exit;
}

try {
    // Get product details with category and supplier info
    $sql = "SELECT
                p.id,
                p.product_name,
                p.product_code,
                p.description,
                p.price,
                p.quantity,
                p.image,
                c.category_name,
                s.supplier_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id
            WHERE p.id = :id
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    // Get stock in information (purchase history)
    $stockInSql = "SELECT 
                        SUM(quantity) AS total_stock_in,
                        MAX(stock_in_date) AS last_stock_in_date,
                        AVG(purchase_price) AS avg_purchase_price
                    FROM stock_ins 
                    WHERE product_id = :id";
    $stockInStmt = $pdo->prepare($stockInSql);
    $stockInStmt->execute(['id' => $id]);
    $stockIn = $stockInStmt->fetch(PDO::FETCH_ASSOC) ?: ['total_stock_in' => 0, 'last_stock_in_date' => null, 'avg_purchase_price' => 0];

    // Get stock out information (sales history)
    $stockOutSql = "SELECT 
                        SUM(quantity) AS total_stock_out,
                        MAX(stock_out_date) AS last_stock_out_date,
                        AVG(selling_price) AS avg_selling_price
                    FROM stock_outs 
                    WHERE product_id = :id";
    $stockOutStmt = $pdo->prepare($stockOutSql);
    $stockOutStmt->execute(['id' => $id]);
    $stockOut = $stockOutStmt->fetch(PDO::FETCH_ASSOC) ?: ['total_stock_out' => 0, 'last_stock_out_date' => null, 'avg_selling_price' => 0];

    // Calculate performance
    $totalSales = (int) ($stockOut['total_stock_out'] ?? 0);
    $performance = 'Low';
    if ($totalSales >= 200) {
        $performance = 'Excellent';
    } elseif ($totalSales >= 100) {
        $performance = 'Good';
    } elseif ($totalSales >= 50) {
        $performance = 'Fair';
    }

    $response = [
        'success' => true,
        'id' => (int) $product['id'],
        'name' => $product['product_name'],
        'code' => $product['product_code'],
        'description' => $product['description'] ?? 'No description available',
        'category' => $product['category_name'] ?? 'Uncategorized',
        'supplier' => $product['supplier_name'] ?? 'No Supplier',
        'price' => number_format((float) $product['price'], 2, '.', ''),
        'quantity' => (int) $product['quantity'],
        'image' => !empty($product['image']) ? BASE_URL . '/assets/uploads/products/' . $product['image'] : null,
        'total_stock_in' => (int) ($stockIn['total_stock_in'] ?? 0),
        'last_stock_in_date' => $stockIn['last_stock_in_date'] ?? 'Never',
        'avg_purchase_price' => number_format((float) ($stockIn['avg_purchase_price'] ?? 0), 2, '.', ''),
        'total_stock_out' => $totalSales,
        'last_stock_out_date' => $stockOut['last_stock_out_date'] ?? 'Never',
        'avg_selling_price' => number_format((float) ($stockOut['avg_selling_price'] ?? 0), 2, '.', ''),
        'performance' => $performance,
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    // Log the real error instead of exposing it in production
    error_log('detailProducts.php error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
}