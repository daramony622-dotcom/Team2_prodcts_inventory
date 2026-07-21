<?php
require_once __DIR__ . '/../config/database.php';

// Upload folder
$uploadDir = __DIR__ . '/../assets/uploads/products/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/*
|--------------------------------------------------------------------------
| ADD PRODUCT
|--------------------------------------------------------------------------
*/
if (isset($_POST['save_product'])) {

    $name        = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $supplier_id = (int)$_POST['supplier_id'];
    $price       = $_POST['price'];
    $quantity    = $_POST['quantity'];
    $description = trim($_POST['description']);

    $image = "";

    // Upload Image
    if (!empty($_FILES['image']['name'])) {

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $allowed)) {

            $image = time() . "_" . uniqid() . "." . $extension;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $uploadDir . $image
            );
        }
    }

    $sql = "INSERT INTO products
            (category_id, supplier_id, name, price, quantity, description, image)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iisdiis",
        $category_id,
        $supplier_id,
        $name,
        $price,
        $quantity,
        $description,
        $image
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| UPDATE PRODUCT
|--------------------------------------------------------------------------
*/
if (isset($_POST['update_product'])) {

    $id          = (int)$_POST['id'];
    $name        = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $supplier_id = (int)$_POST['supplier_id'];
    $price       = $_POST['price'];
    $quantity    = $_POST['quantity'];
    $description = trim($_POST['description']);

    $image = $_POST['old_image'];

    // Upload new image
    if (!empty($_FILES['image']['name'])) {

        // Delete old image
        if (!empty($image)) {

            $oldFile = $uploadDir . $image;

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $allowed)) {

            $image = time() . "_" . uniqid() . "." . $extension;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $uploadDir . $image
            );
        }
    }

    $sql = "UPDATE products SET

                category_id=?,
                supplier_id=?,
                name=?,
                price=?,
                quantity=?,
                description=?,
                image=?

            WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iisdiisi",
        $category_id,
        $supplier_id,
        $name,
        $price,
        $quantity,
        $description,
        $image,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;