<?php
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
define("BASE_URL", "/Team2_prodcts_inventory");

// Include Database Connection
require_once __DIR__ . '/database.php';
?>