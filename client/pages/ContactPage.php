<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50">

    <?php
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../includes/Navbar.php';
    ?>

    <!-- Hero -->
    <section class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">

        <div class="max-w-7xl mx-auto px-6 py-20 text-center">

            <h1 class="text-5xl font-bold">
                Contact Us
            </h1>

            <p class="mt-5 text-lg text-blue-100">
                We'd love to hear from you. Send us your questions or feedback.
            </p>

        </div>

    </section>

    <!-- Contact -->
    <section class="py-20">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-12">

                <!-- Contact Info -->

                <div>

                    <h2 class="text-3xl font-bold">
                        Get in Touch
                    </h2>

                    <p class="mt-4 text-gray-600">
                        Need help with the Inventory Management System?
                        Feel free to contact us.
                    </p>

                    <div class="mt-10 space-y-6">

                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-semibold text-lg">📧 Email</h3>
                            <p class="text-gray-600 mt-2">mengsiek8@gmail.com</p>
                        </div>

                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-semibold text-lg">📱 Phone</h3>
                            <p class="text-gray-600 mt-2">+855 963063226</p>
                        </div>

                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-semibold text-lg">📍 Address</h3>
                            <p class="text-gray-600 mt-2">
                                Phnom Penh, Cambodia
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Contact Form -->

                <div class="bg-white rounded-2xl shadow-xl p-8">

                    <h2 class="text-3xl font-bold mb-8">

                        Send Message

                    </h2>

                    <form>

                        <div class="mb-5">

                            <label class="block mb-2 font-medium">
                                Full Name
                            </label>

                            <input type="text"
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        </div>

                        <div class="mb-5">

                            <label class="block mb-2 font-medium">
                                Email
                            </label>

                            <input type="email"
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        </div>

                        <div class="mb-5">

                            <label class="block mb-2 font-medium">
                                Subject
                            </label>

                            <input type="text"
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        </div>

                        <div class="mb-6">

                            <label class="block mb-2 font-medium">
                                Message
                            </label>

                            <textarea rows="5"
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

                        </div>

                        <button href="https://t.me/May_The_Force_be_wit_you"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">

                            Send Message

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </section>

    <?php
require_once __DIR__ . '/../includes/Footer.php';
?>

</body>

</html>