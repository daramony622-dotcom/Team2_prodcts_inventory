<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50">

    <?php
require_once __DIR__ . '/../includes/Navbar.php';
?>

    <!-- Hero -->
    <section class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-6 py-24 text-center">

            <h1 class="text-5xl font-bold">
                Our Services
            </h1>

            <p class="mt-6 text-lg text-blue-100 max-w-3xl mx-auto">
                Powerful tools designed to simplify inventory management,
                improve productivity, and support business growth.
            </p>

        </div>
    </section>

    <!-- Services -->
    <section class="py-20">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📦</div>
                    <h2 class="text-2xl font-bold mt-6">Product Management</h2>
                    <p class="mt-4 text-gray-600">
                        Add, edit, organize, and monitor all your products from one dashboard.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">🏷️</div>
                    <h2 class="text-2xl font-bold mt-6">Category Management</h2>
                    <p class="mt-4 text-gray-600">
                        Organize products into categories for faster searching and reporting.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">🚚</div>
                    <h2 class="text-2xl font-bold mt-6">Supplier Management</h2>
                    <p class="mt-4 text-gray-600">
                        Store supplier information and manage purchasing efficiently.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📥</div>
                    <h2 class="text-2xl font-bold mt-6">Stock In</h2>
                    <p class="mt-4 text-gray-600">
                        Record incoming inventory and automatically update stock levels.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📤</div>
                    <h2 class="text-2xl font-bold mt-6">Stock Out</h2>
                    <p class="mt-4 text-gray-600">
                        Track outgoing products and maintain accurate inventory records.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📊</div>
                    <h2 class="text-2xl font-bold mt-6">Reports & Analytics</h2>
                    <p class="mt-4 text-gray-600">
                        Generate inventory reports with useful statistics for better decisions.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section class="bg-blue-600 text-white">

        <div class="max-w-5xl mx-auto py-16 px-6 text-center">

            <h2 class="text-4xl font-bold">
                Ready to Manage Your Inventory?
            </h2>

            <p class="mt-5 text-blue-100">
                Create an account today and start organizing your products efficiently.
            </p>

            <a href="../authentication/register.php"
                class="inline-block mt-8 bg-white text-blue-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100">

                Get Started

            </a>

        </div>

    </section>

    <?php
require_once __DIR__ . '/../includes/Footer.php';
?>

</body>

</html>