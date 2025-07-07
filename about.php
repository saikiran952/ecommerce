<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$googleClientId = $_ENV['GOOGLE_CLIENT_ID'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>About Us - Ecommerce</title>
</head>
<body style="font-family: 'Segoe UI', sans-serif; background: #e8f5e9; margin: 0; padding: 40px;">

<div style="
    max-width: 900px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
    border-left: 6px solid #007bff;
">

    <h1 style="color: #007bff; margin-bottom: 20px;">🛍️ About Our Ecommerce Site</h1>

    <p style="font-size: 16px; line-height: 1.8; color: #333;">
        Welcome to <strong style="color: #28a745;">ECOMMERCE</strong> — your one-stop shop for quality products at the best prices.
    </p>

    <p style="font-size: 16px; line-height: 1.8; color: #333;">
        We’re passionate about delivering convenience and excellence to every customer. Our goal is to make shopping smooth, affordable, and fast — all from the comfort of your home.
    </p>

    <p style="font-size: 16px; line-height: 1.8; color: #333;">
        Whether you’re looking for fashion, electronics, home appliances, or gifts, we’ve got something for everyone. Our platform is secure, user-friendly, and backed by 24/7 support.
    </p>

    <p style="font-size: 16px; color: #007bff; font-weight: bold;">Why choose us?</p>
    <ul style="color: #28a745; font-size: 16px; line-height: 1.6;">
        <li>✅ Affordable pricing</li>
        <li>🚚 Fast shipping</li>
        <li>🔒 Secure checkout</li>
        <li>💬 Customer-first support</li>
    </ul>

    <p style="font-size: 16px; line-height: 1.8; color: #333;">
        Thank you for choosing us. Happy shopping!
    </p>

    <hr style="margin: 30px 0;">

    
</div>

</body>
</html>
