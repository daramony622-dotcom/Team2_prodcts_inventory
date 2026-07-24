<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

// Whitelist allowed stats keys to prevent any unexpected input in queries
$allowed_stats = ['categories', 'products', 'suppliers', 'stock_ins', 'stock_outs'];
$stats = [
    'categories' => 0,
    'products' => 0,
    'suppliers' => 0,
    'stock_ins' => 0,
    'stock_outs' => 0,
];

try {
    foreach ($stats as $key => $value) {
        if (in_array($key, $allowed_stats, true)) {
            $stmt = $pdo->query("SELECT COUNT(*) FROM `{$key}`");
            $stats[$key] = (int) $stmt->fetchColumn();
        }
    }
} catch (PDOException $e) {
    $statsError = 'Unable to load inventory stats right now.';
}

$graphLabels = [
    'categories' => 'Categories',
    'products'   => 'Products',
    'suppliers'  => 'Suppliers',
    'stock_ins'  => 'Stock In',
    'stock_outs' => 'Stock Out',
];
$chartLabels = array_values($graphLabels);
$chartCounts = array_map(function ($key) use ($stats) {
    return (int) ($stats[$key] ?? 0);
}, array_keys($graphLabels));
$chartColors = [
    'rgba(37, 99, 235, 0.8)',
    'rgba(99, 102, 241, 0.8)',
    'rgba(245, 158, 11, 0.8)',
    'rgba(16, 185, 129, 0.8)',
    'rgba(244, 63, 94, 0.8)',
];

ob_start();
?>

<!-- Main Header -->
<div class="mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Overview</h1>
            <p class="text-sm text-slate-500">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>!
            </p>
        </div>
        <div
            class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 text-xs font-semibold">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            System Online
        </div>
    </div>
</div>

<?php if (!empty($statsError)): ?>
<div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
    <?= htmlspecialchars($statsError) ?>
</div>
<?php endif; ?>

<!-- Stats / Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Categories</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $stats['categories'] ?></h3>
            </div>
            <div class="w-11 h-11 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-500">Live inventory record</div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Products</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $stats['products'] ?></h3>
            </div>
            <div class="w-11 h-11 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-500">Product master data</div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Suppliers</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $stats['suppliers'] ?></h3>
            </div>
            <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-truck"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-500">Supplier list</div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Stock In</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $stats['stock_ins'] ?></h3>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-down"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-500">Incoming stock</div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Stock Out</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $stats['stock_outs'] ?></h3>
            </div>
            <div class="w-11 h-11 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-up"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-500">Outgoing stock</div>
    </div>
</div>

<!-- Inventory Graph Section -->
<div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Inventory Chart</h2>
                <p class="text-sm text-slate-500">Live inventory totals across system modules.</p>
            </div>
            <span class="text-xs text-slate-500">Updated automatically</span>
        </div>
        <div style="position:relative; width:100%; height:320px;" class="mb-6">
            <canvas id="inventoryChart" data-labels='<?= json_encode($chartLabels, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                data-values='<?= json_encode($chartCounts, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                data-colors='<?= json_encode($chartColors, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'></canvas>
        </div>

        <!-- Fallback message shown only if Chart.js failed to load -->
        <p id="chartFallback"
            class="hidden text-sm text-rose-600 bg-rose-50 border border-rose-200 rounded-xl p-3 mb-6">
            Chart could not be loaded. Please check your internet connection or contact the administrator.
        </p>

        <div class="grid grid-cols-1 gap-4 mt-auto">
            <?php foreach ($graphLabels as $key => $label): ?>
            <?php $value = (int) ($stats[$key] ?? 0); ?>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            <?= htmlspecialchars($label) ?></p>
                        <p class="mt-1 text-2xl font-bold text-slate-800"><?= $value ?></p>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        <?= $value > 0 ? 'Active' : 'Empty' ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 h-fit">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Role Access</h2>
        <div class="space-y-3">
            <div class="rounded-xl bg-slate-50 p-3">
                <p class="text-xs text-slate-500 uppercase tracking-wide">Current Role</p>
                <h3 class="text-lg font-bold text-slate-800 capitalize">
                    <?= htmlspecialchars($_SESSION['user_role'] ?? 'Admin') ?></h3>
            </div>
            <div class="rounded-xl bg-blue-50 p-3">
                <p class="text-xs text-blue-700 uppercase tracking-wide">Dashboard Scope</p>
                <p class="text-sm text-slate-700">Admin can manage inventory, categories, and stock activity from one
                    place.</p>
            </div>
            <div class="rounded-xl bg-emerald-50 p-3">
                <p class="text-xs text-emerald-700 uppercase tracking-wide">Status</p>
                <p class="text-sm text-slate-700">The category management section is now connected and ready for
                    inventory updates.</p>
            </div>
        </div>
    </div>
</div>

<script src="chart.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../includes/layout/layout.php';