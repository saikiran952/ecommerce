<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 20px; }
        .cart-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        h2 { margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="cart-box">
    <h2>🛒 Your Shopping Cart</h2>
    <table>
        <tr>
            <th>Product</th><th>Price (₹)</th><th>Quantity</th><th>Subtotal (₹)</th>
        </tr>
        <?php if (empty($cart)): ?>
            <tr><td colspan="4">Your cart is empty.</td></tr>
        <?php else: ?>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>₹<?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₹<?= $item['price'] * $item['quantity'] ?></td>
                </tr>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php if (!empty($cart)): ?>
        <h3>Total: ₹<?= $total ?></h3>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    <?php else: ?>
        <a href="index.php" class="btn">← Go Back to Home</a>
    <?php endif; ?>
</div>
</body>
</html>
