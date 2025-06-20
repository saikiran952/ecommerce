<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT o.id, o.order_date, o.total_amount
    FROM orders o
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>My Orders</h2>
    <?php if (empty($orders)) : ?>
        <p>You have no orders yet.</p>
    <?php else : ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                        <td><a href="receipt.php?order_id=<?= $order['id'] ?>">View Receipt</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif; ?>
    <p><a href="index.php">← Back to Shop</a></p>
</div>
</body>
</html>
