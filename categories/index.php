<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

requiredAdmin();
ob_start();
?>

<div class="flex-1 min-h-screen bg-gray-100 flex flex-col">

    <!-- Hero Header Section -->
    <section
        class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white py-10 px-6 rounded-b-3xl mx-4 sm:mx-6 mt-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-extrabold mb-1">Category Management</h1>
            <p class="text-blue-100 text-sm md:text-base">
                គ្រប់គ្រង និងរៀបចំប្រភេទផលិតផលរបស់អ្នកយ៉ាងងាយស្រួល
            </p>
        </div>
    </section>

    <!-- Table Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 w-full mt-6 mb-12 flex-1">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- Top Action Bar -->
            <div class="p-5 bg-white border-b border-gray-100 flex flex-col gap-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">All Categories</h2>
                        <p class="text-xs text-gray-500">List of active categories in your inventory</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="relative">
                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input id="searchCategories" type="text" placeholder="Search categories..."
                                class="pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition w-full sm:w-64">
                        </div>

                        <button id="btnRefresh"
                            class="flex items-center justify-center space-x-2 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition text-xs">
                            <i class="fa-solid fa-rotate-right"></i>
                            <span>Refresh</span>
                        </button>
                        <button id="btnAddCategory"
                            class="flex items-center justify-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition text-xs">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add Category</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="rounded-xl bg-blue-50 p-3 border border-blue-100">
                        <p class="text-[11px] uppercase tracking-wide text-blue-600 font-semibold">Total Categories</p>
                        <h3 id="totalCategories" class="mt-1 text-2xl font-bold text-slate-800">0</h3>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 border border-emerald-100">
                        <p class="text-[11px] uppercase tracking-wide text-emerald-600 font-semibold">Status</p>
                        <h3 class="mt-1 text-lg font-bold text-slate-800">Online</h3>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 border border-amber-100">
                        <p class="text-[11px] uppercase tracking-wide text-amber-600 font-semibold">Table Summary</p>
                        <h3 id="tableSummary" class="mt-1 text-sm font-semibold text-slate-800">Showing all categories
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="overflow-x-auto p-4 md:p-5">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-6 rounded-l-xl">ID</th>
                            <th class="py-3.5 px-6">Category Name</th>
                            <th class="py-3.5 px-6">Description</th>
                            <th class="py-3.5 px-6 text-center rounded-r-xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesBody" class="text-sm text-gray-700">
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400">
                                <i class="fa-solid fa-spinner fa-spin text-2xl text-blue-600 mb-2"></i>
                                <p class="text-xs">Loading categories...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <!-- Category Insert/Edit Modal -->
    <div id="categoryModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold" id="modalTitle">Add Category</h3>
                        <p class="text-xs text-blue-100">Create or update a product category</p>
                    </div>
                </div>
                <button id="closeModal" class="text-white/80 hover:text-white text-xl font-bold">&times;</button>
            </div>

            <div class="p-6">
                <div id="formMessage" class="hidden mb-4 rounded-lg border px-3 py-2 text-sm"></div>

                <form id="categoryForm" class="space-y-4">
                    <input type="hidden" id="categoryId" name="id">

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Category Name</label>
                        <input type="text" id="categoryName" name="name" required placeholder="e.g. Electronics"
                            class="w-full px-3.5 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Description</label>
                        <textarea id="categoryDesc" name="description" rows="4" placeholder="Enter category details..."
                            class="w-full px-3.5 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2 border-t border-slate-100">
                        <p class="text-xs text-slate-500">Use this form to insert or edit a category.</p>
                        <div class="flex justify-end space-x-2.5">
                            <button type="button" id="btnCancelModal"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-xs transition">Cancel</button>
                            <button type="submit" id="btnSaveCategory"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-xs shadow-md transition">Save
                                Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= htmlspecialchars(BASE_URL) ?>/categories/api/crudCategoriesAjax.js"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../includes/layout/layout.php';
?>