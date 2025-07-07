<?php
session_start();

// Check if order ID exists in session
if (!isset($_SESSION['last_order_id'])) {
    echo "❌ No order ID found. Please place an order first.";
    exit();
}

// You can fetch the order details from DB if needed
$order_id = $_SESSION['last_order_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pay via UPI</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .payment-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 15px;
        }
        .qr {
            width: 200px;
            height: 200px;
            margin: 15px auto;
            border: 1px solid #ccc;
            padding: 10px;
            background: white;
        }
        .upi-id {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }
        .btn {
            margin-top: 25px;
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="payment-box">
    <h2>Scan to Pay</h2>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=demo@upi&pn=DemoShop&am=99.00" alt="UPI QR Code" class="qr">
    <p class="upi-id">Or pay manually: <strong>demo@upi</strong></p>

    <!-- Simulate payment done -->
    <form method="POST" action="payment_success.php">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <button class="btn" type="submit">✅ I Have Paid</button>
    </form>
</div>
</body>
</html>
