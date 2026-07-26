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
    <title>Smart Inventory | Our Services</title>

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
                    What We Offer
                </span>
                <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Comprehensive <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-300 dark:from-cyan-400 dark:to-blue-500">Inventory
                        Services</span>
                </h1>
                <p class="mt-6 text-lg lg:text-xl text-blue-100 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                    Powerful, intuitive tools designed to simplify inventory management, maximize workflow productivity,
                    and support seamless business growth.
                </p>
            </div>
        </section>

        <!-- ================= SERVICES GRID (Modern Glassmorphism Design) ================= -->
        <section class="py-24 relative overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
            <!-- Decorative gradient blobs behind cards -->
            <div
                class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-200/40 dark:bg-cyan-950/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-200/40 dark:bg-indigo-950/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Service Card 1 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-blue-50 dark:bg-cyan-950/60 border border-blue-100 dark:border-cyan-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-950 transition duration-300">
                            📦
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Product Management</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            បន្ថែម កែសម្រួល រៀបចំ និងតាមដានផលិតផលទាំងអស់របស់អ្នកពីផ្ទាំងគ្រប់គ្រងតែមួយ។ Manage item
                            details seamlessly in real time.
                        </p>
                    </div>

                    <!-- Service Card 2 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white dark:group-hover:bg-indigo-500 dark:group-hover:text-slate-950 transition duration-300">
                            🏷️
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Category Management</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            រៀបចំផលិតផលជាប្រភេទសម្រាប់ស្វែងរក និងរាយការណ៍កាន់តែលឿន។ Group items logically to accelerate
                            searches and analytics.
                        </p>
                    </div>

                    <!-- Service Card 3 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-100 dark:border-emerald-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-emerald-600 group-hover:text-white dark:group-hover:bg-emerald-500 dark:group-hover:text-slate-950 transition duration-300">
                            🚚
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Supplier Management</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            រក្សាទុកព័ត៌មានអ្នកផ្គត់ផ្គង់ និងគ្រប់គ្រងការទិញបានយ៉ាងមានប្រសិទ្ធភាព។ Keep track of vendor
                            networks and procurement cycles.
                        </p>
                    </div>

                    <!-- Service Card 4 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-sky-50 dark:bg-sky-950/60 border border-sky-100 dark:border-sky-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-sky-600 group-hover:text-white dark:group-hover:bg-sky-500 dark:group-hover:text-slate-950 transition duration-300">
                            📥
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Stock In</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            កត់ត្រាទំនិញចូល និងធ្វើបច្ចុប្បន្នភាពកម្រិតស្តុកដោយស្វ័យប្រវត្តិ។ Log incoming shipments
                            with automatic stock adjustments.
                        </p>
                    </div>

                    <!-- Service Card 5 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-amber-50 dark:bg-amber-950/60 border border-amber-100 dark:border-amber-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-amber-600 group-hover:text-white dark:group-hover:bg-amber-500 dark:group-hover:text-slate-950 transition duration-300">
                            📤
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Stock Out</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            តាមដានផលិតផលចេញ និងរក្សាទុកកំណត់ត្រាស្តុកឱ្យបានត្រឹមត្រូវ។ Monitor outgoing dispatch flows
                            to maintain balance accuracy.
                        </p>
                    </div>

                    <!-- Service Card 6 -->
                    <div
                        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/60 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300 group">
                        <div
                            class="w-14 h-14 bg-purple-50 dark:bg-purple-950/60 border border-purple-100 dark:border-purple-800/50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-purple-600 group-hover:text-white dark:group-hover:bg-purple-500 dark:group-hover:text-slate-950 transition duration-300">
                            📊
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Reports & Analytics</h2>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
                            បង្កើតរបាយការណ៍ស្តុកជាមួយនឹងស្ថិតិដែលមានប្រយោជន៍សម្រាប់ការសម្រេចចិត្តកាន់តែប្រសើរ។ Deep data
                            insights for informed business choices.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= CALL TO ACTION ================= -->
        <section
            class="bg-blue-700 dark:bg-slate-900 border-t border-slate-800 text-white py-20 relative overflow-hidden transition-colors duration-200">
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight">
                    Ready to Manage Your Inventory?
                </h2>
                <p class="mt-4 text-blue-100 dark:text-slate-300 text-lg">
                    Create an account today and start organizing your products efficiently.
                </p>
                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="inline-flex items-center justify-center mt-8 bg-white hover:bg-blue-50 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-blue-700 font-semibold px-8 py-4 rounded-xl shadow-lg transition duration-200">
                    Get Started Free &rarr;
                </a>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/../includes/Footer.php';
    ?>

</body>

</html>