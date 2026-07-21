<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// Get Product
$productQuery = mysqli_query($conn, "
    SELECT * FROM products
    WHERE id = $id
");

if (mysqli_num_rows($productQuery) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($productQuery);

// Get Categories
$categories = mysqli_query($conn, "
    SELECT * FROM categories
    ORDER BY name ASC
");

// Get Suppliers
$suppliers = mysqli_query($conn, "
    SELECT * FROM suppliers
    ORDER BY name ASC
");

ob_start();
?>

<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Product
    </h1>

    <form action="save.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <input type="hidden" name="old_image" value="<?= $product['image']; ?>">

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block mb-2">Product Name</label>

            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($product['name']); ?>"
                class="w-full border rounded-lg p-3"
                required>
        </div>

        <!-- Category -->
        <div class="mb-4">

            <label class="block mb-2">Category</label>

            <select
                name="category_id"
                class="w-full border rounded-lg p-3"
                required>

                <?php while($cat = mysqli_fetch_assoc($categories)): ?>

                    <option
                        value="<?= $cat['id']; ?>"
                        <?= ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($cat['name']); ?>

                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <!-- Supplier -->
        <div class="mb-4">

            <label class="block mb-2">Supplier</label>

            <select
                name="supplier_id"
                class="w-full border rounded-lg p-3"
                required>

                <?php while($sup = mysqli_fetch_assoc($suppliers)): ?>

                    <option
                        value="<?= $sup['id']; ?>"
                        <?= ($sup['id'] == $product['supplier_id']) ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($sup['name']); ?>

                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <!-- Price -->
        <div class="mb-4">

            <label class="block mb-2">Price</label>

            <input
                type="number"
                step="0.01"
                name="price"
                value="<?= $product['price']; ?>"
                class="w-full border rounded-lg p-3"
                required>

        </div>

        <!-- Quantity -->
        <div class="mb-4">

            <label class="block mb-2">Quantity</label>

            <input
                type="number"
                name="quantity"
                value="<?= $product['quantity']; ?>"
                class="w-full border rounded-lg p-3"
                required>

        </div>

        <!-- Description -->
        <div class="mb-4">

            <label class="block mb-2">Description</label>

            <textarea
                name="description"
                rows="4"
                class="w-full border rounded-lg p-3"><?= htmlspecialchars($product['description']); ?></textarea>

        </div>

        <!-- Current Image -->
        <div class="mb-4">

            <label class="block mb-2">Current Image</label>

            <?php if (!empty($product['image'])): ?>

                <img
                    src="../assets/uploads/products/<?= $product['image']; ?>"
                    width="120"
                    class="rounded border">

            <?php else: ?>

                <p>No image</p>

            <?php endif; ?>

        </div>

        <!-- New Image -->
        <div class="mb-6">

            <label class="block mb-2">New Image</label>

            <input
                type="file"
                name="image"
                accept="image/*"
                class="w-full border rounded-lg p-3">

        </div>

        <div class="flex gap-3">

            <button
                type="submit"
                name="update_product"
                class="bg-green-600 text-white px-6 py-3 rounded-lg">

                Update Product

            </button>

            <a
                href="index.php"
                class="bg-gray-600 text-white px-6 py-3 rounded-lg">

                Cancel

            </a>

        </div>

    </form>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../includes/layout/layout.php';