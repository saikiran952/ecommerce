<?php
// ✅ Start session only if not started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../includes/db.php');

// ✅ Fetch all products
$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Products</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background: #f4f4f4;
        }
        h2 {
            color: #2e7d32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #2e7d32;
            color: white;
        }
        img {
            width: 60px;
            height: auto;
        }
        a.btn {
            padding: 6px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        a.btn:hover {
            background: #0056b3;
        }
        .btn-delete {
            background: #dc3545;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-link {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>Admin - All Products</h2>
    <a href="logout.php" class="logout-link">Logout</a>
</div>

<a href="add_product.php" class="btn" style="margin-top: 10px; display:inline-block;">+ Add New Product</a>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price (₹)</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td>
            <?php if (!empty($product['image'])): ?>
                <img src="../images/<?= htmlspecialchars($product['image']) ?>" alt="">
            <?php else: ?>
                No Image
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['description']) ?></td>
        <td><?= number_format($product['price'], 2) ?></td>
        <td>
            <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn">Edit</a>
            <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
