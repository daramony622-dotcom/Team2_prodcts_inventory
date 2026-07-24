<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../includes/Navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-50">

    <main>

        <!-- ================= HERO ================= -->

        <section class="bg-gradient-to-r from-blue-500 to-indigo-300 text-white">

            <div class="max-w-7xl mx-auto px-6 py-24">

                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    <div>

                        <?php if (isset($_SESSION['username'])): ?>

                        <h1 class="text-5xl font-bold leading-tight">
                            Welcome back,
                            <br>
                            <?= htmlspecialchars($_SESSION['username']) ?>!
                        </h1>

                        <p class="mt-6 text-lg text-blue-100">
                            Jump back into your dashboard and pick up where you left off.
                        </p>

                        <div class="mt-8 flex gap-4">

                            <a href="<?= BASE_URL ?>/inventory/dashboard/index.php"
                                class="bg-white text-blue-500 px-6 py-3 rounded-lg font-semibold">
                                Go to Dashboard
                            </a>

                            <a href="#features"
                                class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-700 transition">
                                Learn More
                            </a>

                        </div>

                        <?php else: ?>

                        <h1 class="text-5xl font-bold leading-tight">
                            Smart Inventory
                            <br>
                            Management System
                        </h1>

                        <p class="mt-6 text-lg text-blue-100">
                            Manage products, suppliers, categories,
                            stock movements, and reports in one
                            modern dashboard.
                        </p>

                        <div class="mt-8 flex gap-4">

                            <a href="<?= BASE_URL ?>/authentication/login.php"
                                class="bg-white text-blue-500 px-6 py-3 rounded-lg font-semibold">
                                Get Started
                            </a>

                            <a href="#features"
                                class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-600 transition">
                                Learn More
                            </a>

                        </div>

                        <?php endif; ?>

                    </div>

                    <div>
                        <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?w=800"
                            class="rounded-2xl shadow-2xl" alt="Inventory">
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= FEATURES ================= -->

        <section id="features" class="py-20">

            <div class="max-w-7xl mx-auto px-6">

                <h2 class="text-4xl font-bold text-center">
                    Features
                </h2>

                <p class="text-gray-500 text-center mt-3">
                    Everything you need to manage your inventory.
                </p>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-14">

                    <div class="bg-white p-8 rounded-2xl shadow">
                        <h3 class="font-bold text-xl">📦 Products</h3>
                        <p class="mt-4 text-gray-600">Manage all products with categories and stock.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow">
                        <h3 class="font-bold text-xl">📊 Reports</h3>
                        <p class="mt-4 text-gray-600">Generate inventory reports instantly.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow">
                        <h3 class="font-bold text-xl">👥 Users</h3>
                        <p class="mt-4 text-gray-600">Role-based authentication and permissions.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow">
                        <h3 class="font-bold text-xl">🚚 Suppliers</h3>
                        <p class="mt-4 text-gray-600">Manage suppliers efficiently.</p>
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= STATS ================= -->

        <section class="bg-blue-600 text-white py-16">

            <div class="max-w-6xl mx-auto">

                <div class="grid md:grid-cols-4 text-center">

                    <div>
                        <h2 class="text-4xl font-bold">1000+</h2>
                        <p>Products</p>
                    </div>

                    <div>
                        <h2 class="text-4xl font-bold">500+</h2>
                        <p>Orders</p>
                    </div>

                    <div>
                        <h2 class="text-4xl font-bold">100+</h2>
                        <p>Suppliers</p>
                    </div>

                    <div>
                        <h2 class="text-4xl font-bold">24/7</h2>
                        <p>Support</p>
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= CTA ================= -->

        <section class="py-20">

            <div class="max-w-5xl mx-auto text-center">

                <?php if (isset($_SESSION['username'])): ?>

                <h2 class="text-4xl font-bold">
                    Ready to get back to work, <?= htmlspecialchars($_SESSION['username']) ?>?
                </h2>

                <p class="mt-5 text-gray-600">
                    Your dashboard is waiting — manage your inventory in just a click.
                </p>

                <a href="../../dashboard/index.php"
                    class="inline-block mt-8 bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700">
                    Go to Dashboard
                </a>

                <?php else: ?>

                <h2 class="text-4xl font-bold">
                    Ready to manage your inventory?
                </h2>

                <p class="mt-5 text-gray-600">
                    Create an account and start managing your business today.
                </p>

                <a href="../../authentication/register.php"
                    class="inline-block mt-8 bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700">
                    Create Account
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