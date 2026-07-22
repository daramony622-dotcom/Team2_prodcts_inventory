<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

$productsQuery = 'SELECT id, product_name, quantity FROM products WHERE quantity > 0 ORDER BY product_name ASC';
$productsResult = $pdo->query($productsQuery);
$products = $productsResult->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<section class="space-y-6">
    <div class="bg-gradient-to-r from-rose-600 to-orange-500 text-white rounded-3xl px-6 py-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Add Stock Out</h1>
                <p class="text-rose-50 text-sm">Register outgoing stock for a sold or consumed item.</p>
            </div>
            <a href="index.php" class="inline-flex items-center justify-center bg-white text-slate-700 font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:bg-rose-50 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>
    </div>

    <?php if (isset($_GET['error'])): ?>
    <div class="rounded-2xl border border-rose-200 bg-rose-50 text-rose-700 px-4 py-3 text-sm">
        <?= htmlspecialchars($_GET['error']); ?>
    </div>
    <?php endif; ?>

    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="save.php" method="POST" class="space-y-4">
                <div>
                    <label for="product_id" class="block mb-1 text-sm font-semibold text-slate-700">Select Product</label>
                    <select name="product_id" id="product_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" required>
                        <option value="">-- Choose Product --</option>
                        <?php foreach ($products as $prod): ?>
                        <option value="<?= (int) $prod['id']; ?>">
                            <?= htmlspecialchars($prod['product_name']); ?> (Available Stock: <?= (int) $prod['quantity']; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block mb-1 text-sm font-semibold text-slate-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" min="1" required>
                </div>

                <div>
                    <label for="selling_price" class="block mb-1 text-sm font-semibold text-slate-700">Selling Price ($)</label>
                    <input type="number" step="0.01" name="selling_price" id="selling_price" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" min="0" required>
                </div>

                <div>
                    <label for="stock_out_date" class="block mb-1 text-sm font-semibold text-slate-700">Stock Out Date</label>
                    <input type="datetime-local" name="stock_out_date" id="stock_out_date" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" value="<?= date('Y-m-d\TH:i'); ?>" required>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white px-4 py-3 rounded-xl font-semibold shadow-sm transition">Save Stock Out</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../includes/layout/layout.php';
?>