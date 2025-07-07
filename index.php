<?php
session_start();
include(__DIR__ . '/includes/db.php');

// Search logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
if ($search) {
    $stmt = $conn->query("SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'");
} else {
    $stmt = $conn->query("SELECT * FROM products");
}

$products = [];
while ($row = $stmt->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Store</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #222;
            color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .header-container {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 24px;
        }

        nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ff9900;
        }

        .logout-button {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 7px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 20px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e60000;
        }

        .main-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .product {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .product h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .product p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .add-to-cart-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-button:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #222;
            color: #fff;
            margin-top: 40px;
        }

        /* Swiper styles */
        .swiper {
            padding: 30px 0;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <h1>Welcome to Our Store</h1>
        <nav>
            <a href="ecommerce/login.php">Login</a>
            <a href="ecommerce/register.php">Register</a>
            <a href="cart.php">
                <img src="images/trolley.png" alt="Cart" width="30">
                Cart
            </a>
            <a href="logout.php">
                <button class="logout-button">Logout</button>
            </a>
        </nav>
    </div>
</header>

<div class="main-container">
    <main>
        <h2>Products</h2>

        <!-- 🔍 Search Bar -->
        <form method="GET" action="" style="margin-bottom: 30px; text-align: center;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..." 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 6px;"
            />
            <button 
                type="submit" 
                style="padding: 10px 20px; background-color: #333; color: #fff; border: none; border-radius: 6px; cursor: pointer;"
            >
                Search
            </button>
        </form>

        <!-- Swiper Product Slider -->
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php if (empty($products)) : ?>
                    <p style="text-align: center;">No products found.</p>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="swiper-slide">
                            <div class="product">
                                <h3><?= htmlspecialchars($product['name']); ?></h3>
                                <p>Price: ₹<?= number_format($product['price'], 2); ?></p>
                                <p><?= htmlspecialchars($product['description']); ?></p>
                                <?php if (!empty($product['image'])) : ?>
                                    <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                                <?php endif; ?>
                                <form method="POST" action="pages/add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']); ?>">
                                    <input type="hidden" name="price" value="<?= $product['price']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </main>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
</footer>

<footer style="background-color: #2d4a3f; color: #f5f5f5; padding: 40px 20px; font-family: 'Segoe UI', sans-serif;">
    <div style="max-width: 1000px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
        <div style="flex: 1 1 200px; margin-bottom: 20px;">
            <h3 style="text-transform: lowercase;">shop</h3>
            <p><a href="index.php" style="color: #f5f5f5; text-decoration: none;">home</a></p>
            <p><a href="about.php" style="color: #f5f5f5; text-decoration: none;">about</a></p>
            <p><a href="store.php" style="color: #f5f5f5; text-decoration: none;">shop</a></p>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">blog</a></p>
        </div>

        <div style="flex: 1 1 200px; margin-bottom: 20px;">
            <h3 style="text-transform: lowercase;">policy</h3>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">terms & conditions</a></p>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">privacy policy</a></p>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">refund policy</a></p>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">shipping policy</a></p>
            <p><a href="#" style="color: #f5f5f5; text-decoration: none;">accessibility statement</a></p>
        </div>

        <div style="flex: 1 1 200px; margin-bottom: 20px;">
            <h3 style="text-transform: lowercase;">contact</h3>
            <p>rajendra nagar</p>
            <p>DHARMAVARAM</p>
            <p>9573926353</p>
            <p>sai524753@gmail.com</p>
        </div>
    </div>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            600: {
                slidesPerView: 2
            },
            900: {
                slidesPerView: 3
            },
            1200: {
                slidesPerView: 4
            }
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
</body>
</html>
