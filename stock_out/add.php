<?php
require_once '../config/database.php';
require_once '../includes/session.php';

// Fetch available products with stock > 0
$products_query = "SELECT id, name, quantity FROM products WHERE quantity > 0 ORDER BY name ASC";
$products_result = mysqli_query($conn, $products_query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add Stock Out</h1>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="save.php" method="POST">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-select" required>
                                        <option value="">-- Choose Product --</option>
                                        <?php while ($prod = mysqli_fetch_assoc($products_result)): ?>
                                            <option value="<?= $prod['id']; ?>">
                                                <?= htmlspecialchars($prod['name']); ?> (Available Stock: <?= $prod['quantity']; ?>)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="selling_price" class="form-label">Selling Price ($)</label>
                                    <input type="number" step="0.01" name="selling_price" id="selling_price" class="form-control" min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label for="stock_out_date" class="form-label">Stock Out Date</label>
                                    <input type="datetime-local" name="stock_out_date" id="stock_out_date" class="form-control" value="<?= date('Y-m-d\TH:i'); ?>" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning text-dark fw-bold">Save Stock Out</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>