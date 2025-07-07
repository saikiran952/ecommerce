<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../includes/db.php');

// Get product ID
$id = $_GET['id'] ?? 0;

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("❌ Product not found.");
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image_name = $product['image']; // Default to old image

    // If new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '-' . preg_replace('/[^A-Za-z0-9\.-]/', '_', $_FILES['image']['name']);
        $target_dir = '../images/';
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image_name);
    }

    // Update query
    $update = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
    $update->bind_param("ssdsi", $name, $desc, $price, $image_name, $id);

    if ($update->execute()) {
        header("Location: products.php");
        exit();
    } else {
        $error = "❌ Failed to update product.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #007bff; color: white; padding: 10px 15px; margin-top: 15px; border: none; width: 100%; }
        img { max-width: 100px; display: block; margin-top: 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit Product</h2>
<?php if (isset($error)) echo "<p style='color:red; text-align:center;'>{$error}</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Description:</label>
    <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

    <label>Price (₹):</label>
    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

    <label>Current Image:</label>
    <?php if ($product['image']) : ?>
        <img src="../images/<?= htmlspecialchars($product['image']) ?>" alt="Product Image">
    <?php else: ?>
        <p>No image</p>
    <?php endif; ?>

    <label>Upload New Image:</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Update Product</button>
</form>

</body>
</html>
