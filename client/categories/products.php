<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../includes/Navbar.php';

// 2. Fetch category_id from URL query string if provided
$selected_category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$category_name = "All Products";
$products = [];

try {
    if ($selected_category_id > 0) {
        // Fetch products matching category
        $stmt = $pdo->prepare("SELECT p.*, c.category_name 
                            FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.id 
                            WHERE p.category_id = ? 
                            ORDER BY p.id DESC");
        $stmt->execute([$selected_category_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch category name for header title
        $catStmt = $pdo->prepare("SELECT category_name FROM categories WHERE id = ? LIMIT 1");
        $catStmt->execute([$selected_category_id]);
        $category = $catStmt->fetch(PDO::FETCH_ASSOC);
        if ($category) {
            $category_name = $category['category_name'];
        }
    } else {
        // Fetch all products
        $stmt = $pdo->query("SELECT p.*, c.category_name 
                             FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id 
                             ORDER BY p.id DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category_name) ?> - Catalog</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-50/50 font-sans text-slate-800 antialiased min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Header Controls -->
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h1 id="page-title" class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    <?= htmlspecialchars($category_name) ?>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">
                    Explore our latest inventory and hardware selection.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <?php if ($selected_category_id > 0): ?>
                <a href="<?= BASE_URL ?>/client/products.php"
                    class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-3.5 py-2.5 rounded-xl font-medium transition">
                    ✕ Clear Category Filter
                </a>
                <?php endif; ?>
                <button onclick="window.location.reload()"
                    class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                    🔄 Refresh
                </button>
            </div>
        </div>

        <!-- Product Cards Grid Container -->
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Dynamic JavaScript Content Rendered Here -->
        </div>

    </div>

    <script>
    // Safely inject PHP array directly into JS
    const initialProducts = <?= json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    function renderProductCards(products) {
        const grid = document.getElementById("product-grid");
        grid.innerHTML = "";

        if (!products || products.length === 0) {
            grid.innerHTML = `
            <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-slate-100 p-8 shadow-sm">
                <p class="text-slate-500 font-medium text-base">No products found in this category.</p>
                <a href="<?= BASE_URL ?>/client/products.php" class="inline-block mt-3 text-xs text-blue-600 font-semibold hover:underline">
                    View all products →
                </a>
            </div>`;
            return;
        }

        products.forEach(item => {
            const stockQty = parseInt(item.quantity || item.stock || item.qty || 0);
            let badgeStyle = "bg-emerald-50 text-emerald-600 border-emerald-200";
            let badgeText = `In Stock (${stockQty})`;

            if (stockQty === 0) {
                badgeStyle = "bg-rose-50 text-rose-600 border-rose-200";
                badgeText = "Out of Stock";
            } else if (stockQty <= 5) {
                badgeStyle = "bg-amber-50 text-amber-600 border-amber-200";
                badgeText = `Low Stock (${stockQty})`;
            }

            // Path resolution logic for images stored in assets/uploads/products/
            let rawImg = (item.image || item.image_url || item.img || "").trim();
            let imageSrc = "";

            if (rawImg.startsWith("http://") || rawImg.startsWith("https://")) {
                imageSrc = rawImg;
            } else if (rawImg.startsWith("/assets/")) {
                imageSrc = `<?= BASE_URL ?>${rawImg}`;
            } else if (rawImg.startsWith("assets/")) {
                imageSrc = `<?= BASE_URL ?>/${rawImg}`;
            } else if (rawImg.length > 0) {
                imageSrc = `<?= BASE_URL ?>/assets/uploads/products/${rawImg}`;
            } else {
                imageSrc = 'https://placehold.co/300x200/f1f5f9/94a3b8?text=No+Image';
            }

            const cardHTML = `
            <div class="bg-white border border-slate-200/70 rounded-2xl shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                
                <!-- Card Image -->
                <div class="relative bg-slate-50/80 h-52 w-full flex items-center justify-center p-6 border-b border-slate-100">
                    <span class="absolute top-3 right-3 ${badgeStyle} text-[10px] font-semibold px-2.5 py-1 rounded-full z-10 border shadow-2xs">
                        ${badgeText}
                    </span>
                    <img src="${imageSrc}" 
                         alt="${item.product_name || item.name}" 
                         onerror="this.onerror=null; this.src='https://placehold.co/300x200/f1f5f9/94a3b8?text=Image+Not+Found';"
                         class="max-h-40 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Card Body -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-md">
                                ${item.category_name || 'General'}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400">#${item.product_code || item.code || item.id}</span>
                        </div>
                        
                        <h3 class="text-base font-bold text-slate-800 mt-2.5 hover:text-blue-600 transition-colors cursor-pointer line-clamp-1" title="${item.product_name || item.name}">
                            ${item.product_name || item.name}
                        </h3>
                        
                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                            ${item.description || 'High quality inventory product item.'}
                        </p>
                    </div>

                    <!-- Card Footer -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Price</span>
                            <span class="text-lg font-extrabold text-slate-900">$${parseFloat(item.price || 0).toFixed(2)}</span>
                        </div>
                        
                        <button class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition shadow-xs">
                            Details
                        </button>
                    </div>
                </div>

            </div>
            `;

            grid.innerHTML += cardHTML;
        });
    }

    // Automatically render cards on page load
    document.addEventListener("DOMContentLoaded", function() {
        renderProductCards(initialProducts);
    });
    </script>

    <?php require_once __DIR__ . '/../includes/Footer.php'; ?>
</body>

</html>