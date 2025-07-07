<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<?php
include('../includes/db.php');
session_start(); // Optional, for admin login check in future

// Fetch all orders
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Orders</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <h2>📦 Admin: Order Management</h2>
    <table>
        <tr>
            <th>ID</th><th>Email</th><th>Name</th><th>Phone</th><th>Total</th><th>Coupon</th><th>Status</th><th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_email'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td>₹<?= $row['total'] ?></td>
                <td><?= $row['coupon_code'] ?></td>
                <td><?= $row['payment_status'] ?></td>
                <td><?= $row['order_date'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
