<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

// Required admin security check
requiredAdmin();

$search = trim($_GET['search'] ?? '');
$categoryFilter = (int) ($_GET['category_id'] ?? 0);
$supplierFilter = (int) ($_GET['supplier_id'] ?? 0);

// Fetch categories for dropdown
$categoryStmt = $pdo->query('SELECT id, category_name AS name FROM categories ORDER BY category_name ASC');
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch suppliers for dropdown
$supplierStmt = $pdo->query('SELECT id, supplier_name AS name FROM suppliers ORDER BY supplier_name ASC');
$suppliers = $supplierStmt->fetchAll(PDO::FETCH_ASSOC);

// Build query
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

<div class="flex-1 min-h-screen bg-slate-950 text-slate-100 flex flex-col">
    <section
        class="bg-gradient-to-r from-slate-900 via-slate-950 to-sky-700 text-slate-100 py-10 px-6 rounded-b-3xl mx-4 sm:mx-6 mt-4 shadow-[0_35px_90px_-40px_rgba(56,189,248,0.2)]">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Product Management</h1>
                <p class="text-slate-300 text-sm md:text-base">Manage your product list, stock, and inventory records.
                </p>
            </div>
            <a href="add.php"
                class="inline-flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 py-2 rounded-2xl shadow-lg shadow-sky-500/20 transition">
                <i class="fa-solid fa-plus mr-2"></i> Add Product
            </a>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 w-full mt-6 mb-12 flex-1">
        <div
            class="bg-slate-900/85 rounded-[2rem] shadow-[0_35px_90px_-45px_rgba(56,189,248,0.25)] border border-slate-800/70 overflow-hidden">
            <div class="p-5 border-b border-slate-800">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                    <div>
                        <h2 class="text-lg font-bold text-slate-100">All Products</h2>
                        <p class="text-xs text-slate-400">Product catalog and stock overview</p>
                    </div>
                    <div
                        class="rounded-xl bg-slate-950/75 border border-slate-800 px-3 py-2 text-sm font-semibold text-sky-300">
                        Total: <?= count($products) ?>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-5 border-b border-slate-800 bg-slate-950/70">
                <form method="GET" action="index.php" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                    <div class="md:col-span-2">
                        <label
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Search</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Search product, code, supplier..."
                            class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-950 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                    </div>

                    <div>
                        <label
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Category</label>
                        <select name="category_id"
                            class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-950 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
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
                            class="block mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Supplier</label>
                        <select name="supplier_id"
                            class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-950 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
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
                            class="w-full bg-sky-500 hover:bg-sky-600 text-white px-4 py-2.5 rounded-2xl font-semibold shadow-sm shadow-sky-500/20">
                            Filter
                        </button>
                        <a href="index.php"
                            class="w-full text-center bg-slate-800 hover:bg-slate-700 text-slate-100 px-4 py-2.5 rounded-2xl font-semibold">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto p-4 md:p-5 bg-slate-950/80">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-slate-900 text-slate-300 text-xs font-semibold uppercase tracking-wider">
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
                    <tbody class="text-sm text-slate-200">
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $row): ?>
                        <tr class="align-top">
                            <td class="py-4 px-4 font-medium text-slate-100 bg-slate-900/80 rounded-l-xl shadow-sm">
                                #<?= (int) $row['id'] ?>
                            </td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm">
                                <?php
                                    $image = !empty($row['image']) ? trim($row['image']) : '';
                                    if (!empty($image) && file_exists(__DIR__ . '/../../assets/uploads/products/' . $image)) {
                                        $imagePath = BASE_URL . '/assets/uploads/products/' . $image;
                                    } else {
                                        $imagePath = 'https://placehold.co/100x100/1e293b/94a3b8?text=No+Image';
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" width="60" height="60"
                                    class="w-14 h-14 rounded-lg border border-slate-700 object-cover bg-slate-950"
                                    alt="<?= htmlspecialchars($row['product_name']) ?>">
                            </td>
                            <td class="py-4 px-4 font-semibold text-sky-300 bg-slate-900/80 shadow-sm">
                                <?= htmlspecialchars($row['product_name']) ?>
                            </td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm">
                                <?= htmlspecialchars($row['product_code']) ?></td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm">
                                <?= htmlspecialchars($row['category_name'] ?? '-') ?></td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm">
                                <?= htmlspecialchars($row['supplier_name'] ?? '-') ?></td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm">
                                $<?= number_format((float) $row['price'], 2) ?>
                            </td>
                            <td class="py-4 px-4 bg-slate-900/80 shadow-sm"><?= (int) $row['quantity'] ?></td>
                            <td class="py-4 px-4 text-center bg-slate-900/80 rounded-r-xl shadow-sm">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        class="view-product-btn bg-sky-500 hover:bg-sky-600 text-white px-3 py-1 rounded text-xs font-semibold"
                                        data-id="<?= (int) $row['id'] ?>">View</button>
                                    <a href="edit.php?id=<?= (int) $row['id'] ?>"
                                        class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1 rounded text-xs font-semibold">Edit</a>
                                    <a href="delete.php?id=<?= (int) $row['id'] ?>"
                                        onclick="return confirm('Delete this product?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9"
                                class="py-12 text-center text-slate-400 bg-slate-900/80 rounded-2xl shadow-sm">
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

// Fixed jQuery path via CDN
$pageScripts = '<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>';

ob_start();
require_once __DIR__ . '/../viewDetail/productDetailModel.php';
$pageScripts .= ob_get_clean();

require_once __DIR__ . '/../../includes/layout/layout.php';
?>