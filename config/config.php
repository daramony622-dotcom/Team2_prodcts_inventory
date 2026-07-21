<?php
    require_once __DIR__ . "/database.php";
// =====================================
// Application Configuration
// =====================================

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set Timezone
date_default_timezone_set("Asia/Phnom_Penh");

// Website Information
define("SITE_NAME", "Product Inventory Management System");
define("BASE_URL", "http://localhost/Product-Inventory-System/");

// Include Database Connection
?>