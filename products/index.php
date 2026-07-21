<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

$search = trim($_GET['search'] ?? '');
$categoryFilter = (int) ($_GET['category_id'] ?? 0);
$supplierFilter = (int) ($_GET['supplier_id'] ?? 0);

$categoryStmt = $pdo->query('SELECT id, category_name AS name FROM categories ORDER BY category_name ASC');
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

$supplierStmt = $pdo->query('SELECT id, supplier_name AS name FROM suppliers ORDER BY supplier_name ASC');
$suppliers = $supplierStmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT p.id, p.product_name, p.product_code, p.price, p.quantity, p.image, p.description,
            c.category_name, s.supplier_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN suppliers s ON p.supplier_id = s.id
        WHERE 1 = 1";

$params = [];

if ($search !== '') {
    $sql .= " AND (
        p.product_name LIKE :search
        OR p.product_code LIKE :search
        OR p.description LIKE :search
        OR c.category_name LIKE :search
        OR s.supplier_name LIKE :search
    )";
    $params[':search'] = '%' . $search . '%';
}

if ($categoryFilter > 0) {
    $sql .= ' AND p.category_id = :category_id';
    $params[':category_id'] = $categoryFilter;
}

if ($supplierFilter > 0) {
    $sql .= ' AND p.supplier_id = :supplier_id';
    $params[':supplier_id'] = $supplierFilter;
}

$sql .= ' ORDER BY p.id DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="flex-1 min-h-screen bg-gray-100 flex flex-col">
    <section
        class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white py-10 px-6 rounded-b-3xl mx-4 sm:mx-6 mt-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Product Management</h1>
                <p class="text-blue-100 text-sm md:text-base">Manage your product list, stock, and inventory records.
                </p>
            </div>
            <a href="add.php"
                class="inline-flex items-center justify-center bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow-sm hover:bg-blue-50 transition">
                <i class="fa-solid fa-plus mr-2"></i> Add Product
            </a>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 w-full mt-6 mb-12 flex-1">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">All Products</h2>
                        <p class="text-xs text-gray-500">Product catalog and stock overview</p>
                    </div>
                    <div
                        class="rounded-xl bg-blue-50 border border-blue-100 px-3 py-2 text-sm font-semibold text-blue-700">
                        Total: <?= count($products) ?>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-5 border-b border-gray-100 bg-slate-50">
                <form method="GET" action="index.php" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                    <div class="md:col-span-2">
                        <label
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Search product, code, supplier..."
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div>
                        <label
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Category</label>
                        <select name="category_id"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['id'] ?>"
                                <?= $categoryFilter === (int) $category['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Supplier</label>
                        <select name="supplier_id"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">All Suppliers</option>
                            <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= (int) $supplier['id'] ?>"
                                <?= $supplierFilter === (int) $supplier['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($supplier['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold shadow-sm">
                            Filter
                        </button>
                        <a href="index.php"
                            class="w-full text-center bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2.5 rounded-lg font-semibold">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto p-4 md:p-5">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 rounded-l-xl">ID</th>
                            <th class="py-3.5 px-4">Image</th>
                            <th class="py-3.5 px-4">Product</th>
                            <th class="py-3.5 px-4">Code</th>
                            <th class="py-3.5 px-4">Category</th>
                            <th class="py-3.5 px-4">Supplier</th>
                            <th class="py-3.5 px-4">Price</th>
                            <th class="py-3.5 px-4">Qty</th>
                            <th class="py-3.5 px-4 text-center rounded-r-xl">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $row): ?>
                        <tr class="align-top">
                            <td class="py-4 px-4 font-medium text-gray-900 bg-white rounded-l-xl shadow-sm">
                                #<?= (int) $row['id'] ?></td>
                            <td class="py-4 px-4 bg-white shadow-sm">
                                <?php
                                        $image = !empty($row['image']) ? $row['image'] : '';
                                        $imagePath = !empty($image) && file_exists(__DIR__ . '/../assets/uploads/products/' . $image)
                                            ? BASE_URL . '/assets/uploads/products/' . $image
                                            : BASE_URL . '/client/pages/assets/images/default.png';
                                        ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" width="60" height="60"
                                    class="rounded border object-cover bg-slate-50" alt="Product image">
                            </td>
                            <td class="py-4 px-4 font-semibold text-blue-600 bg-white shadow-sm">
                                <?= htmlspecialchars($row['product_name']) ?></td>
                            <td class="py-4 px-4 bg-white shadow-sm"><?= htmlspecialchars($row['product_code']) ?></td>
                            <td class="py-4 px-4 bg-white shadow-sm">
                                <?= htmlspecialchars($row['category_name'] ?? '-') ?></td>
                            <td class="py-4 px-4 bg-white shadow-sm">
                                <?= htmlspecialchars($row['supplier_name'] ?? '-') ?></td>
                            <td class="py-4 px-4 bg-white shadow-sm">$<?= number_format((float) $row['price'], 2) ?>
                            </td>
                            <td class="py-4 px-4 bg-white shadow-sm"><?= (int) $row['quantity'] ?></td>
                            <td class="py-4 px-4 text-center bg-white rounded-r-xl shadow-sm">
                                <div class="flex justify-center gap-2">
                                    <a href="edit.php?id=<?= (int) $row['id'] ?>"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-xs font-semibold">Edit</a>
                                    <a href="delete.php?id=<?= (int) $row['id'] ?>"
                                        onclick="return confirm('Delete this product?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400 bg-white rounded-2xl shadow-sm">
                                <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                                <p class="text-sm font-medium">No products found.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../includes/layout/layout.php';
?>