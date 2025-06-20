<?php
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <style>
        body {
            background-color: #f4fdf7;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .thank-you-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .thank-you-box h1 {
            color: #28a745;
            margin-bottom: 20px;
        }

        .order-info {
            font-size: 1.1em;
            margin-bottom: 25px;
        }

        .order-id {
            font-weight: bold;
            color: #155724;
        }

        .buttons a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #218838;
        }

        .success-icon {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <div class="thank-you-box">
        <div class="success-icon">✔️</div>
        <h1>Thank You for Your Order!</h1>
        <p class="order-info">Your order has been successfully placed.</p>
        <p class="order-info">Order ID: <span class="order-id"><?= htmlspecialchars($order_id) ?></span></p>
        <div class="buttons">
            <a href="order_history.php">View Order History</a>
            <a href="index.php">Continue Shopping →</a>
        </div>
    </div>
</body>
</html>
