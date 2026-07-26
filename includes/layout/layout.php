<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../auth.php';

requiredLogin();
?>
<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/../header.php'; ?>

<body class="font-sans bg-[#07111d] text-slate-100" style="background-image:
        radial-gradient(circle at 8% 10%, rgba(56,189,248,0.18), transparent 18%),
        radial-gradient(circle at 92% 18%, rgba(37,99,235,0.14), transparent 16%),
        radial-gradient(circle at 50% 100%, rgba(59,130,246,0.08), transparent 24%),
        linear-gradient(180deg, rgba(10,25,47,0.96), rgba(15,23,42,0.96));">

    <?php include __DIR__ . '/../sideBar.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col">

        <?php include __DIR__ . '/../navbar.php'; ?>

        <main class="flex-1 p-6">
            <?= $content ?? '' ?>
        </main>

        <?php include __DIR__ . '/../footer.php'; ?>

    </div>

    <?= $pageScripts ?? '' ?>
</body>

</html>