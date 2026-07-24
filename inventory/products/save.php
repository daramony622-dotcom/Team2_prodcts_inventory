<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

requiredAdmin();

$uploadDir = __DIR__ . '/../../assets/uploads/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function uploadProductImage(array $file, string $uploadDir): string
{
    if (empty($file['name'])) {
        return '';
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $allowed, true)) {
        return '';
    }

    $imageName = time() . '_' . uniqid() . '.' . $extension;
    move_uploaded_file($file['tmp_name'], $uploadDir . $imageName);

    return $imageName;
}

if (isset($_POST['save_product'])) {
    $name        = trim($_POST['name'] ?? '');
    $productCode = trim($_POST['product_code'] ?? '');
    $categoryId  = (int) ($_POST['category_id'] ?? 0);
    $supplierId  = (int) ($_POST['supplier_id'] ?? 0);
    $price       = (float) ($_POST['price'] ?? 0);
    $quantity    = (int) ($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image       = uploadProductImage($_FILES['image'] ?? [], $uploadDir);

    if ($name === '' || $productCode === '' || $categoryId <= 0 || $supplierId <= 0) {
        header('Location: ' . APP_BASE_URL . '/products/add.php?error=missing_supplier');
        exit;
    }

    $supplierExists = $pdo->prepare('SELECT id FROM suppliers WHERE id = :id LIMIT 1');
    $supplierExists->execute([':id' => $supplierId]);
    if (!$supplierExists->fetch(PDO::FETCH_ASSOC)) {
        header('Location: ' . APP_BASE_URL . '/products/add.php?error=invalid_supplier');
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO products (category_id, supplier_id, product_name, product_code, price, quantity, description, image)
        VALUES (:category_id, :supplier_id, :product_name, :product_code, :price, :quantity, :description, :image)'
    );

    $stmt->execute([
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':product_name' => $name,
        ':product_code' => $productCode,
        ':price' => $price,
        ':quantity' => $quantity,
        ':description' => $description,
        ':image' => $image,
    ]);

    header('Location: ' . BASE_URL . '/products/index.php');
    exit;
}

if (isset($_POST['update_product'])) {
    $id          = (int) ($_POST['id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $productCode = trim($_POST['product_code'] ?? '');
    $categoryId  = (int) ($_POST['category_id'] ?? 0);
    $supplierId  = (int) ($_POST['supplier_id'] ?? 0);
    $price       = (float) ($_POST['price'] ?? 0);
    $quantity    = (int) ($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image       = trim($_POST['old_image'] ?? '');

    if ($id <= 0 || $name === '' || $productCode === '' || $categoryId <= 0 || $supplierId <= 0) {
        header('Location: ' . APP_BASE_URL . '/products/index.php?error=invalid_product');
        exit;
    }

    $supplierExists = $pdo->prepare('SELECT id FROM suppliers WHERE id = :id LIMIT 1');
    $supplierExists->execute([':id' => $supplierId]);
    if (!$supplierExists->fetch(PDO::FETCH_ASSOC)) {
        header('Location: ' . APP_BASE_URL . '/products/index.php?error=invalid_supplier');
        exit;
    }

    $newImage = uploadProductImage($_FILES['image'] ?? [], $uploadDir);
    if (!empty($newImage)) {
        if (!empty($image)) {
            $oldFile = $uploadDir . $image;
            if (file_exists($oldFile)) {
            unlink($oldFile);
            }
        }
        $image = $newImage;
    }

    $stmt = $pdo->prepare(
        'UPDATE products
        SET category_id = :category_id,
        supplier_id = :supplier_id,
        product_name = :product_name,
        product_code = :product_code,
        price = :price,
        quantity = :quantity,
        description = :description,
        image = :image
        WHERE id = :id'
    );

    $stmt->execute([
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':product_name' => $name,
        ':product_code' => $productCode,
        ':price' => $price,
        ':quantity' => $quantity,
        ':description' => $description,
        ':image' => $image,
        ':id' => $id,
    ]);

    header('Location: ' . APP_BASE_URL . '/products/index.php');
    exit;
}

header('Location: ' . APP_BASE_URL . '/products/index.php');
exit;