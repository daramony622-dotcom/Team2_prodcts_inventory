<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../includes/Navbar.php';
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>

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

<body
    class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen transition-colors duration-200">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Header Controls & Category Selector -->
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-slate-950 text-slate-100 p-6 rounded-2xl border border-slate-800 shadow-lg transition-colors duration-200">
            <div>
                <h1 id="page-title"
                    class="text-2xl sm:text-3xl font-bold text-slate-100 tracking-tight">
                    All Products
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">
                    Explore our latest inventory and hardware selection.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Category Dropdown populated via PHP/AJAX -->
                <select id="category-dropdown" onchange="onCategoryChange(this.value)"
                    class="bg-slate-800 border border-slate-700 text-slate-200 text-xs rounded-xl px-3 py-2.5 outline-none cursor-pointer shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    <option value="0">All Categories</option>
                </select>

                <button onclick="resetFilter()" id="reset-btn"
                    class="hidden text-xs bg-slate-800 hover:bg-slate-700 text-slate-100 px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer shadow-sm">
                    ✕ Reset Filter
                </button>
            </div>
        </div>

        <!-- Product Cards Grid Container -->
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 transition-opacity duration-300">
            <!-- Dynamic Content Loaded via PHP AJAX -->
        </div>

    </div>

    <script>
    // 1. AJAX Call to getCategories.php (PHP Endpoint)
    async function loadCategories(selectedId = 0) {
        try {
            const response = await fetch('../../inventory/categories/getCategories.php');
            const result = await response.json();

            if (result.status === 'success') {
                const dropdown = document.getElementById('category-dropdown');
                dropdown.innerHTML = '<option value="0">All Categories</option>';

                result.data.forEach(cat => {
                    const isSelected = cat.id == selectedId ? 'selected' : '';
                    dropdown.innerHTML +=
                        `<option value="${cat.id}" ${isSelected}>${cat.name || cat.category_name}</option>`;
                });
            }
        } catch (error) {
            console.error("AJAX Error loading categories:", error);
        }
    }

    function createLoadingSkeletons(count = 8) {
        let skeletonHTML = '';

        for (let i = 0; i < count; i++) {
            skeletonHTML += `
            <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-sm bg-slate-900 animate-pulse">
                <div class="h-52 bg-slate-800"></div>
                <div class="p-5 space-y-3">
                    <div class="h-4 rounded-full bg-slate-800 w-3/4"></div>
                    <div class="h-4 rounded-full bg-slate-800 w-1/2"></div>
                    <div class="h-10 rounded-2xl bg-slate-800 w-full"></div>
                </div>
            </div>`;
        }

        return skeletonHTML;
    }

    // 2. AJAX Call to filter.php (PHP Endpoint)
    async function loadProducts(categoryId = 0) {
        const grid = document.getElementById("product-grid");
        const pageTitle = document.getElementById("page-title");
        const resetBtn = document.getElementById("reset-btn");

        grid.innerHTML = createLoadingSkeletons(8);
        grid.classList.add('opacity-70');

        try {
            const response = await fetch(`../../inventory/products/filter.php?category_id=${categoryId}`);
            const result = await response.json();

            if (result.status === 'success') {
                renderProductCards(result.data);

                if (categoryId > 0) {
                    resetBtn.classList.remove('hidden');
                    const dropdown = document.getElementById('category-dropdown');
                    const selectedOpt = dropdown.options[dropdown.selectedIndex];
                    if (selectedOpt) {
                        pageTitle.innerText = selectedOpt.text;
                    }
                } else {
                    resetBtn.classList.add('hidden');
                    pageTitle.innerText = "All Products";
                }
            } else {
                grid.innerHTML =
                    `<div class="col-span-full text-center py-12 text-slate-300 bg-slate-900 rounded-2xl border border-slate-800 p-8 shadow-lg transition-colors duration-200">Failed to connect to PHP endpoint.</div>`;
            }
        } catch (error) {
            console.error("AJAX Error loading products:", error);
            grid.innerHTML =
                `<div class="col-span-full text-center py-12 text-slate-300 bg-slate-900 rounded-2xl border border-slate-800 p-8 shadow-lg transition-colors duration-200">Failed to connect to PHP endpoint.</div>`;
        } finally {
            grid.classList.remove('opacity-70');
        }
    }

    // 3. Handle dropdown change without full page refresh
    function onCategoryChange(catId) {
        loadProducts(catId);
        const newUrl = catId > 0 ? `products.php?category_id=${catId}` : `products.php`;
        window.history.pushState({
            category_id: catId
        }, '', newUrl);
    }

    // 4. Reset filter action
    function resetFilter() {
        document.getElementById('category-dropdown').value = 0;
        loadProducts(0);
        window.history.pushState({
            category_id: 0
        }, '', `products.php`);
    }

    // 5. Render HTML templates dynamically
    function renderProductCards(products) {
        const grid = document.getElementById("product-grid");

        if (!products || products.length === 0) {
            grid.innerHTML = `
            <div class="col-span-full text-center py-20 bg-slate-900 rounded-2xl border border-slate-800 p-8 shadow-lg transition-colors duration-200">
                    View all products →
                </button>
            </div>`;
            return;
        }

        const cardsHTML = products.map(item => {
            const stockQty = Number(item.quantity || item.stock || item.qty || 0);
            let badgeStyle =
                "bg-slate-900/90 text-sky-300 border border-slate-700 shadow-sm";
            let badgeText = `In Stock (${stockQty})`;

            if (stockQty === 0) {
                badgeStyle =
                    "bg-slate-900/90 text-rose-300 border border-slate-700 shadow-sm";
                badgeText = "Out of Stock";
            } else if (stockQty <= 5) {
                badgeStyle =
                    "bg-slate-900/90 text-amber-300 border border-slate-700 shadow-sm";
                badgeText = `Low Stock (${stockQty})`;
            }

            const rawImg = (item.image || item.image_url || item.img || "").trim();
            const imageSrc = rawImg.startsWith("http://") || rawImg.startsWith("https://") ?
                rawImg :
                rawImg.startsWith("/assets/") ?
                `../../..${rawImg}` :
                rawImg.startsWith("assets/") ?
                `../../../${rawImg}` :
                rawImg.length > 0 ?
                `../../assets/uploads/products/${rawImg}` :
                'https://placehold.co/300x200/f1f5f9/94a3b8?text=No+Image';

            const productName = item.product_name || item.name || 'Unnamed Product';
            const productCode = item.product_code || item.code || item.id;
            const description = item.description || 'High quality inventory product item.';
            const supplierName = item.supplier_name || 'Unknown Supplier';
            const categoryName = item.category_name || 'General';

            return `
            <div class="bg-slate-950 border border-slate-800 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                <div class="relative bg-slate-900/80 h-52 w-full flex items-center justify-center p-6 border-b border-slate-800">
                    <span class="absolute top-3 right-3 ${badgeStyle} text-[10px] font-semibold px-2.5 py-1 rounded-full z-10 border shadow-2xs">
                        ${badgeText}
                    </span>
                    <img src="${imageSrc}" 
                         alt="${productName}" 
                         onerror="this.onerror=null; this.src='https://placehold.co/300x200/f1f5f9/94a3b8?text=Image+Not+Found';"
                         class="max-h-40 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-200 bg-slate-900/90 border border-slate-700 px-2 py-0.5 rounded-md">
                                ${categoryName}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400">#${productCode}</span>
                        </div>
                        
                        <h3 class="text-base font-bold text-slate-800 dark:text-white mt-2.5 line-clamp-1" title="${productName}">
                            ${productName}
                        </h3>
                        
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 line-clamp-2 leading-relaxed">
                            ${description}
                        </p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-3">
                            Supplier: <span class="font-semibold text-slate-700 dark:text-slate-100">${supplierName}</span>
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Price</span>
                            <span class="text-lg font-extrabold text-slate-100">$${parseFloat(item.price || 0).toFixed(2)}</span>
                        </div>
                        <button class="bg-sky-500 hover:bg-sky-600 active:scale-95 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition shadow-sm cursor-pointer">
                            Details
                        </button>
                    </div>
                </div>
            </div>
            `;
        }).join('');

        grid.innerHTML = cardsHTML;
    }

    // Initialize AJAX execution on page load
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const catId = urlParams.get('category_id') || 0;

        loadCategories(catId);
        loadProducts(catId);
    });
    </script>

    <?php require_once __DIR__ . '/../includes/Footer.php'; ?>
</body>

</html>