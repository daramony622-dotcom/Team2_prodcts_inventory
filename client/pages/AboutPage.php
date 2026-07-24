<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-50">
    <?php
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../includes/Navbar.php';
    ?>

    <main>
        <!-- Hero -->
        <section class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <div class="max-w-7xl mx-auto px-6 py-20 text-center">

                <h1 class="text-5xl font-bold">
                    About Our Inventory Management System
                </h1>

                <p class="mt-6 text-lg text-blue-100 max-w-3xl mx-auto">
                    A modern web application designed to help businesses manage
                    products, inventory, suppliers, users, and reports efficiently.
                </p>

            </div>
        </section>

        <!-- About -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-6">

                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    <div>
                        <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?w=900"
                            class="rounded-2xl shadow-xl" alt="Inventory">
                    </div>

                    <div>

                        <h2 class="text-4xl font-bold text-gray-800">
                            Who We Are
                        </h2>

                        <p class="mt-6 text-gray-600 leading-8">
                            Our Inventory Management System is built to simplify
                            inventory operations for businesses of all sizes.
                            It provides an intuitive dashboard, real-time stock
                            management, supplier tracking, reporting, and user
                            authentication in one platform.
                        </p>

                        <div class="grid grid-cols-2 gap-6 mt-8">

                            <div class="bg-white shadow rounded-xl p-6">
                                <h3 class="text-3xl font-bold text-blue-600">
                                    1000+
                                </h3>
                                <p class="text-gray-500 mt-2">
                                    Products Managed
                                </p>
                            </div>

                            <div class="bg-white shadow rounded-xl p-6">
                                <h3 class="text-3xl font-bold text-blue-600">
                                    500+
                                </h3>
                                <p class="text-gray-500 mt-2">
                                    Daily Transactions
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>

        <!-- Features -->
        <section class="bg-white py-20">

            <div class="max-w-7xl mx-auto px-6">

                <h2 class="text-4xl font-bold text-center">
                    Key Features
                </h2>

                <p class="text-center text-gray-500 mt-3">
                    Everything you need to manage your inventory efficiently.
                </p>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-14">

                    <div class="bg-gray-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                        <div class="text-5xl">📦</div>
                        <h3 class="font-semibold text-xl mt-4">
                            Product Management
                        </h3>
                        <p class="text-gray-600 mt-3">
                            Add, edit, delete, and organize your products.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                        <div class="text-5xl">📊</div>
                        <h3 class="font-semibold text-xl mt-4">
                            Reports
                        </h3>
                        <p class="text-gray-600 mt-3">
                            Generate detailed inventory reports instantly.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                        <div class="text-5xl">👥</div>
                        <h3 class="font-semibold text-xl mt-4">
                            User Management
                        </h3>
                        <p class="text-gray-600 mt-3">
                            Secure role-based authentication for users.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                        <div class="text-5xl">🚚</div>
                        <h3 class="font-semibold text-xl mt-4">
                            Suppliers
                        </h3>
                        <p class="text-gray-600 mt-3">
                            Track supplier information and inventory sources.
                        </p>
                    </div>

                </div>

            </div>

        </section>

        <!-- Technology -->
        <section class="py-20">

            <div class="max-w-5xl mx-auto px-6 text-center">

                <h2 class="text-4xl font-bold">
                    Technology Stack
                </h2>

                <div class="flex flex-wrap justify-center gap-4 mt-10">

                    <span class="bg-blue-100 text-blue-700 px-5 py-2 rounded-full">
                        PHP
                    </span>

                    <span class="bg-indigo-100 text-indigo-700 px-5 py-2 rounded-full">
                        MySQL
                    </span>

                    <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full">
                        Tailwind CSS
                    </span>

                    <span class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full">
                        JavaScript
                    </span>

                    <span class="bg-purple-100 text-purple-700 px-5 py-2 rounded-full">
                        HTML5
                    </span>

                </div>

            </div>

        </section>

        <!-- Call To Action -->
        <section class="bg-blue-600 text-white">

            <div class="max-w-5xl mx-auto px-6 py-20 text-center">

                <h2 class="text-4xl font-bold">
                    Ready to Get Started?
                </h2>

                <p class="mt-5 text-blue-100">
                    Join our platform and simplify your inventory management today.
                </p>

                <a href="../../authentication/register.php"
                    class="inline-block mt-8 bg-white text-blue-600 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100">

                    Create Account

                </a>

            </div>

        </section>
    </main>
    <?php
require_once __DIR__ . '/../includes/Footer.php';
?>

</body>

</html>