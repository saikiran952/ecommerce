<?php
session_start();
include('includes/db.php');


// Validate and sanitize order_id
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "❌ Invalid order ID.";
    exit();
}

$order_id = intval($_GET['order_id']);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if order exists
if ($result->num_rows === 0) {
    echo "❌ Order not found!";
    exit();
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f0f0;
            padding: 40px;
        }
        .receipt {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: green;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="receipt">
    <h2>✅ Thank you for your order!</h2>

    <p><strong>Order ID:</strong> <?= $order['id'] ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['user_email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
    <p><strong>Items:</strong> <?= htmlspecialchars($order['order_items']) ?></p>
    <p><strong>Total:</strong> ₹<?= $order['total'] ?></p>
    <p><strong>Discount:</strong> ₹<?= $order['discount'] ?></p>
    <p><strong>Status:</strong> <?= $order['payment_status'] ?></p>
    <p><strong>Date:</strong> <?= $order['order_date'] ?></p>

    <!-- 🔙 Back Button -->
    <a href="/ecommerce/index.php">Back to Home</a>
</div>
</body>
</html>
