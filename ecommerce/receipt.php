<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

include 'includes/db.php';

if (!isset($_GET['order_id'])) {
    echo "Order ID not provided.";
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit();
}

// Fetch order items
$stmt = $conn->prepare("SELECT oi.*, p.name FROM order_items oi 
                        JOIN products p ON oi.product_id = p.id 
                        WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - Order #<?= $order_id; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .receipt-container {
            width: 80%;
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ccc;
        }
        h2, h3 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h2>Order Receipt</h2>
    <h3>Order #<?= $order['id']; ?></h3>
    <p><strong>Order Date:</strong> <?= $order['order_date']; ?></p>
    <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2); ?></p>

    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td>$<?= number_format($item['price'], 2); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">Total:</td>
            <td><strong>$<?= number_format($order['total_amount'], 2); ?></strong></td>
        </tr>
    </table>

    <button class="print-button" onclick="window.print()">🖨️ Print Receipt</button>
</div>

</body>
</html>
