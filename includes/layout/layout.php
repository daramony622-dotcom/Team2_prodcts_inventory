<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../auth.php';

requiredLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ETEC Center</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="font-sans bg-slate-100">

    <?php include __DIR__ . '/../header.php'; ?>

    <?php include __DIR__ . '/../sideBar.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col">

        <?php include __DIR__ . '/../navbar.php'; ?>

        <main class="flex-1 p-6">
            <?= $content ?? '' ?>
        </main>

        <?php include __DIR__ . '/../footer.php'; ?>

    </div>

</body>

</html>