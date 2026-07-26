<?php $current = basename(dirname($_SERVER['PHP_SELF'])); ?>
<?php $baseUrl = rtrim(APP_BASE_URL ?? (BASE_URL . '/inventory'), '/'); ?>

<aside
    class="fixed top-0 left-0 h-screen w-64 bg-slate-950/90 text-white shadow-[18px_0_90px_-40px_rgba(59,130,246,0.35)] border-r border-slate-800/70 backdrop-blur-xl">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-6 py-6 border-b border-slate-800">
        <div
            class="w-11 h-11 rounded-lg bg-sky-500/90 flex items-center justify-center shadow-[0_0_25px_rgba(56,189,248,0.25)]">
            <i class="fa-solid fa-box text-white text-xl"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold">Inventory</h2>
            <p class="text-xs text-slate-400">Management System</p>
        </div>
    </div>

    <!-- Menu -->
    <nav class="mt-6 px-4">

        <a href="<?= htmlspecialchars($baseUrl) ?>/dashboard/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300 mb-2
            <?= $current === 'dashboard' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-house w-5"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= htmlspecialchars($baseUrl) ?>/products/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300 mb-2
            <?= $current === 'products' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-box-open w-5 text-blue-400"></i>
            <span>Products</span>
        </a>

        <a href="<?= htmlspecialchars($baseUrl) ?>/categories/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300 mb-2
            <?= $current === 'categories' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-layer-group w-5 text-green-400"></i>
            <span>Categories</span>
        </a>

        <a href="<?= htmlspecialchars($baseUrl) ?>/suppliers/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300 mb-2
            <?= $current === 'suppliers' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-truck w-5 text-blue-400"></i>
            <span>Suppliers</span>
        </a>

        <a href="<?= htmlspecialchars($baseUrl) ?>/stock_in/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300 mb-2
            <?= $current === 'stock_in' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-arrow-down w-5 text-emerald-400"></i>
            <span>Stock In</span>
        </a>

        <a href="<?= htmlspecialchars($baseUrl) ?>/stock_out/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition duration-300
            <?= $current === 'stock_out' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' ?>">
            <i class="fa-solid fa-arrow-up w-5 text-red-400"></i>
            <span>Stock Out</span>
        </a>

    </nav>

    <!-- User -->
    <div class="absolute bottom-0 w-full border-t border-slate-700 p-4">
        <div class="flex items-center gap-3 mb-4">
            <img src="https://i.pinimg.com/1200x/8e/a4/14/8ea414f41647e6b3c009fccd954c1945.jpg"
                class="w-11 h-11 rounded-full border-2 border-blue-500">
            <div>
                <h4 class="font-semibold"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></h4>
                <p class="text-xs text-slate-400">
                    <?= htmlspecialchars(strtoupper($_SESSION['user_role'] ?? 'Administrator')) ?></p>
            </div>
        </div>

        <a href="<?= htmlspecialchars(BASE_URL) ?>/authentication/logout.php"
            class="flex items-center justify-center gap-3 bg-sky-500 hover:bg-sky-600 py-3 rounded-xl transition shadow-[0_12px_30px_-18px_rgba(56,189,248,0.8)]">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/client/pages/index.php"
            class="flex items-center justify-center mt-2  gap-3 bg-slate-700 hover:bg-slate-600 py-3 rounded-xl transition shadow-[0_12px_30px_-18px_rgba(56,189,248,0.8)]">
            <i class="fa-solid fa-home"></i>
            <span>Back to Client</span>
        </a>

    </div>

</aside>