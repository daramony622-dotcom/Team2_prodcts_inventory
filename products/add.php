<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

$categoryStmt = $pdo->prepare("SELECT id, category_name AS name FROM categories ORDER BY category_name ASC");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

$supplierStmt = $pdo->prepare("SELECT id, supplier_name AS name FROM suppliers ORDER BY supplier_name ASC");
$supplierStmt->execute();
$suppliers = $supplierStmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="max-w-4xl mx-auto bg-white shadow rounded-3xl p-6 md:p-8">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Add Product</h1>

    <form action="save.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block mb-2 font-medium text-slate-700">Product Name</label>
            <input type="text" name="name"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="Enter product name" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Product Code</label>
            <input type="text" name="product_code"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="e.g. P-1001" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Category</label>
            <select name="category_id"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Supplier</label>
            <?php if (!empty($suppliers)): ?>
            <select name="supplier_id"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required>
                <option value="">-- Select Supplier --</option>
                <?php foreach ($suppliers as $supplier): ?>
                <option value="<?= (int) $supplier['id'] ?>"><?= htmlspecialchars($supplier['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php else: ?>
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-3 text-sm text-amber-700">
                No suppliers are available yet. Please add a supplier first before creating a product.
            </div>
            <select name="supplier_id" class="w-full border border-slate-300 rounded-lg p-3 bg-slate-100 mt-3" disabled>
                <option value="">-- Select Supplier --</option>
            </select>
            <?php endif; ?>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Price ($)</label>
            <input type="number" name="price" step="0.01" min="0"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Quantity</label>
            <input type="number" name="quantity" min="0"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Description</label>
            <textarea name="description" rows="4"
                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"></textarea>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Product Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded-lg p-3">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" name="save_product"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold <?= empty($suppliers) ? 'opacity-50 cursor-not-allowed' : '' ?>"
                <?= empty($suppliers) ? 'disabled' : '' ?>>Save Product</button>
            <a href="index.php"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">Cancel</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../includes/layout/layout.php';
?>