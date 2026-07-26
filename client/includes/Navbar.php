<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}

// Ensure correct database connection file path
$db_path = __DIR__ . '/../../config/database.php';
if (file_exists($db_path)) {
    require_once $db_path;
}

// Fetch active categories directly from database
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

<nav class="bg-white shadow-md sticky top-0 z-50">

    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center h-16 px-6">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/client/pages/index.php" class="text-2xl font-bold">
                <span class="text-blue-600">Product</span>
                <span class="text-gray-700">Inventory</span>
            </a>

            <!-- Menu -->
            <div class="hidden md:flex items-center gap-8">

                <a href="<?= BASE_URL ?>/client/pages/index.php"
                    class="text-gray-600 hover:text-blue-600 transition font-medium">
                    Home
                </a>

                <!-- Dynamic Server Categories Dropdown -->
                <div class="relative group">
                    <button
                        class="flex items-center gap-1.5 text-gray-600 hover:text-blue-600 transition font-medium py-2 focus:outline-none">
                        <span>Categories</span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Content Box -->
                    <div
                        class="absolute left-0 top-full hidden group-hover:block w-52 bg-white border border-gray-100 rounded-xl shadow-lg py-2 transition-all duration-200 z-50">

                        <?php if (!empty($navCategories)): ?>
                        <?php foreach ($navCategories as $cat): ?>
                        <a href="<?= BASE_URL ?>/client/categories/products.php?category_id=<?= $cat['id'] ?>"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </a>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <span class="block px-4 py-2 text-xs text-gray-400">No categories added yet</span>
                        <?php endif; ?>

                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="<?= BASE_URL ?>/client/categories/products.php"
                            class="block px-4 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50 transition">
                            View All Products →
                        </a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/client/pages/AboutPage.php"
                    class="text-gray-600 hover:text-blue-600 transition font-medium">
                    About
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ServicePage.php"
                    class="text-gray-600 hover:text-blue-600 transition font-medium">
                    Services
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ContactPage.php"
                    class="text-gray-600 hover:text-blue-600 transition font-medium">
                    Contact
                </a>

            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3">

                <?php if (isset($_SESSION['username'])): ?>

                <span class="text-gray-700 font-medium">
                    Hi, <?= htmlspecialchars($_SESSION['username']) ?>
                </span>

                <a href="<?= BASE_URL ?>/authentication/logout.php"
                    class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition">
                    Logout
                </a>

                <?php else: ?>

                <a href="<?= BASE_URL ?>/authentication/login.php"
                    class="border border-blue-600 text-blue-600 px-5 py-2 rounded-lg hover:bg-blue-50 transition">
                    Login
                </a>

                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Register
                </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>