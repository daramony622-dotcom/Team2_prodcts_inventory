<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();

$productsQuery = 'SELECT id, product_name, quantity FROM products ORDER BY product_name ASC';
$productsResult = $pdo->query($productsQuery);
$products = $productsResult->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<section class="space-y-6">
    <div class="bg-gradient-to-r from-slate-900 via-slate-950 to-sky-700 text-slate-100 rounded-3xl px-6 py-8 shadow-[0_35px_70px_-30px_rgba(56,189,248,0.22)]">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Add Stock In</h1>
                <p class="text-slate-300 text-sm">Register incoming stock for an existing product.</p>
            </div>
            <a href="index.php"
                class="inline-flex items-center justify-center bg-slate-950 border border-slate-800 text-slate-100 font-semibold px-4 py-2.5 rounded-2xl shadow-lg shadow-sky-500/10 hover:bg-slate-900 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>
    </div>

    <?php if (isset($_GET['error'])): ?>
    <div class="rounded-2xl border border-rose-500/20 bg-slate-950/70 text-rose-200 px-4 py-3 text-sm">
        <?= htmlspecialchars($_GET['error']); ?>
    </div>
    <?php endif; ?>

    <div class="max-w-3xl mx-auto bg-slate-950 rounded-[2rem] shadow-[0_35px_90px_-40px_rgba(56,189,248,0.25)] border border-slate-800 overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="save.php" method="POST" class="space-y-4">
                <div>
                    <label for="product_id" class="block mb-1 text-sm font-semibold text-slate-200">Select
                        Product</label>
                    <select name="product_id" id="product_id"
                        class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-900 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                        required>
                        <option value="">-- Choose Product --</option>
                        <?php foreach ($products as $prod): ?>
                        <option value="<?= (int) $prod['id']; ?>">
                            <?= htmlspecialchars($prod['product_name']); ?> (Current Stock:
                            <?= (int) $prod['quantity']; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block mb-1 text-sm font-semibold text-slate-200">Quantity</label>
                    <input type="number" name="quantity" id="quantity"
                        class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-900 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                        min="1" required>
                </div>

                <div>
                    <label for="purchase_price" class="block mb-1 text-sm font-semibold text-slate-200">Purchase Price
                        ($)</label>
                    <input type="number" step="0.01" name="purchase_price" id="purchase_price"
                        class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-900 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                        min="0" required>
                </div>

                <div>
                    <label for="stock_in_date" class="block mb-1 text-sm font-semibold text-slate-200">Stock In
                        Date</label>
                    <input type="datetime-local" name="stock_in_date" id="stock_in_date"
                        class="w-full border border-slate-700 rounded-2xl px-3 py-2.5 bg-slate-900 text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                        value="<?= date('Y-m-d\TH:i'); ?>" required>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-sky-500 hover:bg-sky-600 text-white px-4 py-3 rounded-2xl font-semibold shadow-lg shadow-sky-500/20 transition">Save
                        Stock In</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../includes/layout/layout.php';
?>