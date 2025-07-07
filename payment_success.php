<?php
session_start();
include('includes/db.php'); // ✅ Correct path from ecommerce/payment_success.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);

    // ✅ Update payment status to 'Paid'
    $stmt = $conn->prepare("UPDATE orders SET payment_status = 'Paid' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // ✅ Redirect to receipt
    header("Location: receipt.php?order_id=" . $order_id);
    exit();
} else {
    echo "❌ Invalid access.";
    exit();
}
