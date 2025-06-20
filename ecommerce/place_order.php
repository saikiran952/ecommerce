<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Get cart items
$stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
$stmt->execute([$user_id, $total]);
$order_id = $conn->lastInsertId();

// Insert into order_items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cart_items as $item) {
    $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
}

// Clear cart
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);

// Redirect to thank you page
header("Location: thank_you.php?order_id=" . $order_id);
exit();
