<?php
require_once '../config/database.php';
require_once '../includes/session.php';

// Fetch stock-in records joined with products and users
$query = "SELECT si.*, p.name AS product_name, u.username 
          FROM stock_in si 
          LEFT JOIN products p ON si.product_id = p.id 
          LEFT JOIN users u ON si.user_id = u.id 
          ORDER BY si.stock_in_date DESC";
$result = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Stock In Management</h1>
                <a href="add.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Stock In
                </a>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Purchase Price</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= htmlspecialchars($row['product_name']); ?></td>
                                            <td><span class="badge bg-success">+<?= $row['quantity']; ?></span></td>
                                            <td>$<?= number_format($row['purchase_price'], 2); ?></td>
                                            <td><?= $row['stock_in_date']; ?></td>
                                            <td><?= htmlspecialchars($row['username'] ?? 'System'); ?></td>
                                            <td>
                                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record? This will also revert the product quantity.');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No stock-in records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>