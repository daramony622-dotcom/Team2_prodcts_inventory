<?php
ob_start();
?>

<h1 class="text-2xl font-bold text-slate-800 mb-6">Dashboard Overview</h1>
<!-- dashboard stats/widgets go here -->

<?php
$content = ob_get_clean();
require __DIR__ . '/../includes/layout/layout.php';
?>