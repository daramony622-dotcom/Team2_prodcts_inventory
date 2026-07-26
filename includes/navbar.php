<nav class="h-16 flex items-center justify-between px-6 bg-slate-900/55 border-b border-slate-800/80 shadow-[0_35px_70px_-40px_rgba(56,189,248,0.38)] backdrop-blur-xl">
    <div class="flex items-center gap-3">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-500/15 text-sky-300 shadow-[0_0_20px_rgba(56,189,248,0.18)]">
            <i class="fa-solid fa-gauge-high"></i>
        </span>
        <div>
            <p class="text-sm uppercase tracking-[0.26em] text-slate-400">Inventory</p>
            <h1 class="text-base font-semibold text-slate-100">Dashboard</h1>
        </div>
    </div>
    <div class="flex items-center gap-4 text-sm text-slate-300">
        <span class="hidden md:inline">Hi, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/authentication/logout.php" class="inline-flex items-center gap-2 rounded-full border border-sky-500/20 bg-slate-950/60 px-4 py-2 text-sky-300 transition hover:bg-slate-900/80 hover:text-white">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>
</nav>