<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

// Redirect user immediately if they are already logged in
redirectIfLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory | Secure Login</title>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-950 text-slate-100 antialiased selection:bg-cyan-500 selection:text-slate-950">

    <!-- Background with Custom Image & Dark Futuristic Overlay -->
    <div class="min-h-screen flex items-center justify-center px-4 relative bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(to bottom, rgba(3, 7, 18, 0.85), rgba(15, 23, 42, 0.90)), url('../assets/images/bg-tech.jpg');">

        <!-- Subtle Glow Effects behind Card -->
        <div class="absolute w-72 h-72 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Glassmorphism Login Container -->
        <div
            class="relative z-10 bg-slate-900/60 backdrop-blur-xl border border-cyan-500/30 w-full max-w-md rounded-3xl shadow-[0_0_50px_rgba(6,182,212,0.15)] p-8 lg:p-10">

            <!-- Header Title -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-2xl mb-4 shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                    🔐
                </div>
                <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-white">System Access</h2>
                <p class="text-slate-400 text-sm mt-1">Authenticate your credentials to enter inventory control</p>
            </div>

            <!-- Dynamic Alert Box -->
            <div id="alertBox" class="mb-4"></div>

            <!-- Form -->
            <form id="loginForm" class="space-y-5">

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-2">Email
                        Address</label>
                    <input type="email" id="email" name="email" required placeholder="name@company.com"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-2">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••••••"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold py-4 rounded-xl shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(6,182,212,0.6)] transition duration-200 cursor-pointer">
                    Authorize Login
                </button>

            </form>

            <!-- Footer Switch -->
            <p class="mt-8 text-center text-sm text-slate-400">
                New clearance required?
                <a href="register.php" class="text-cyan-400 font-semibold hover:underline ml-1">Register System</a>
            </p>

        </div>

    </div>

    <!-- AJAX Script Logic -->
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
                            <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                                ✓ ${data.message}
                            </div>
                        `);

                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 800);

                    } else {
                        $alertBox.html(`
                            <div class="bg-rose-950/80 border border-rose-500/50 text-rose-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                                ⚠ ${data.message}
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    console.error("AJAX Response Error:", xhr.responseText);
                    $alertBox.html(`
                        <div class="bg-rose-950/80 border border-rose-500/50 text-rose-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                            ⚠ An error occurred. Check browser console for details.
                        </div>
                    `);
                }
            });
        });
    });
    </script>

</body>

</html>