<?php
session_start();

// Simulating product data from form
$product_id = $_POST['product_id'];
$name = $_POST['name'];
$price = $_POST['price'];
$quantity = intval($_POST['quantity']); // ✅ Convert to integer

// Validate
if (!$product_id || !$name || !$price || $quantity <= 0) {
    die("Invalid product data");
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If item exists, update quantity
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'id' => $product_id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
    ];
}

// ✅ Redirect directly to cart page after adding
header("Location: ../cart.php"); // Use ../ if this file is inside /pages/
exit();
