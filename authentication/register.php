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
</head>

<body class="bg-slate-950 text-slate-100 antialiased selection:bg-cyan-500 selection:text-slate-950">

    <!-- Background with Custom Image & Dark Futuristic Overlay -->
    <div class="min-h-screen flex items-center justify-center px-4 relative bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(to bottom, rgba(3, 7, 18, 0.82), rgba(15, 23, 42, 0.88)), url('../assets/images/bg-tech-register.jpg');">

        <!-- Subtle Tech Glow Effects -->
        <div class="absolute w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute w-80 h-80 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Glassmorphism Register Container -->
        <div
            class="relative z-10 bg-slate-900/55 backdrop-blur-xl border border-cyan-500/30 w-full max-w-md rounded-3xl shadow-[0_0_50px_rgba(6,182,212,0.15)] p-8 lg:p-10">

            <div class="text-center mb-6">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xl mb-3 shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                    🛡️
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-white">Create Account</h2>
                <p class="text-slate-400 text-sm mt-1">Initialize new system credentials</p>
            </div>

            <div id="alertBox" class="mb-4"></div>

            <form id="registerForm" class="space-y-4">

                <input type="hidden" name="action" value="register">

                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-1.5">Username</label>
                    <input type="text" id="username" name="username" required placeholder="johndoe"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" required placeholder="name@company.com"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••••••"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-cyan-300 mb-1.5">Confirm
                        Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        placeholder="••••••••••••"
                        class="w-full bg-slate-950/50 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 transition">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold py-3.5 rounded-xl shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(6,182,212,0.6)] transition duration-200 cursor-pointer mt-2">
                    Register System
                </button>

            </form>

            <p class="mt-6 text-center text-sm text-slate-400">
                Already have clearance?
                <a href="login.php" class="text-cyan-400 font-semibold hover:underline ml-1">Login</a>
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
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $alertBox.html(`
                        <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                            ✓ ${data.message}
                        </div>`);

                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 1500);
                    } else {
                        $alertBox.html(`
                        <div class="bg-rose-950/80 border border-rose-500/50 text-rose-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                            ⚠ ${data.message}
                        </div>`);
                    }
                },
                error: function() {
                    $alertBox.html(`
                    <div class="bg-rose-950/80 border border-rose-500/50 text-rose-300 text-sm px-4 py-3 rounded-xl backdrop-blur-md shadow-lg">
                        ⚠ Something went wrong. Please try again.
                    </div>`);
                }
            });
        });
    });
    </script>
</body>

</html>