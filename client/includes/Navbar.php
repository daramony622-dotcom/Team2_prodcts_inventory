<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
$current = basename($_SERVER['PHP_SELF']);
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

                <a href="<?= BASE_URL ?>/client/pages/index.php" class="text-gray-600 hover:text-blue-600 transition">
                    Home
                </a>

                <a href="<?= BASE_URL ?>/client/pages/AboutPage.php"
                    class="text-gray-600 hover:text-blue-600 transition">
                    About
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ServicePage.php"
                    class="text-gray-600 hover:text-blue-600 transition">
                    Services
                </a>

                <a href="<?= BASE_URL ?>/client/pages/ContactPage.php"
                    class="text-gray-600 hover:text-blue-600 transition">
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
                    class=" bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition">
                    Logout
                </a>

                <?php else: ?>

                <a href="<?= BASE_URL ?>/authentication/login.php"
                    class="border border-blue-600 text-blue-600 px-5 py-2 rounded-lg hover:bg-blue-50">
                    Login
                </a>

                <a href="<?= BASE_URL ?>/authentication/register.php"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Register
                </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>