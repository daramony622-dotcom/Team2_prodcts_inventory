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
    <title>Smart Inventory | About Us</title>

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

    <main>
        <!-- ================= HERO SECTION ================= -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-800 to-blue-600 dark:from-slate-900 dark:via-slate-900 dark:to-blue-950 text-white py-24 lg:py-32 transition-colors duration-200">
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px]">
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span
                    class="inline-block bg-blue-500/30 text-blue-200 dark:text-cyan-300 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                    About Our Platform
                </span>
                <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Smart Inventory <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-300 dark:from-cyan-400 dark:to-blue-500">Management
                        System</span>
                </h1>
                <p class="mt-6 text-lg lg:text-xl text-blue-100 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                    A robust, modern web application engineered to help modern businesses track products, streamline
                    stock levels, monitor supply chains, and generate actionable insights in one unified dashboard.
                </p>
            </div>
        </section>

        <!-- ================= WHO WE ARE ================= -->
        <section class="py-24 bg-white dark:bg-slate-900 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <!-- Graphic/Image Preview -->
                    <div class="relative">
                        <div
                            class="absolute -inset-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur-xl opacity-20">
                        </div>
                        <div
                            class="relative bg-slate-900 border border-slate-700/50 rounded-2xl shadow-2xl overflow-hidden p-2">
                            <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&q=80&w=1000"
                                class="rounded-xl w-full object-cover shadow-inner opacity-90 hover:opacity-100 transition duration-300"
                                alt="Inventory Operations Team">
                        </div>
                    </div>

                    <!-- Text Details -->
                    <div class="space-y-6">
                        <span class="text-blue-600 dark:text-cyan-400 font-semibold tracking-wide text-sm uppercase">Our
                            Mission</span>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                            Simplifying Business Operations Worldwide
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                            Our platform is built to eliminate the chaos of manual record-keeping. We provide
                            organizations of all scales with automated workflows, real-time tracking, granular user
                            permission controls, and lightning-fast metrics reporting.
                        </p>

                        <!-- Stat Grid Cards -->
                        <div class="grid grid-cols-2 gap-6 pt-4">
                            <div
                                class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm rounded-2xl p-6 hover:shadow-md transition">
                                <h3 class="text-3xl lg:text-4xl font-extrabold text-blue-600 dark:text-cyan-400">
                                    1,000+
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400 font-medium mt-1 text-sm">
                                    Products Managed
                                </p>
                            </div>

                            <div
                                class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm rounded-2xl p-6 hover:shadow-md transition">
                                <h3 class="text-3xl lg:text-4xl font-extrabold text-blue-600 dark:text-cyan-400">
                                    500+
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400 font-medium mt-1 text-sm">
                                    Daily Transactions
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- ================= KEY FEATURES ================= -->
        <section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Key System Features
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-3 text-lg">
                        Designed from the ground up with productivity and reliability in mind.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

                    <div
                        class="bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-blue-50 dark:bg-cyan-950/60 text-blue-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-950 transition duration-300">
                            📦
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Product Management</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Add, edit, organize
                            categories, and
                            configure dynamic item lists seamlessly.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:bg-indigo-600 group-hover:text-white dark:group-hover:bg-indigo-500 dark:group-hover:text-slate-950 transition duration-300">
                            📊
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Advanced Reports</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Generate instant
                            stock performance
                            insights and analytics data streams.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:bg-sky-600 group-hover:text-white dark:group-hover:bg-sky-500 dark:group-hover:text-slate-950 transition duration-300">
                            👥
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">User Access Control</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Secure role-based
                            authentication
                            safeguarding administrative capabilities.</p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition duration-300 group">
                        <div
                            class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-600 group-hover:text-white dark:group-hover:bg-emerald-500 dark:group-hover:text-slate-950 transition duration-300">
                            🚚
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white">Supplier Tracking</h3>
                        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Monitor inventory
                            origins, supplier
                            contact networks, and order workflows.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= TECHNOLOGY STACK ================= -->
        <section class="py-24 bg-white dark:bg-slate-900 transition-colors duration-200">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <span class="text-blue-600 dark:text-cyan-400 font-semibold tracking-wide text-sm uppercase">Built With
                    Modern Tools</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mt-2">
                    Our Technology Stack
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-2">Reliable, scalable, and high-performance technologies
                    power our
                    ecosystem.</p>

                <div class="flex flex-wrap justify-center gap-3 mt-10">
                    <span
                        class="bg-blue-50 border border-blue-100 text-blue-700 dark:bg-slate-800 dark:border-slate-700 dark:text-cyan-300 font-medium px-6 py-2.5 rounded-xl shadow-xs">
                        PHP (Backend Engine)
                    </span>
                    <span
                        class="bg-indigo-50 border border-indigo-100 text-indigo-700 dark:bg-slate-800 dark:border-slate-700 dark:text-indigo-300 font-medium px-6 py-2.5 rounded-xl shadow-xs">
                        MySQL (Database)
                    </span>
                    <span
                        class="bg-cyan-50 border border-cyan-100 text-cyan-700 dark:bg-slate-800 dark:border-slate-700 dark:text-teal-300 font-medium px-6 py-2.5 rounded-xl shadow-xs">
                        Tailwind CSS v4
                    </span>
                    <span
                        class="bg-amber-50 border border-amber-100 text-amber-700 dark:bg-slate-800 dark:border-slate-700 dark:text-amber-300 font-medium px-6 py-2.5 rounded-xl shadow-xs">
                        JavaScript (ES6+)
                    </span>
                    <span
                        class="bg-purple-50 border border-purple-100 text-purple-700 dark:bg-slate-800 dark:border-slate-700 dark:text-purple-300 font-medium px-6 py-2.5 rounded-xl shadow-xs">
                        HTML5 & Semantic UI
                    </span>
                </div>
            </div>
        </section>

        <!-- ================= CALL TO ACTION ================= -->
        <section
            class="bg-blue-700 dark:bg-slate-900 border-t border-slate-800 text-white py-20 relative overflow-hidden transition-colors duration-200">
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight">
                    Ready to streamline your business inventory?
                </h2>
                <p class="mt-4 text-blue-100 dark:text-slate-300 text-lg">
                    Join our platform today and scale your supply chain controls effortlessly.
                </p>
                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="inline-flex items-center justify-center mt-8 bg-white hover:bg-blue-50 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-blue-700 font-semibold px-8 py-4 rounded-xl shadow-lg transition duration-200">
                    Create Free Account &rarr;
                </a>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/../includes/Footer.php';
    ?>

</body>

</html>