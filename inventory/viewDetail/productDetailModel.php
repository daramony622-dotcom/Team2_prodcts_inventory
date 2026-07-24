<!-- ============================================================
    Product Detail Modal - Enhanced Version
    ============================================================ -->

<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="modalBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div
        class="relative bg-white w-full max-w-4xl mx-4 rounded-2xl shadow-2xl shadow-slate-900/20 p-6 sm:p-8 max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Product Details</h2>
            <div class="flex items-center gap-2">
                <a id="editBtn" href="#"
                    class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-amber-200 text-amber-600 text-sm font-medium hover:bg-amber-50 transition">
                    <i class="fa-solid fa-edit"></i> Edit
                </a>
                <button type="button" id="deleteBtn"
                    class="flex items-center gap-1.5 px-3 py-2 rounded-lg bg-red-50 text-red-600 text-sm font-medium hover:bg-red-100 transition">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <button type="button" id="closeModalBtn"
                    class="ml-2 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 transition">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <div id="modalLoading" class="hidden py-16 text-center text-sm text-slate-400">
            <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 text-slate-300"></i>
            <p>Loading product details...</p>
        </div>
        <div id="modalError" class="hidden py-16 text-center text-sm text-red-500"></div>

        <div id="modalContent" class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

            <!-- Left Column: Image & Quick Stats -->
            <div class="space-y-5">
                <!-- Product Image -->
                <div
                    class="rounded-xl overflow-hidden bg-gradient-to-br from-blue-100 via-indigo-50 to-slate-100 h-64 flex items-center justify-center border border-slate-200">
                    <img id="productImage" src="" alt="" class="w-full h-full object-cover hidden">
                    <div id="noImage" class="text-center text-slate-400">
                        <i class="fa-solid fa-image text-4xl mb-2 block"></i>
                        <p class="text-xs">No image available</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="border border-slate-200 rounded-xl p-4 bg-gradient-to-br from-slate-50 to-slate-100">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Performance</span>
                        <span id="performanceBadge"
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">—</span>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-600 font-medium">Current Stock:</dt>
                            <dd id="currentStock" class="font-bold text-slate-900">0</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-600 font-medium">Total Sold:</dt>
                            <dd id="totalSold" class="font-bold text-slate-900">0 units</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-600 font-medium">Stock In:</dt>
                            <dd id="totalStockIn" class="font-bold text-slate-900">0 units</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="space-y-6">
                <!-- Product Header -->
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 mb-2 font-bold">Product ID & Name</p>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span id="productCode"
                                class="text-xs px-2.5 py-1 rounded-md bg-blue-100 text-blue-700 font-mono font-bold">—</span>
                            <span class="text-slate-300">·</span>
                            <span id="productName" class="text-lg font-bold text-slate-900">—</span>
                        </div>
                        <p id="productCategory"
                            class="text-xs text-slate-500"><span class="font-semibold text-slate-700">Category:</span> —</p>
                        <p id="productSupplier"
                            class="text-xs text-slate-500"><span class="font-semibold text-slate-700">Supplier:</span> —</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 mb-2 font-bold">Description</p>
                    <p id="productDescription" class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-200">—</p>
                </div>

                <!-- Pricing Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-emerald-200 rounded-xl p-4">
                        <p class="text-xs uppercase tracking-wide text-emerald-700 mb-1 font-bold">Selling Price</p>
                        <p id="productPrice" class="text-2xl font-bold text-emerald-700">$0.00</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-indigo-200 rounded-xl p-4">
                        <p class="text-xs uppercase tracking-wide text-indigo-700 mb-1 font-bold">Avg. Purchase Price</p>
                        <p id="avgPurchasePrice" class="text-2xl font-bold text-indigo-700">$0.00</p>
                    </div>
                </div>

                <!-- Stock Timeline -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-700 mb-4 font-bold">Stock Movement</p>
                    <div class="space-y-3">
                        <div class="flex items-start justify-between py-2 border-b border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-green-500 mt-0.5"></div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-700">Last Stock In</p>
                                    <p class="text-xs text-slate-500" id="lastStockInDate">—</p>
                                </div>
                            </div>
                            <span id="lastStockInQty" class="text-sm font-bold text-green-700">—</span>
                        </div>
                        <div class="flex items-start justify-between py-2">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-500 mt-0.5"></div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-700">Last Stock Out (Sale)</p>
                                    <p class="text-xs text-slate-500" id="lastStockOutDate">—</p>
                                </div>
                            </div>
                            <span id="lastStockOutQty" class="text-sm font-bold text-red-700">—</span>
                        </div>
                    </div>
                </div>

                <!-- Sales Summary -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-purple-700 mb-3 font-bold">Sales Summary</p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-2xl font-bold text-purple-700" id="avgSellingPrice">$0.00</p>
                            <p class="text-xs text-purple-600 mt-1">Avg. Selling Price</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-pink-700" id="totalProfit">$0.00</p>
                            <p class="text-xs text-pink-600 mt-1">Est. Total Profit</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-purple-700" id="profitMargin">0%</p>
                            <p class="text-xs text-purple-600 mt-1">Profit Margin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    const $modal = $('#detailModal');
    const $loading = $('#modalLoading');
    const $error = $('#modalError');
    const $content = $('#modalContent');

    // Delegated so it works for rows added/filtered dynamically too
    $(document).on('click', '.view-product-btn', function() {
        const id = $(this).data('id');
        openDetailModal(id);
    });

    $('#closeModalBtn, #modalBackdrop').on('click', closeDetailModal);
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeDetailModal();
    });

    function openDetailModal(id) {
        $modal.removeClass('hidden').addClass('flex');
        $content.addClass('hidden');
        $error.addClass('hidden');
        $loading.removeClass('hidden');
        $('body').css('overflow', 'hidden');

        $.ajax({
                url: '<?= APP_BASE_URL ?>/viewDetail/detailProducts.php',
                method: 'GET',
                data: {
                    id: id
                },
                dataType: 'json'
            })
            .done(function(res) {
                $loading.addClass('hidden');
                if (!res.success) {
                    $error.removeClass('hidden').text(res.message || 'Something went wrong');
                    return;
                }
                renderProduct(res);
                $content.removeClass('hidden');
            })
            .fail(function() {
                $loading.addClass('hidden');
                $error.removeClass('hidden').text('Failed to load product details');
            });
    }

    function closeDetailModal() {
        $modal.addClass('hidden').removeClass('flex');
        $('body').css('overflow', '');
    }

    function renderProduct(p) {
        // Basic Info
        $('#productCode').text(p.code || '#' + p.id);
        $('#productName').text(p.name);
        $('#productCategory').html('<span class="font-semibold text-slate-700">Category:</span> ' + (p.category || 'Uncategorized'));
        $('#productSupplier').html('<span class="font-semibold text-slate-700">Supplier:</span> ' + (p.supplier || 'No Supplier'));
        $('#productDescription').text(p.description);
        
        // Pricing
        $('#productPrice').text('$' + p.price);
        $('#avgPurchasePrice').text('$' + p.avg_purchase_price);
        $('#avgSellingPrice').text('$' + p.avg_selling_price);
        
        // Stock Info
        $('#currentStock').text(p.quantity + ' units');
        $('#totalSold').text(p.total_stock_out + ' units');
        $('#totalStockIn').text(p.total_stock_in + ' units');
        
        // Dates
        $('#lastStockInDate').text(p.last_stock_in_date);
        $('#lastStockInQty').text(p.total_stock_in + ' units');
        $('#lastStockOutDate').text(p.last_stock_out_date);
        $('#lastStockOutQty').text(p.total_stock_out + ' units');
        
        // Performance
        const performanceColors = {
            'Excellent': 'bg-emerald-100 text-emerald-700',
            'Good': 'bg-blue-100 text-blue-700',
            'Fair': 'bg-amber-100 text-amber-700',
            'Low': 'bg-slate-100 text-slate-700'
        };
        const perfColor = performanceColors[p.performance] || performanceColors['Low'];
        $('#performanceBadge').attr('class', 'px-3 py-1 rounded-full text-xs font-semibold ' + perfColor).text(p.performance);
        
        // Profit Calculations
        const purchasePrice = parseFloat(p.avg_purchase_price) || 0;
        const sellingPrice = parseFloat(p.avg_selling_price) || 0;
        const profitPerUnit = sellingPrice - purchasePrice;
        const totalProfit = profitPerUnit * p.total_stock_out;
        const profitMargin = purchasePrice > 0 ? ((profitPerUnit / purchasePrice) * 100).toFixed(1) : 0;
        
        $('#totalProfit').text('$' + totalProfit.toFixed(2));
        $('#profitMargin').text(profitMargin + '%');
        
        // Image
        const $img = $('#productImage');
        const $noImage = $('#noImage');
        if (p.image) {
            $img.attr('src', p.image).removeClass('hidden');
            $noImage.addClass('hidden');
        } else {
            $img.addClass('hidden');
            $noImage.removeClass('hidden');
        }

        $('#editBtn').attr('href', '<?= APP_BASE_URL ?>/products/edit.php?id=' + p.id);
        $('#deleteBtn').off('click').on('click', function() {
            if (!confirm('Delete this product?')) return;
            $.post('<?= APP_BASE_URL ?>/products/delete.php', {
                    id: p.id
                })
                .done(function() {
                    closeDetailModal();
                    window.location.reload();
                })
                .fail(function() {
                    alert('Failed to delete product');
                });
        });
    }
});
</script>
                    location.reload();
                })
                .fail(function() {
                    alert('Failed to delete product');
                });
        });
    }

    // expose for inline onclick usage if you prefer that over .view-product-btn
    window.openDetailModal = openDetailModal;
});
</script>