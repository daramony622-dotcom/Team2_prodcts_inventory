<?php
require_once '../config/database.php';
require_once '../includes/session.php';

// Fetch products for dropdown
$products_query = "SELECT id, name, quantity FROM products ORDER BY name ASC";
$products_result = mysqli_query($conn, $products_query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add Stock In</h1>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

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
                                                <?= htmlspecialchars($prod['name']); ?> (Current Stock: <?= $prod['quantity']; ?>)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="purchase_price" class="form-label">Purchase Price ($)</label>
                                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control" min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label for="stock_in_date" class="form-label">Stock In Date</label>
                                    <input type="datetime-local" name="stock_in_date" id="stock_in_date" class="form-control" value="<?= date('Y-m-d\TH:i'); ?>" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Save Stock In</button>
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