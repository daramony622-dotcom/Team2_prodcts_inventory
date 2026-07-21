<?php
require_once __DIR__ . '/../config/database.php';

// Get Categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

// Get Suppliers
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY name ASC");

ob_start();
?>

<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

    <h1 class="text-2xl font-bold text-slate-800 mb-6">
        Add Product
    </h1>

    <form action="save.php" method="POST" enctype="multipart/form-data">

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Product Name</label>
            <input
                type="text"
                name="name"
                class="w-full border rounded-lg p-3"
                placeholder="Enter product name"
                required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Category</label>

            <select
                name="category_id"
                class="w-full border rounded-lg p-3"
                required>

                <option value="">-- Select Category --</option>

                <?php while($category = mysqli_fetch_assoc($categories)): ?>

                    <option value="<?= $category['id']; ?>">
                        <?= htmlspecialchars($category['name']); ?>
                    </option>

                <?php endwhile; ?>

            </select>
        </div>

        <!-- Supplier -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Supplier</label>

            <select
                name="supplier_id"
                class="w-full border rounded-lg p-3"
                required>

                <option value="">-- Select Supplier --</option>

                <?php while($supplier = mysqli_fetch_assoc($suppliers)): ?>

                    <option value="<?= $supplier['id']; ?>">
                        <?= htmlspecialchars($supplier['name']); ?>
                    </option>

                <?php endwhile; ?>

            </select>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Price ($)</label>

            <input
                type="number"
                name="price"
                step="0.01"
                min="0"
                class="w-full border rounded-lg p-3"
                required>
        </div>

        <!-- Quantity -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Quantity</label>

            <input
                type="number"
                name="quantity"
                min="0"
                class="w-full border rounded-lg p-3"
                required>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Description</label>

            <textarea
                name="description"
                rows="4"
                class="w-full border rounded-lg p-3"></textarea>
        </div>

        <!-- Image -->
        <div class="mb-6">
            <label class="block mb-2 font-medium">Product Image</label>

            <input
                type="file"
                name="image"
                accept="image/*"
                class="w-full border rounded-lg p-3">
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">

            <button
                type="submit"
                name="save_product"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                Save Product

            </button>

            <a
                href="index.php"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                Cancel

            </a>

        </div>

    </form>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../includes/layout/layout.php';
?>