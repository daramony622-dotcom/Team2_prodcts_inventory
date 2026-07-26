<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();

$categoryStmt = $pdo->prepare("SELECT id, category_name AS name FROM categories ORDER BY category_name ASC");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

$supplierStmt = $pdo->prepare("SELECT id, supplier_name AS name FROM suppliers ORDER BY supplier_name ASC");
$supplierStmt->execute();
$suppliers = $supplierStmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="max-w-4xl mx-auto bg-slate-950/95 border border-slate-800 shadow-2xl shadow-sky-500/10 rounded-3xl p-6 md:p-8">
    <h1 class="text-2xl font-bold text-slate-100 mb-6">Add Product</h1>

    <form action="save.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block mb-2 font-medium text-slate-200">Product Name</label>
            <input type="text" name="name"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                placeholder="Enter product name" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Product Code</label>
            <input type="text" name="product_code"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                placeholder="e.g. P-1001" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Category</label>
            <select name="category_id"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Supplier</label>
            <?php if (!empty($suppliers)): ?>
            <select name="supplier_id"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                required>
                <option value="">-- Select Supplier --</option>
                <?php foreach ($suppliers as $supplier): ?>
                <option value="<?= (int) $supplier['id'] ?>"><?= htmlspecialchars($supplier['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php else: ?>
            <div class="rounded-3xl border border-slate-700 bg-slate-900/90 px-3 py-3 text-sm text-slate-300">
                No suppliers are available yet. Please add a supplier first before creating a product.
            </div>
            <select name="supplier_id" class="w-full border border-slate-700 rounded-2xl p-3 bg-slate-900 text-slate-500 mt-3" disabled>
                <option value="">-- Select Supplier --</option>
            </select>
            <?php endif; ?>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Price ($)</label>
            <input type="number" name="price" step="0.01" min="0"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Quantity</label>
            <input type="number" name="quantity" min="0"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Description</label>
            <textarea name="description" rows="4"
                class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-200">Product Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-slate-700 rounded-2xl bg-slate-900 text-slate-100 p-3">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" name="save_product"
                class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-2xl font-semibold <?= empty($suppliers) ? 'opacity-50 cursor-not-allowed' : '' ?>"
                <?= empty($suppliers) ? 'disabled' : '' ?>>Save Product</button>
            <a href="index.php"
                class="bg-slate-800 hover:bg-slate-700 text-slate-100 px-6 py-3 rounded-2xl font-semibold">Cancel</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../includes/layout/layout.php';
?>