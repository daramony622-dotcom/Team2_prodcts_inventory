<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

redirectIfLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Using jQuery CDN for reliability -->
    <script src="../js/jquery-3.7.1.min.js"></script>
</head> <!-- Added missing closing head tag -->

<body class="bg-gray-50">
    <!-- Added background class safely -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-700 to-indigo-500 px-4">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-1">Create Account</h2>
            <p class="text-gray-500 text-sm mb-6">Simple register page</p>

            <div id="alertBox" class="mb-4"></div>

            <form id="registerForm" class="space-y-4">

                <!-- Added action field to match backend requirements -->
                <input type="hidden" name="action" value="register">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Fixed: Added Confirm Password field to match backend validation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                    Register
                </button>

            </form>

            <p class="mt-5 text-center text-sm text-gray-600">
                Already have an account?
                <a href="login.php" class="text-blue-600 font-medium hover:underline">Login</a>
            </p>

        </div>

    </div>

    <script>
    $(document).ready(function() {
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const $alertBox = $('#alertBox');

            $.ajax({
                url: 'register_process.php',
                method: 'POST',
                data: formData,
                processData: false, // required when sending FormData
                contentType: false, // required when sending FormData
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $alertBox.html(`
                        <div class="bg-green-100 border border-green-300 text-green-700 text-sm px-4 py-2.5 rounded-lg">
                            ${data.message}
                        </div>`);

                        // Fixed: Relative path to login page to prevent 404 error
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 1500);
                    } else {
                        $alertBox.html(`
                        <div class="bg-red-100 border border-red-300 text-red-700 text-sm px-4 py-2.5 rounded-lg">
                            ${data.message}
                        </div>`);
                    }
                },
                error: function() {
                    $alertBox.html(`
                    <div class="bg-red-100 border border-red-300 text-red-700 text-sm px-4 py-2.5 rounded-lg">
                        Something went wrong. Please try again.
                    </div>`);
                }
            });
        });
    });
    </script>
</body>

</html>