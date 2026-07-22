<?php
require_once __DIR__ . '/../config/database.php';

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$sql = "SELECT p.*,
               c.name AS category_name,
               s.name AS supplier_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN suppliers s ON p.supplier_id = s.id";

if ($category_id > 0) {
    $sql .= " WHERE p.category_id = ?";
}

$sql .= " ORDER BY p.id DESC";

$stmt = mysqli_prepare($conn, $sql);

if ($category_id > 0) {
    mysqli_stmt_bind_param($stmt, "i", $category_id);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $image = !empty($row['image'])
            ? "../assets/uploads/products/" . $row['image']
            : "../assets/images/default.png";
?>

<tr>

    <td><?= $row['id']; ?></td>

    <td>
        <img src="<?= $image; ?>"
             width="60"
             height="60"
             class="rounded border">
    </td>

    <td><?= htmlspecialchars($row['name']); ?></td>

    <td><?= htmlspecialchars($row['category_name']); ?></td>

    <td><?= htmlspecialchars($row['supplier_name']); ?></td>

    <td>$<?= number_format($row['price'], 2); ?></td>

    <td><?= $row['quantity']; ?></td>

    <td>

        <a href="edit.php?id=<?= $row['id']; ?>"
           class="bg-yellow-500 text-white px-3 py-1 rounded">
            Edit
        </a>

        <a href="delete.php?id=<?= $row['id']; ?>"
           onclick="return confirm('Delete this product?')"
           class="bg-red-600 text-white px-3 py-1 rounded">
            Delete
        </a>

    </td>

</tr>

<?php
    }

} else {
?>

<tr>
    <td colspan="8" class="text-center py-4">
        No products found.
    </td>
</tr>

<?php
}
?>