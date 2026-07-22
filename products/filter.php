<?php
require_once __DIR__ . '/../config/config.php';

$category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;

$sql = "SELECT p.id, p.product_name, p.product_code, p.price, p.quantity, p.image, p.description,
                c.category_name,
                s.supplier_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN suppliers s ON p.supplier_id = s.id";

$params = [];

if ($category_id > 0) {
    $sql .= ' WHERE p.category_id = :category_id';
    $params[':category_id'] = $category_id;
}

$sql .= ' ORDER BY p.id DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($products)):
    foreach ($products as $row):
        $image = !empty($row['image'])
            ? BASE_URL . '/assets/uploads/products/' . $row['image']
            : BASE_URL . '/client/pages/assets/images/default.png';
?>

<tr>
    <td><?= (int) $row['id']; ?></td>
    <td>
        <img src="<?= htmlspecialchars($image); ?>" width="60" height="60" class="rounded border">
    </td>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td><?= htmlspecialchars($row['category_name'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($row['supplier_name'] ?? '-'); ?></td>
    <td>$<?= number_format((float) $row['price'], 2); ?></td>
    <td><?= (int) $row['quantity']; ?></td>
    <td>
        <a href="edit.php?id=<?= (int) $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded">
            Edit
        </a>
        <a href="delete.php?id=<?= (int) $row['id']; ?>" onclick="return confirm('Delete this product?')"
            class="bg-red-600 text-white px-3 py-1 rounded">
            Delete
        </a>
    </td>
</tr>

<?php
    endforeach;
else:
?>

<tr>
    <td colspan="8" class="text-center py-4">
        No products found.
    </td>
</tr>

<?php
endif;
?>