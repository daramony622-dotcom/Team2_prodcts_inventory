<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../includes/Navbar.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory | Contact Us</title>

    <!-- CRITICAL: Early script to set dark mode class instantly and prevent flashing -->
    <script>
    if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && window.matchMedia(
            "(prefers-color-scheme: dark)").matches)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @custom-variant dark (&:where(.dark, .dark *));
</style>
</head>

<body class="bg-gray-50 dark:bg-slate-950 text-gray-800 dark:text-gray-100 transition-colors duration-200">

    <main>
        <!-- ================= HERO SECTION ================= -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-800 to-blue-600 dark:from-slate-900 dark:via-slate-900 dark:to-blue-950 text-white py-24 lg:py-32 transition-colors duration-200">
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px]">
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span
                    class="inline-block bg-blue-500/30 text-blue-200 dark:text-cyan-300 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                    Get in Touch
                </span>
                <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Contact Our <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-300 dark:from-cyan-400 dark:to-blue-500">Support
                        Team</span>
                </h1>
                <p class="mt-6 text-lg lg:text-xl text-blue-100 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed">
                    We'd love to hear from you. Send us your questions, feedback, or system suggestions and we'll get
                    back to you promptly.
                </p>
            </div>
        </section>

        <!-- ================= CONTACT SECTION ================= -->
        <section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-start">

                    <!-- Contact Information Cards -->
                    <div class="space-y-6">
                        <div>
                            <span
                                class="text-blue-600 dark:text-cyan-400 font-semibold tracking-wide text-sm uppercase">Reach
                                Out</span>
                            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">
                                Let's Start a Conversation
                            </h2>
                            <p class="mt-3 text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                                Encountering any trouble with the inventory management platform or have custom requests?
                                Feel free to connect directly through any channel below.
                            </p>
                        </div>

                        <div class="space-y-4 pt-4">
                            <!-- Email Card -->
                            <div
                                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300 flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-50 dark:bg-cyan-950/60 text-blue-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-xl shrink-0">
                                    📧
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Email Address</h3>
                                    <a href="mailto:mengsiek8@gmail.com"
                                        class="text-blue-600 dark:text-cyan-400 hover:underline mt-1 block font-medium">
                                        mengsiek8@gmail.com
                                    </a>
                                </div>
                            </div>

                            <!-- Phone Card -->
                            <div
                                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300 flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-xl shrink-0">
                                    📱
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Phone Number</h3>
                                    <a href="tel:+855963063226"
                                        class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white mt-1 block font-medium">
                                        +855 963 063 226
                                    </a>
                                </div>
                            </div>

                            <!-- Address Card -->
                            <div
                                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300 flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-xl shrink-0">
                                    📍
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Office Location</h3>
                                    <p class="text-slate-600 dark:text-slate-300 mt-1 font-medium">
                                        Phnom Penh, Cambodia
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Contact Form Card with Modern Dark Shadow & Styling -->
                    <div
                        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-xl shadow-slate-200/60 dark:shadow-none p-8 lg:p-10 transition-colors duration-200">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">
                            Send Us a Message
                        </h2>

                        <form action="#" method="POST" class="space-y-5">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Full Name
                                </label>
                                <input type="text" placeholder="John Doe"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:bg-white dark:focus:bg-slate-900 focus:border-blue-600 dark:focus:border-cyan-500 focus:ring-4 focus:ring-blue-600/10 dark:focus:ring-cyan-500/10 transition">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Email Address
                                </label>
                                <input type="email" placeholder="john@example.com"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:bg-white dark:focus:bg-slate-900 focus:border-blue-600 dark:focus:border-cyan-500 focus:ring-4 focus:ring-blue-600/10 dark:focus:ring-cyan-500/10 transition">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Subject
                                </label>
                                <input type="text" placeholder="How can we help you?"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:bg-white dark:focus:bg-slate-900 focus:border-blue-600 dark:focus:border-cyan-500 focus:ring-4 focus:ring-blue-600/10 dark:focus:ring-cyan-500/10 transition">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Message
                                </label>
                                <textarea rows="4" placeholder="Write your details or inquiry here..."
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:bg-white dark:focus:bg-slate-900 focus:border-blue-600 dark:focus:border-cyan-500 focus:ring-4 focus:ring-blue-600/10 dark:focus:ring-cyan-500/10 transition resize-none"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 text-white font-semibold py-4 rounded-xl shadow-lg shadow-blue-600/25 dark:shadow-none transition duration-200">
                                Send Message
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/../includes/Footer.php';
    ?>

</body>

</html>