<?php
session_start();
include 'includes/db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        header {
            background-color: #ffffff; /* White background */
            padding: 20px;
            color: #2f855a; /* Green text */
            border-bottom: 1px solid #e0e0e0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: auto;
        }

        nav a, nav span {
            margin-left: 15px;
            color: #2f855a;
            text-decoration: none;
            font-weight: 500;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-button {
            background-color: #e53e3e;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-button:hover {
            background-color: #c53030;
        }

        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2 {
            text-align: center;
            color: #2f855a;
            margin-bottom: 30px;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .product {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .product h3 {
            margin-top: 0;
            color: #2d3748;
        }

        .product p {
            margin: 10px 0;
        }

        .product-image {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 8px;
            margin-top: 10px;
            background: #f0f0f0;
        }

        .add-to-cart-button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #2b6cb0;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .add-to-cart-button:hover {
            background-color: #2c5282;
        }

        .cart-icon {
            width: 22px;
            vertical-align: middle;
            margin-right: 5px;
        }

        footer {
            margin-top: 50px;
            padding: 20px;
            background-color: #2f855a;
            color: white;
            text-align: center;
        }

        @media (max-width: 600px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 10px;
            }

            .add-to-cart-button {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 style="margin: 0;">Welcome to Our Store</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Welcome, <?= htmlspecialchars($_SESSION['user_email']); ?></span>
                    <a href="order_history.php">My Orders</a>
                    <a href="cart.php">
                        <img src="images/cart-icon.png" alt="Cart" class="cart-icon">Cart
                    </a>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="logout" class="logout-button">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="pages/login.php">Login</a>
                    <a href="pages/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <main>
            <h2>Products</h2>
            <div class="product-list">
                <?php if (empty($products)) : ?>
                    <p>No products available.</p>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="product">
                            <h3><?= htmlspecialchars($product['name']); ?></h3>
                            <p>Price: $<?= number_format($product['price'], 2); ?></p>
                            <p><?= htmlspecialchars($product['description']); ?></p>

                            <?php if (!empty($product['image'])) : ?>
                                <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                            <?php else : ?>
                                <p><em>No image available</em></p>
                            <?php endif; ?>

                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
    </footer>
</body>
</html>
