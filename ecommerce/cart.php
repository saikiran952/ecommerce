<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php'; // ✅ Corrected path

$user_id = $_SESSION['user_id'];

// Handle Add to Cart with Quantity
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$new_quantity, $user_id, $product_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
}

// Handle Remove from Cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Handle Quantity Update
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$quantity, $user_id, $product_id]);
}

// Fetch cart items
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_cost = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            border: 2px solid #00bcd4;
        }

        h2 {
            text-align: center;
            color: #0097a7;
            margin-bottom: 25px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }

        .cart-item img {
            border-radius: 8px;
        }

        .item-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        .item-name {
            font-weight: bold;
            color: #00796b;
        }

        .item-price {
            color: #757575;
            margin-top: 4px;
        }

        .quantity {
            width: 50px;
            padding: 5px;
            border: 1px solid #00acc1;
            border-radius: 4px;
            text-align: center;
        }

        button {
            background: #ff7043;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #e64a19;
        }

        .total-cost {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
            color: #00695c;
        }

        .cart-actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .cart-actions a {
            background: #26c6da;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .cart-actions a:hover {
            background: #00acc1;
        }

        .empty-cart {
            text-align: center;
            color: #999;
            font-size: 1.1em;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Cart</h2>

        <?php if (empty($cart_items)): ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php else: ?>
            <?php
            $product_ids = array_column($cart_items, 'product_id');
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                $quantity = 0;
                foreach ($cart_items as $item) {
                    if ($item['product_id'] == $product['id']) {
                        $quantity = $item['quantity'];
                        break;
                    }
                }

                $total_cost += $product['price'] * $quantity;
                echo "<div class='cart-item'>
                        <img src='images/{$product['image']}' width='100' alt='{$product['name']}'>
                        <div class='item-details'>
                            <div class='item-name'>{$product['name']}</div>
                            <div class='item-price'>₹{$product['price']} x {$quantity}</div>
                        </div>
                        <div>
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='product_id' value='{$product['id']}'>
                                <input type='number' name='quantity' value='{$quantity}' class='quantity' min='1'>
                                <button type='submit' name='update_quantity'>Update</button>
                            </form>
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='product_id' value='{$product['id']}'>
                                <button type='submit' name='remove_from_cart'>Remove</button>
                            </form>
                        </div>
                    </div>";
            }
            ?>
            <div class="total-cost"><strong>Total: ₹<?= number_format($total_cost, 2) ?></strong></div>
        <?php endif; ?>

        <div class="cart-actions">
            <a href="index.php">← Back to Shop</a>
            <?php if (!empty($cart_items)): ?>
                <a href="checkout.php">Proceed to Checkout →</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
