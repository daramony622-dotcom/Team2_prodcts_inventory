<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();
ob_start();
?>

<div class="flex-1 min-h-screen bg-gray-100 flex flex-col">
    <!-- Hero Header -->
    <section
        class="bg-gradient-to-r from-orange-600 via-orange-700 to-red-700 text-white py-10 px-6 rounded-b-3xl mx-4 sm:mx-6 mt-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Supplier Management</h1>
                <p class="text-orange-100 text-sm md:text-base">Manage your suppliers, contacts, and business relationships.
                </p>
            </div>
            <button id="openAddModalBtn"
                class="inline-flex items-center justify-center bg-white text-orange-700 font-semibold px-4 py-2 rounded-lg shadow-sm hover:bg-orange-50 transition">
                <i class="fa-solid fa-plus mr-2"></i> Add Supplier
            </button>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 w-full mt-6 mb-12 flex-1">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header Stats -->
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">All Suppliers</h2>
                        <p class="text-xs text-gray-500">Supplier contact list and details</p>
                    </div>
                    <div
                        class="rounded-xl bg-orange-50 border border-orange-100 px-3 py-2 text-sm font-semibold text-orange-700">
                        Total: <span id="supplierCount">0</span>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="p-4 md:p-5 border-b border-gray-100 bg-slate-50">
                <div class="flex gap-3 items-center flex-wrap">
                    <div class="flex-1 min-w-[250px]">
                        <input type="text" id="searchSupplier" placeholder="Search supplier name, phone, email..."
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                    </div>
                    <button type="button" id="btnRefreshSuppliers"
                        class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg transition">
                        <i class="fa-solid fa-rotate-right mr-1"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto p-4 md:p-5">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 rounded-l-xl">ID</th>
                            <th class="py-3.5 px-4">Supplier Name</th>
                            <th class="py-3.5 px-4">Phone</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4">Address</th>
                            <th class="py-3.5 px-4 text-center rounded-r-xl">Action</th>
                        </tr>
                    </thead>
                    <tbody id="supplierTableBody" class="text-sm text-gray-700">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 bg-white rounded-2xl shadow-sm">
                                <i class="fa-solid fa-truck text-3xl mb-2 block"></i>
                                <p class="text-sm font-medium">Loading suppliers...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Modal -->
<div id="supplierModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-6 mx-4">
        <div class="flex items-center justify-between mb-4">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Add Supplier</h2>
            <button type="button" id="closeModalBtn"
                class="text-gray-400 hover:text-gray-600 text-2xl leading-none">×</button>
        </div>

        <form id="supplierForm" class="space-y-4">
            <input type="hidden" id="supplier_id" name="id">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Supplier Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="supplier_name" name="supplier_name" required
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone</label>
                <input type="tel" id="phone" name="phone"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Address</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" id="closeModalBtnBottom"
                    class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition">
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$pageScripts = '<script src="' . BASE_URL . '/js/jquery-3.7.1.min.js"></script>
<script src="' . APP_BASE_URL . '/suppliers/api/crudSupplier.js"></script>
<script>
$(document).ready(function() {
    // Search functionality
    $("#searchSupplier").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        $("#supplierTableBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });

    // Refresh button
    $("#btnRefreshSuppliers").click(function() {
        loadSuppliers();
    });

    // Update supplier count
    function updateSupplierCount() {
        const count = $("#supplierTableBody tr:visible").length;
        $("#supplierCount").text(count);
    }

    // Override the loadSuppliers function to update count
    const originalLoad = window.loadSuppliers;
    window.loadSuppliers = function() {
        originalLoad.apply(this, arguments);
        setTimeout(updateSupplierCount, 500);
    };

    // Close modal handlers
    $("#closeModalBtnBottom").click(function() {
        $("#supplierModal").addClass("hidden");
    });

    // Update supplier count on page load
    setTimeout(updateSupplierCount, 1000);
});
</script>';
require_once __DIR__ . '/../../includes/layout/layout.php';
?>