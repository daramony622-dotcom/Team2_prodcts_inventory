<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../inventory/categories/getCategories.php';
}
$db_path = __DIR__ . '/../../config/database.php';
if (file_exists($db_path)) {
    require_once $db_path;
}

$navCategories = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT id, category_name FROM categories ORDER BY category_name ASC");
        $navCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $navCategories = [];
    }
}
?>

<!-- Early Script to prevent FOUC (Flash of Unstyled Content) across all pages -->
<script>
if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && window.matchMedia(
        "(prefers-color-scheme: dark)").matches)) {
    document.documentElement.classList.add("dark");
} else {
    document.documentElement.classList.remove("dark");
}
</script>

<nav
    class="bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 shadow-md sticky top-0 z-50 transition-colors duration-200">

    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center h-16 px-6">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/client/pages/index.php" class="text-2xl font-bold flex items-center gap-1">
                <span class="text-blue-600 dark:text-cyan-400">Product</span>
                <span class="text-gray-700 dark:text-gray-200">Inventory</span>
            </a>

            <!-- Menu -->
            <div class="hidden md:flex items-center gap-8">

                <a href="<?= BASE_URL ?>/client/pages/index.php"
                    class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400 transition font-medium">
                    Home
                </a>

                <!-- Dynamic Server Categories Dropdown -->
                <div class="relative group">
                    <button
                        class="flex items-center gap-1.5 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400 transition font-medium py-2 focus:outline-none">
                        <span>Categories</span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Content Box -->
                    <div
                        class="absolute left-0 top-full hidden group-hover:block w-52 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-lg py-2 transition-all duration-200 z-50">

                        <?php if (!empty($navCategories)): ?>
                        <?php foreach ($navCategories as $cat): ?>
                        <a href="<?= BASE_URL ?>/client/categories/products.php?category_id=<?= $cat['id'] ?>"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-cyan-400 transition">
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </a>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <span class="block px-4 py-2 text-xs text-gray-400 dark:text-gray-500">No categories added
                            yet</span>
                        <?php endif; ?>

                        <div class="border-t border-gray-100 dark:border-slate-700 my-1"></div>
                        <a href="<?= BASE_URL ?>/client/categories/products.php"
                            class="block px-4 py-2 text-xs font-semibold text-blue-600 dark:text-cyan-400 hover:bg-blue-50 dark:hover:bg-slate-700 transition">
                            View All Products →
                        </a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/client/pages/AboutPage.php"
                    class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400 transition font-medium">
                    About
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ServicePage.php"
                    class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400 transition font-medium">
                    Services
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ContactPage.php"
                    class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400 transition font-medium">
                    Contact
                </a>

            </div>

            <!-- Right Controls (Theme Switcher + Auth Buttons) -->
            <div class="flex items-center gap-4">

                <!-- Theme Toggle Button -->
                <button id="themeToggle"
                    class="p-2.5 rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-cyan-400 hover:bg-gray-200 dark:hover:bg-slate-700 transition focus:outline-none"
                    aria-label="Toggle Dark Mode">
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg id="themeSunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg id="themeMoonIcon" class="w-5 h-5 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>

                <?php if (isset($_SESSION['username'])): ?>

                <span class="text-gray-700 dark:text-gray-300 font-medium hidden sm:inline">
                    Hi, <?= htmlspecialchars($_SESSION['username']) ?>
                </span>

                <a href="<?= BASE_URL ?>/authentication/logout.php"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Logout
                </a>

                <?php else: ?>

                <a href="<?= BASE_URL ?>/authentication/login.php"
                    class="border border-blue-600 dark:border-cyan-500 text-blue-600 dark:text-cyan-400 px-4 py-2 rounded-lg hover:bg-blue-50 dark:hover:bg-slate-800 transition text-sm font-medium">
                    Login
                </a>

                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    Register
                </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>

<!-- Inline Script to Handle Light/Dark Theme Switching & Persistence -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("themeToggle");
    const sunIcon = document.getElementById("themeSunIcon");
    const moonIcon = document.getElementById("themeMoonIcon");

    function updateIcons(isDark) {
        if (isDark) {
            sunIcon.classList.remove("hidden");
            sunIcon.classList.add("block");
            moonIcon.classList.remove("block");
            moonIcon.classList.add("hidden");
        } else {
            sunIcon.classList.remove("block");
            sunIcon.classList.add("hidden");
            moonIcon.classList.remove("hidden");
            moonIcon.classList.add("block");
        }
    }

    // Initialize correct icon state on page load based on current DOM class
    updateIcons(document.documentElement.classList.contains("dark"));

    themeToggleBtn.addEventListener("click", () => {
        if (document.documentElement.classList.contains("dark")) {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            updateIcons(false);
        } else {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
            updateIcons(true);
        }
    });
});
</script>