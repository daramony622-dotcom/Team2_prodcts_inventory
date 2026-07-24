<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

// Redirect user immediately if they are already logged in
redirectIfLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login System</title>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-700 to-indigo-500 px-4">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-1">Login System</h2>
            <p class="text-gray-500 text-sm mb-6">Please enter your credentials to access the system</p>

            <div id="alertBox" class="mb-4"></div>

            <form id="loginForm" class="space-y-4">

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

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                    Login
                </button>

            </form>

            <p class="mt-5 text-center text-sm text-gray-600">
                No account?
                <a href="register.php" class="text-blue-600 font-medium hover:underline">Register</a>
            </p>

        </div>

    </div>

    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const $alertBox = $('#alertBox');
            const formData = new FormData(this);
            formData.append('action', 'login');

            $.ajax({
                url: 'login_process.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $alertBox.html(`
                            <div class="bg-green-100 border border-green-300 text-green-700 text-sm px-4 py-2.5 rounded-lg">
                                ${data.message}
                            </div>
                        `);

                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 800);

                    } else {
                        $alertBox.html(`
                            <div class="bg-red-100 border border-red-300 text-red-700 text-sm px-4 py-2.5 rounded-lg">
                                ${data.message}
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    console.error("AJAX Response Error:", xhr.responseText);
                    $alertBox.html(`
                        <div class="bg-red-100 border border-red-300 text-red-700 text-sm px-4 py-2.5 rounded-lg">
                            An error occurred. Check browser console for details.
                        </div>
                    `);
                }
            });
        });
    });
    </script>

</body>

</html>