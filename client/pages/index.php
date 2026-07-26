<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../includes/Navbar.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory | Home</title>

    <!-- CRITICAL: Early script to set dark mode class instantly and prevent flashing -->
    <script>
    if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && window.matchMedia(
            "(prefers-color-scheme: dark)").matches)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @custom-variant dark (&:where(.dark, .dark *));
</style>
</head>

<body class="bg-gray-50 dark:bg-slate-950 text-gray-800 dark:text-gray-100 transition-colors duration-200">
    <!-- Rest of your page layout -->
    <main>

        <!-- ================= HERO SECTION ================= -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-800 to-blue-600 dark:from-slate-900 dark:via-slate-900 dark:to-blue-950 text-white py-24 lg:py-32 transition-colors duration-200">
            <!-- Decorative background blur -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px]">
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    <div class="space-y-6">
                        <?php if (isset($_SESSION['username'])): ?>
                        <span
                            class="inline-block bg-blue-500/30 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            Welcome Back
                        </span>
                        <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                            Hello, <span
                                class="text-blue-300 dark:text-cyan-400"><?= htmlspecialchars($_SESSION['username']) ?></span>
                        </h1>
                        <p class="text-lg text-blue-100 dark:text-slate-300 max-w-xl">
                            Jump back into your dashboard, monitor real-time stock levels, and pick up right where you
                            left off.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="<?= BASE_URL ?>/inventory/dashboard/index.php"
                                class="bg-white text-blue-700 hover:bg-blue-50 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 px-7 py-3.5 rounded-xl font-semibold shadow-lg shadow-black/10 transition-all duration-200 flex items-center gap-2">
                                Go to Dashboard &rarr;
                            </a>
                            <a href="#features"
                                class="border border-white/30 bg-white/10 hover:bg-white/20 dark:border-slate-700 dark:bg-slate-800/50 dark:hover:bg-slate-800 px-7 py-3.5 rounded-xl font-medium transition-all duration-200 backdrop-blur-sm">
                                Explore Features
                            </a>
                        </div>
                        <?php else: ?>
                        <span
                            class="inline-block bg-blue-500/30 text-blue-200 dark:text-cyan-300 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            Next-Gen Stock Control
                        </span>
                        <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                            Smart Inventory <br>
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-300 dark:from-cyan-400 dark:to-blue-500">Management
                                System</span>
                        </h1>
                        <p class="text-lg text-blue-100 dark:text-slate-300 max-w-xl">
                            Streamline your products, track stock movements, manage suppliers, and generate insights—all
                            from a single modern control center.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="<?= BASE_URL ?>/authentication/login.php"
                                class="bg-white text-blue-700 hover:bg-blue-50 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 px-7 py-3.5 rounded-xl font-semibold shadow-lg shadow-black/10 transition-all duration-200">
                                Get Started Free
                            </a>
                            <a href="#features"
                                class="border border-white/30 bg-white/10 hover:bg-white/20 dark:border-slate-700 dark:bg-slate-800/50 dark:hover:bg-slate-800 px-7 py-3.5 rounded-xl font-medium transition-all duration-200 backdrop-blur-sm">
                                Learn More
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Modern Dashboard Mockup Graphic Preview -->
                    <div class="relative">
                        <div
                            class="absolute -inset-1.5 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-3xl blur-xl opacity-30">
                        </div>
                        <div
                            class="relative bg-slate-900 border border-slate-700/50 rounded-2xl shadow-2xl overflow-hidden p-2">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1000"
                                class="rounded-xl w-full object-cover shadow-inner opacity-90 hover:opacity-100 transition duration-300"
                                alt="Analytics and Inventory UI Dashboard">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= FEATURES SECTION ================= -->
        <section id="features" class="py-24 bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Built for Efficiency
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-3 text-lg">
                        Everything you need to scale and manage your business stock accurately.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

                    <div
                        class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-blue-50 dark:bg-cyan-950/60 text-blue-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-950 transition duration-300">
                            📦
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Products</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Organize items
                            seamlessly with custom
                            categories, variants, and automated stock thresholds.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-indigo-600 group-hover:text-white dark:group-hover:bg-indigo-500 dark:group-hover:text-slate-950 transition duration-300">
                            📊
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Reports</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Generate analytical
                            inventory movement
                            reports instantly to make data-driven choices.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-sky-600 group-hover:text-white dark:group-hover:bg-sky-500 dark:group-hover:text-slate-950 transition duration-300">
                            👥
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Users & Roles</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Secure role-based
                            authentication and
                            granular permission controls for your staff.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-emerald-600 group-hover:text-white dark:group-hover:bg-emerald-500 dark:group-hover:text-slate-950 transition duration-300">
                            🚚
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Suppliers</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Track vendor details,
                            supply chains, and
                            procurement history efficiently.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= STATS SECTION ================= -->
        <section
            class="bg-blue-700 dark:bg-slate-900 border-y border-slate-800 text-white py-16 relative overflow-hidden transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="p-4">
                        <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-white dark:text-cyan-400">
                            1,000+</h2>
                        <p class="text-blue-200 dark:text-slate-400 mt-1 font-medium">Products Tracked</p>
                    </div>
                    <div class="p-4">
                        <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-white dark:text-cyan-400">
                            500+</h2>
                        <p class="text-blue-200 dark:text-slate-400 mt-1 font-medium">Daily Orders</p>
                    </div>
                    <div class="p-4">
                        <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-white dark:text-cyan-400">
                            100+</h2>
                        <p class="text-blue-200 dark:text-slate-400 mt-1 font-medium">Active Suppliers</p>
                    </div>
                    <div class="p-4">
                        <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-white dark:text-cyan-400">
                            24/7</h2>
                        <p class="text-blue-200 dark:text-slate-400 mt-1 font-medium">System Uptime</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= CTA SECTION ================= -->
        <section class="py-24 bg-white dark:bg-slate-950 transition-colors duration-200">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <?php if (isset($_SESSION['username'])): ?>
                <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Ready to get back to work, <?= htmlspecialchars($_SESSION['username']) ?>?
                </h2>
                <p class="mt-4 text-slate-600 dark:text-slate-400 text-lg">
                    Your dashboard is waiting. Manage your inventory items and reports with a single click.
                </p>
                <a href="<?= BASE_URL ?>/inventory/dashboard/index.php"
                    class="inline-flex items-center justify-center mt-8 bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-white font-semibold px-8 py-4 rounded-xl shadow-lg shadow-blue-600/25 transition duration-200">
                    Go to Dashboard
                </a>
                <?php else: ?>
                <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Ready to optimize your inventory flow?
                </h2>
                <p class="mt-4 text-slate-600 dark:text-slate-400 text-lg">
                    Create an account today and take full control of your supply chain and business operations.
                </p>
                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="inline-flex items-center justify-center mt-8 bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-white font-semibold px-8 py-4 rounded-xl shadow-lg shadow-blue-600/25 transition duration-200">
                    Create Free Account
                </a>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <?php
    require_once __DIR__ . '/../includes/Footer.php';
    ?>

</body>

</html>