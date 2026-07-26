<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

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
    'rgba(59, 130, 246, 0.95)',
    'rgba(37, 99, 235, 0.85)',
    'rgba(14, 165, 233, 0.8)',
    'rgba(56, 189, 248, 0.78)',
    'rgba(29, 78, 216, 0.75)',
];

ob_start();
?>

<!-- Main Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-sky-300/80">Inventory Control</p>
            <h1 class="mt-2 text-3xl lg:text-4xl font-semibold text-slate-100">Dashboard Overview</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-400">Welcome back,
                <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>. Here are your latest inventory insights in a
                polished control panel.</p>
        </div>
        <div
            class="inline-flex items-center gap-2 rounded-full border border-sky-500/20 bg-slate-900/55 px-4 py-2 text-sm text-slate-200 shadow-[0_15px_30px_-24px_rgba(56,189,248,0.5)]">
            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 animate-pulse"></span>
            System Online
        </div>
    </div>
</div>

<?php if (!empty($statsError)): ?>
<div class="mb-6 rounded-xl border border-amber-500/20 bg-slate-900/85 px-4 py-3 text-sm text-amber-200">
    <?= htmlspecialchars($statsError) ?>
</div>
<?php endif; ?>

<!-- Stats / Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5 mb-10">
    <div
        class="bg-slate-950/70 p-5 rounded-[2rem] shadow-[0_30px_80px_-55px_rgba(56,189,248,0.45)] border border-slate-800/60 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 mb-1">Categories</p>
                <h3 class="text-3xl font-bold text-slate-100"><?= $stats['categories'] ?></h3>
            </div>
            <div
                class="flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-500/10 text-sky-300 shadow-[0_0_24px_rgba(56,189,248,0.24)]">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-400/90">Live inventory record</div>
    </div>

    <div
        class="bg-slate-950/70 p-5 rounded-[2rem] shadow-[0_30px_80px_-55px_rgba(56,189,248,0.45)] border border-slate-800/60 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 mb-1">Products</p>
                <h3 class="text-3xl font-bold text-slate-100"><?= $stats['products'] ?></h3>
            </div>
            <div
                class="flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-500/10 text-sky-300 shadow-[0_0_24px_rgba(56,189,248,0.24)]">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-400/90">Product master data</div>
    </div>

    <div
        class="bg-slate-950/70 p-5 rounded-[2rem] shadow-[0_30px_80px_-55px_rgba(56,189,248,0.45)] border border-slate-800/60 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 mb-1">Suppliers</p>
                <h3 class="text-3xl font-bold text-slate-100"><?= $stats['suppliers'] ?></h3>
            </div>
            <div
                class="flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-500/10 text-sky-300 shadow-[0_0_24px_rgba(56,189,248,0.24)]">
                <i class="fa-solid fa-truck"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-400/90">Supplier list</div>
    </div>

    <div
        class="bg-slate-950/70 p-5 rounded-[2rem] shadow-[0_30px_80px_-55px_rgba(56,189,248,0.45)] border border-slate-800/60 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 mb-1">Stock In</p>
                <h3 class="text-3xl font-bold text-slate-100"><?= $stats['stock_ins'] ?></h3>
            </div>
            <div
                class="flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-500/10 text-sky-300 shadow-[0_0_24px_rgba(56,189,248,0.24)]">
                <i class="fa-solid fa-arrow-down"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-400/90">Incoming stock</div>
    </div>

    <div
        class="bg-slate-950/70 p-5 rounded-[2rem] shadow-[0_30px_80px_-55px_rgba(56,189,248,0.45)] border border-slate-800/60 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 mb-1">Stock Out</p>
                <h3 class="text-3xl font-bold text-slate-100"><?= $stats['stock_outs'] ?></h3>
            </div>
            <div
                class="flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-500/10 text-sky-300 shadow-[0_0_24px_rgba(56,189,248,0.24)]">
                <i class="fa-solid fa-arrow-up"></i>
            </div>
        </div>
        <div class="mt-4 text-[11px] font-semibold text-slate-400/90">Outgoing stock</div>
    </div>
