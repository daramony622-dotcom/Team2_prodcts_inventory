<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

$query = "SELECT so.*, p.product_name AS product_name, u.username
          FROM stock_outs so
          LEFT JOIN products p ON so.product_id = p.id
          LEFT JOIN users u ON so.user_id = u.id
          ORDER BY so.stock_out_date DESC";
$stmt = $pdo->query($query);
$stockRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<section class="space-y-6">
    <div class="bg-gradient-to-r from-rose-600 to-orange-500 text-white rounded-3xl px-6 py-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Stock Out Management</h1>
                <p class="text-rose-50 text-sm">Track sales and outgoing inventory records.</p>
            </div>
            <a href="add.php"
                class="inline-flex items-center justify-center bg-white text-rose-700 font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:bg-rose-50 transition">
                <i class="fa-solid fa-minus mr-2"></i> Add New Stock Out
            </a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
        <?= htmlspecialchars($_GET['success']); ?>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="rounded-2xl border border-rose-200 bg-rose-50 text-rose-700 px-4 py-3 text-sm">
        <?= htmlspecialchars($_GET['error']); ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-3 flex-wrap">
            <div>
                <h2 class="text-lg font-bold text-slate-800">All Stock Out Records</h2>
                <p class="text-xs text-slate-500">Outgoing inventory log</p>
            </div>
            <div class="rounded-xl bg-rose-50 border border-rose-100 px-3 py-2 text-sm font-semibold text-rose-700">
                Total: <?= count($stockRows) ?>
            </div>
        </div>

        <div class="overflow-x-auto p-4 md:p-5">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl">#ID</th>
                        <th class="py-3.5 px-4">Product</th>
                        <th class="py-3.5 px-4">Quantity</th>
                        <th class="py-3.5 px-4">Selling Price</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4 rounded-r-xl text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    <?php if (!empty($stockRows)): ?>
                    <?php foreach ($stockRows as $row): ?>
                    <tr class="align-top">
                        <td class="py-4 px-4 font-medium text-slate-900 bg-white rounded-l-xl shadow-sm">
                            #<?= (int) $row['id']; ?></td>
                        <td class="py-4 px-4 bg-white shadow-sm font-semibold text-slate-800">
                            <?= htmlspecialchars($row['product_name'] ?? 'Unknown Product'); ?>
                        </td>
                        <td class="py-4 px-4 bg-white shadow-sm">
                            <span
                                class="inline-flex items-center rounded-full bg-rose-100 text-rose-700 px-3 py-1 text-xs font-bold">-<?= (int) $row['quantity']; ?></span>
                        </td>
                        <td class="py-4 px-4 bg-white shadow-sm">
                            $<?= number_format((float) $row['selling_price'], 2); ?></td>
                        <td class="py-4 px-4 bg-white shadow-sm"><?= htmlspecialchars($row['stock_out_date']); ?></td>
                        <td class="py-4 px-4 bg-white shadow-sm"><?= htmlspecialchars($row['username'] ?? 'System'); ?>
                        </td>
                        <td class="py-4 px-4 text-center bg-white rounded-r-xl shadow-sm">
                            <a href="delete.php?id=<?= (int) $row['id']; ?>"
                                class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded text-xs font-semibold"
                                onclick="return confirm('Are you sure you want to delete this record? This will return the stock back to inventory.');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 bg-white rounded-2xl shadow-sm">
                            <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                            <p class="text-sm font-medium">No stock-out records found.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../includes/layout/layout.php';
?>