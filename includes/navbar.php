<nav class="h-16 flex items-center justify-between px-6 bg-white shadow-sm">
    <span class="text-lg font-bold text-gray-800">My Dashboard</span>
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-600">Hi, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        <a href="logout.php" class="text-sm text-red-500 hover:underline">Logout</a>
    </div>
</nav>