</div>

<!-- Inventory Graph Section -->
<div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6 mb-8">
    <div
        class="relative overflow-hidden rounded-[2rem] bg-slate-950/75 p-6 shadow-[0_35px_80px_-40px_rgba(56,189,248,0.4)] border border-slate-800/60 backdrop-blur-2xl">
        <div class="pointer-events-none absolute -right-10 top-6 h-36 w-36 rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-10 bottom-10 h-28 w-28 rounded-full bg-slate-500/10 blur-3xl">
        </div>
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-100">Inventory Chart</h2>
                <p class="text-sm text-slate-400">Live inventory totals across system modules.</p>
            </div>
            <span
                class="rounded-full border border-slate-700/60 bg-slate-900/60 px-3 py-1 text-xs text-slate-300">Updated
                automatically</span>
        </div>
        <div style="position:relative; width:100%; height:320px;" class="mb-6 rounded-[1.5rem] bg-slate-900/80 p-4">
            <canvas id="inventoryChart" data-labels='<?= json_encode($chartLabels, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                data-values='<?= json_encode($chartCounts, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                data-colors='<?= json_encode($chartColors, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'></canvas>
        </div>

        <!-- Fallback message shown only if Chart.js failed to load -->
        <p id="chartFallback"
            class="hidden text-sm text-rose-300 bg-slate-900 border border-rose-500/20 rounded-xl p-3 mb-6">
            Chart could not be loaded. Please check your internet connection or contact the administrator.
        </p>

        <div class="grid grid-cols-1 gap-4 mt-auto">
            <?php foreach ($graphLabels as $key => $label): ?>
            <?php $value = (int) ($stats[$key] ?? 0); ?>
            <div
                class="rounded-3xl border border-slate-800/70 bg-slate-900/90 p-4 shadow-[0_18px_45px_-26px_rgba(56,189,248,0.28)]">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                            <?= htmlspecialchars($label) ?></p>
                        <p class="mt-2 text-2xl font-bold text-slate-100"><?= $value ?></p>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-xs font-semibold text-slate-300">
                        <?= $value > 0 ? 'Active' : 'Empty' ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div
        class="bg-slate-950/75 rounded-[2rem] p-6 shadow-[0_35px_90px_-50px_rgba(56,189,248,0.35)] border border-slate-800/60 h-fit backdrop-blur-2xl">
        <div class="flex items-center justify-between mb-5 gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-sky-300/80">Role Access</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-100">Control Panel</h2>
            </div>
            <span
                class="rounded-full border border-sky-500/20 bg-slate-900/65 px-3 py-1 text-xs text-sky-200">Secure</span>
        </div>
        <div class="space-y-4">
            <div
                class="rounded-3xl bg-slate-900/90 p-4 border border-slate-800 shadow-[0_12px_30px_-28px_rgba(56,189,248,0.25)]">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Current Role</p>
                <h3 class="mt-2 text-lg font-semibold text-slate-100 capitalize">
                    <?= htmlspecialchars($_SESSION['user_role'] ?? 'Admin') ?></h3>
            </div>
            <div
                class="rounded-3xl bg-slate-900/90 p-4 border border-slate-800 shadow-[0_12px_30px_-28px_rgba(56,189,248,0.25)]">
                <p class="text-xs text-sky-300 uppercase tracking-wide">Dashboard Scope</p>
                <p class="mt-2 text-sm text-slate-300">Admin can manage inventory, categories, and stock activity from
                    one place.</p>
            </div>
            <div
                class="rounded-3xl bg-slate-900/90 p-4 border border-slate-800 shadow-[0_12px_30px_-28px_rgba(56,189,248,0.25)]">
                <p class="text-xs text-sky-300 uppercase tracking-wide">Status</p>
                <p class="mt-2 text-sm text-slate-300">The category management section is now connected and ready for
                    inventory updates.</p>
            </div>
        </div>
    </div>
</div>

<script src="./chart.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../includes/layout/layout.php';