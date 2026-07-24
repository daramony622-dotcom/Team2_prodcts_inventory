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

$productStmt = $pdo->prepare("SELECT id, category_id, supplier_id, product_name, product_code, price, quantity, description, image FROM products WHERE id = :id");
$productStmt->execute([':id' => $id]);
$product = $productStmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ' . APP_BASE_URL . '/products/index.php');
    exit;
}

$categoryStmt = $pdo->prepare("SELECT id, category_name AS name FROM categories ORDER BY category_name ASC");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

$supplierStmt = $pdo->prepare("SELECT id, supplier_name AS name FROM suppliers ORDER BY supplier_name ASC");
$supplierStmt->execute();
$suppliers = $supplierStmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="max-w-4xl mx-auto bg-white shadow rounded-3xl p-6 md:p-8">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Product</h1>

    <form action="save.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image'] ?? '') ?>">

        <div>
            <label class="block mb-2 font-medium text-slate-700">Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['product_name']) ?>" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Product Code</label>
            <input type="text" name="product_code" value="<?= htmlspecialchars($product['product_code']) ?>" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Category</label>
            <select name="category_id" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int) $cat['id'] ?>" <?= ((int) $cat['id'] === (int) $product['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Supplier</label>
            <select name="supplier_id" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                <?php foreach ($suppliers as $sup): ?>
                    <option value="<?= (int) $sup['id'] ?>" <?= ((int) $sup['id'] === (int) $product['supplier_id']) ? 'selected' : '' ?>><?= htmlspecialchars($sup['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Price</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars((string) $product['price']) ?>" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Quantity</label>
            <input type="number" name="quantity" value="<?= (int) $product['quantity'] ?>" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Description</label>
            <textarea name="description" rows="4" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">Current Image</label>
            <?php if (!empty($product['image'])): ?>
                <img src="<?= htmlspecialchars(BASE_URL . '/assets/uploads/products/' . $product['image']) ?>" width="120" class="rounded border bg-slate-50">
            <?php else: ?>
                <p class="text-sm text-slate-500">No image</p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block mb-2 font-medium text-slate-700">New Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded-lg p-3">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" name="update_product" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold">Update Product</button>
            <a href="index.php" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold">Cancel</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../includes/layout/layout.php';
?>