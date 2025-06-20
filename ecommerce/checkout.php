<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

include 'includes/db.php';
$user_id = $_SESSION['user_id'];

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
    <title>Checkout</title>
    <style>
        body {
            background-color: #e3f2fd;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            border: 2px solid #2196f3;
        }

        h2 {
            color: #0d47a1;
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #90caf9;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        td {
            background-color: #e3f2fd;
        }

        .total-row td {
            font-weight: bold;
            background-color: #ffebee;
            color: #b71c1c;
            border-color: #ef9a9a;
        }

        button {
            background-color: #d32f2f;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b71c1c;
        }

        a {
            text-decoration: none;
            color: #0d47a1;
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>

    <?php if (empty($cart_items)) : ?>
        <p>Your cart is empty. <a href="index.php">← Continue Shopping</a></p>
    <?php else : ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $product_ids = array_column($cart_items, 'product_id');
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                foreach ($cart_items as $item) {
                    if ($item['product_id'] == $product['id']) {
                        $quantity = $item['quantity'];
                        $subtotal = $quantity * $product['price'];
                        $total_cost += $subtotal;

                        echo "<tr>
                                <td>" . htmlspecialchars($product['name']) . "</td>
                                <td>$" . number_format($product['price'], 2) . "</td>
                                <td>{$quantity}</td>
                                <td>$" . number_format($subtotal, 2) . "</td>
                              </tr>";
                        break;
                    }
                }
            }
            ?>
            <tr class="total-row">
                <td colspan="3" align="right">Total:</td>
                <td>$<?= number_format($total_cost, 2); ?></td>
            </tr>
        </table>

        <form method="POST" action="place_order.php">
            <button type="submit" name="place_order">Place Order</button>
        </form>
    <?php endif; ?>

    <a href="cart.php">← Back to Cart</a>
</div>
</body>
</html>
