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
                        បន្ថែម កែសម្រួល រៀបចំ និងតាមដានផលិតផលទាំងអស់របស់អ្នកពីផ្ទាំងគ្រប់គ្រងតែមួយ។
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">🏷️</div>
                    <h2 class="text-2xl font-bold mt-6">Category Management</h2>
                    <p class="mt-4 text-gray-600">
                        រៀបចំផលិតផលជាប្រភេទសម្រាប់ស្វែងរក និងរាយការណ៍កាន់តែលឿន។
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">🚚</div>
                    <h2 class="text-2xl font-bold mt-6">Supplier Management</h2>
                    <p class="mt-4 text-gray-600">
                        រក្សាទុកព័ត៌មានអ្នកផ្គត់ផ្គង់ និងគ្រប់គ្រងការទិញបានយ៉ាងមានប្រសិទ្ធភាព។
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📥</div>
                    <h2 class="text-2xl font-bold mt-6">Stock In</h2>
                    <p class="mt-4 text-gray-600">
                        កត់ត្រាទំនិញចូល និងធ្វើបច្ចុប្បន្នភាពកម្រិតស្តុកដោយស្វ័យប្រវត្តិ។
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📤</div>
                    <h2 class="text-2xl font-bold mt-6">Stock Out</h2>
                    <p class="mt-4 text-gray-600">
                        តាមដានផលិតផលចេញ និងរក្សាទុកកំណត់ត្រាស្តុកឱ្យបានត្រឹមត្រូវ។
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg p-8 hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="text-5xl">📊</div>
                    <h2 class="text-2xl font-bold mt-6">Reports & Analytics</h2>
                    <p class="mt-4 text-gray-600">
                        បង្កើតរបាយការណ៍ស្តុកជាមួយនឹងស្ថិតិដែលមានប្រយោជន៍សម្រាប់ការសម្រេចចិត្តកាន់តែប្រសើរ។
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

            <a href="../../authentication/register.php"
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