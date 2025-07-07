<?php
// ✅ Avoid duplicate session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Admin login check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../includes/db.php');

// ✅ Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image_name = '';

    // ✅ Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = time() . '-' . preg_replace('/[^A-Za-z0-9\.-]/', '_', basename($_FILES['image']['name']));
        $target_dir = '../images/';
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die("❌ Image upload failed.");
        }
    }

    // ✅ Insert product
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $desc, $price, $image_name);

    if ($stmt->execute()) {
        $success = "✅ Product added successfully!";
    } else {
        $error = "❌ Failed to add product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product (Admin)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e8f5e9;
            padding: 30px;
        }

        h2 {
            color: #2e7d32;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #388e3c;
            color: white;
            padding: 10px 16px;
            margin-top: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #2e7d32;
        }

        .message {
            margin-top: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<h2>Add New Product (Admin Panel)</h2>

<?php if (isset($success)) echo "<p class='message success'>{$success}</p>"; ?>
<?php if (isset($error)) echo "<p class='message error'>{$error}</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" required>

    <label>Description:</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Price (₹):</label>
    <input type="number" name="price" step="0.01" required>

    <label>Upload Image:</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Add Product</button>
</form>

</body>
</html>
