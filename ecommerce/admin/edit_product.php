<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get product ID from URL
if (!isset($_GET['id'])) {
    echo "No product ID specified.";
    exit();
}

$product_id = $_GET['id'];

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}

$successMessage = '';

// Update product
if (isset($_POST['update_product'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $imageName = $product['image']; // default to existing image

    // Check for new image
    if ($_FILES['image']['error'] === 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetPath = "../images/$imageName";
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    // Update DB
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $price, $description, $imageName, $product_id]);

    $successMessage = "✅ Product updated successfully!";
    // Reload updated data
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container {
            width: 50%; margin: 50px auto; background: #fff; padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px;
        }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; font-weight: bold; }
        input, textarea { padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }
        button {
            background: #007bff; color: white; padding: 12px;
            border: none; font-size: 16px; border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .message { text-align: center; color: green; margin-top: 20px; }
        img { max-width: 120px; display: block; margin-top: 10px; }
        .back-link {
            text-align: center; margin-top: 20px;
        }
        .back-link a {
            color: #007bff; text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="<?= $product['price'] ?>" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($product['description']) ?></textarea>

            <label for="image">Image</label>
            <input type="file" name="image" id="image">
            <img src="../images/<?= $product['image'] ?>" alt="Product Image">

            <button type="submit" name="update_product">Update Product</button>
        </form>

        <?php if (!empty($successMessage)): ?>
            <div class="message"><?= $successMessage ?></div>
        <?php endif; ?>

        <div class="back-link">
            <a href="manage_products.php">← Back to Manage Products</a>
        </div>
    </div>
</body>
</html>
