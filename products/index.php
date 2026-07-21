<?php
require_once DIR . '/../config/database.php';

$sql = "SELECT p.*, c.name AS category_name, s.name AS supplier_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN suppliers s ON p.supplier_id = s.id
        ORDER BY p.id DESC";

$result = mysqli_query($conn, $sql);

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Products</h1>

    <a href="add.php"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        + Add Product
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="min-w-full border-collapse">
        <thead class="bg-slate-100">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Image</th>
                <th class="p-3 text-left">Product</th>
                <th class="p-3 text-left">Category</th>
                <th class="p-3 text-left">Supplier</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Qty</th>
                <th class="p-3 text-center">Action</th>
            </tr>
        </thead>

        <tbody>

            <?php if(mysqli_num_rows($result) > 0): ?>

                <?php while($row = mysqli_fetch_assoc($result)): ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="p-3">
                            <?= $row['id']; ?>
                        </td>

                        <td class="p-3">
                            <?php
                            $image = !empty($row['image'])
                                ? "../assets/uploads/products/" . $row['image']
                                : "../assets/images/default.png";
                            ?>

                            <img src="<?= $image; ?>"
                                 width="60"
                                 height="60"
                                 class="rounded border object-cover">
                        </td>

                        <td class="p-3">
                            <?= htmlspecialchars($row['name']); ?>
                        </td>

                        <td class="p-3">
                            <?= htmlspecialchars($row['category_name']); ?>
                        </td>

                        <td class="p-3">
                            <?= htmlspecialchars($row['supplier_name']); ?>
                        </td>

                        <td class="p-3">
                            $<?= number_format($row['price'],2); ?>
                        </td>

                        <td class="p-3">
                            <?= $row['quantity']; ?>
                        </td>

                        <td class="p-3 text-center">

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

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="8" class="text-center p-5 text-gray-500">
                        No products found.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>

<?php
$content = ob_get_clean();
require DIR . '/../includes/layout/layout.php';
?>