<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../auth.php';

// requiredLogin();
redirectIfLogin(); // protection happens here, explicitly
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php include __DIR__ . '/../header.php'; ?>

    <body class="font-sans bg-slate-100">

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