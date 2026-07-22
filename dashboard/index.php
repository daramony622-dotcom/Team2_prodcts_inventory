<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();

$stats = [
    'categories' => 0,
    'products' => 0,
    'suppliers' => 0,
    'stock_ins' => 0,
    'stock_outs' => 0,
];

try {
    foreach ($stats as $key => $value) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM {$key}");
        $stats[$key] = (int) $stmt->fetchColumn();
    }
} catch (PDOException $e) {
    $statsError = 'Unable to load inventory stats right now.';
}

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
            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
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
        <div class="mt-4 text-[11px] font-semibold text-slate-500">
            Live inventory record
        </div>
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
        <div class="mt-4 text-[11px] font-semibold text-slate-500">
            Product master data
        </div>
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
        <div class="mt-4 text-[11px] font-semibold text-slate-500">
            Supplier list
        </div>
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
        <div class="mt-4 text-[11px] font-semibold text-slate-500">
            Incoming stock
        </div>
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
        <div class="mt-4 text-[11px] font-semibold text-slate-500">
            Outgoing stock
        </div>
    </div>
</div>

<!-- Inventory Graph Section -->
<div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-800">Inventory Graph</h2>
            <span class="text-xs text-slate-500">All items</span>
        </div>

        <?php
        $graphMax = max($stats);
        $graphLabels = [
            'categories' => 'Categories',
            'products' => 'Products',
            'suppliers' => 'Suppliers',
            'stock_ins' => 'Stock In',
            'stock_outs' => 'Stock Out',
        ];
        $graphColors = [
            'categories' => 'from-blue-500 to-blue-600',
            'products' => 'from-indigo-500 to-indigo-600',
            'suppliers' => 'from-amber-500 to-amber-600',
            'stock_ins' => 'from-emerald-500 to-emerald-600',
            'stock_outs' => 'from-rose-500 to-rose-600',
        ];
        ?>

        <div class="space-y-4">
            <?php foreach ($graphLabels as $key => $label): ?>
            <?php $value = (int) ($stats[$key] ?? 0); ?>
            <?php $percent = $graphMax > 0 ? min(100, round(($value / $graphMax) * 100)) : 0; ?>
            <div>
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-semibold text-slate-700"><?= htmlspecialchars($label) ?></span>
                    <span class="text-slate-500"><?= $value ?></span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div class="h-3 rounded-full bg-gradient-to-r <?= $graphColors[$key] ?>"
                        style="width: <?= $percent ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
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

<?php
$content = ob_get_clean();
require __DIR__ . '/../includes/layout/layout.php';
?>