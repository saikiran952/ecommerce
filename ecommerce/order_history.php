<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Fetch all orders for the user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Order History</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4fdf7;
            padding: 40px;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #28a745;
            margin-bottom: 10px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-bottom: 30px;
        }
        .back-link a {
            color: #28a745;
            font-weight: bold;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .order-box {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        .order-box strong {
            color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #e6f4ea;
            color: #155724;
        }
        a {
            color: #28a745;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Your Order History</h2>
    <div class="back-link">
        <a href="index.php">← Back to Home</a>
    </div>

    <?php if (empty($orders)): ?>
        <p style="text-align:center;">You have no orders yet.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-box">
                <div><strong>Order #<?= $order['id']; ?></strong> | Date: <?= $order['order_date']; ?> | Total: $<?= number_format($order['total_amount'], 2); ?> | 
                    <a href="receipt.php?order_id=<?= $order['id']; ?>">🧾 Receipt</a>
                </div>

                <?php
                $stmt = $conn->prepare("SELECT oi.*, p.name FROM order_items oi
                                        JOIN products p ON oi.product_id = p.id
                                        WHERE oi.order_id = ?");
                $stmt->execute([$order['id']]);
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']); ?></td>
                            <td>$<?= number_format($item['price'], 2); ?></td>
                            <td><?= $item['quantity']; ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
