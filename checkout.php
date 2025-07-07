<?php
session_start();
include('includes/db.php');


// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Ensure cart is initialized
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Cart is empty'); location.href='cart.php';</script>";
    exit();
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle coupon
$discount = 0;
$coupon_code = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_coupon'])) {
    $coupon_code = $_POST['coupon'];
    if ($coupon_code === "SAVE50") {
        $discount = 50;
    } elseif ($coupon_code === "SAVE10") {
        $discount = 10;
    } else {
        $error = "Invalid coupon code!";
    }
    $total -= $discount;
}

// Handle final order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $coupon_code = $_POST['coupon'];
    $discount = intval($_POST['discount']);
    $final_total = $total;

    $items = "";
    foreach ($_SESSION['cart'] as $item) {
        $items .= "{$item['name']} (x{$item['quantity']}) - ₹{$item['price']} | ";
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_email, name, address, phone, total, order_items, coupon_code, discount, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssssissi", $_SESSION['user_email'], $name, $address, $phone, $final_total, $items, $coupon_code, $discount);
    $stmt->execute();

    $order_id = $conn->insert_id;
    $_SESSION['cart'] = [];
    $_SESSION['last_order_id'] = $order_id;

    header("Location: payment_gateway.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f0f0;
            padding: 40px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 { margin-bottom: 20px; }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .error { color: red; }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #555;
            background: #eee;
            padding: 10px 15px;
            border-radius: 6px;
        }
        .back-btn:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="cart.php" class="back-btn">← Back to Cart</a>
    <h2>🧾 Checkout</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <h4>Your Cart:</h4>
    <table>
        <tr>
            <th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₹<?= $item['price'] ?></td>
                <td>₹<?= $item['price'] * $item['quantity'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <form method="POST">
        <label>Coupon Code (optional):</label>
        <input type="text" name="coupon" placeholder="e.g. SAVE50" value="<?= htmlspecialchars($coupon_code) ?>">
        <button type="submit" name="apply_coupon" class="btn">Apply Coupon</button>
    </form>

    <p><strong>Total: ₹<?= $total ?></strong> <?= $discount ? "(Discount: ₹$discount)" : "" ?></p>

    <form method="POST">
        <input type="hidden" name="coupon" value="<?= htmlspecialchars($coupon_code) ?>">
        <input type="hidden" name="discount" value="<?= $discount ?>">

        <label>Full Name:</label>
        <input type="text" name="name" required>

        <label>Address:</label>
        <textarea name="address" required></textarea>

        <label>Phone Number:</label>
        <input type="text" name="phone" required>

        <button type="submit" name="place_order" class="btn">Place Order</button>
    </form>
</div>
</body>
</html>
