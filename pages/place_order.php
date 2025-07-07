<?php
session_start();
include '../includes/db.php'; // Adjust path if needed

// Sample: assume user is logged in
$user_id = $_SESSION['user_id'] ?? 1; // dummy user ID if not logged in

// Sample cart total (you can calculate dynamically)
$total_amount = 1000; // ₹1000

try {
    // 1. Insert order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $total_amount, 'pending']);
    $order_id = $conn->lastInsertId();

    // 2. Add order items from cart (you can customize this part)
    $cart_items = $_SESSION['cart'] ?? [
        ['product_id' => 1, 'quantity' => 2],
        ['product_id' => 2, 'quantity' => 1]
    ];

    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");

    foreach ($cart_items as $item) {
        $item_stmt->execute([$order_id, $item['product_id'], $item['quantity']]);
    }

    // 3. Save order_id in session
    $_SESSION['order_id'] = $order_id;

    // 4. Redirect to payment page
    header("Location: payment_gateway.php");
    exit();

} catch (PDOException $e) {
    echo "Order failed: " . $e->getMessage();
}
?>