<?php
session_start();

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// If logged in, redirect to products list
header('Location: products.php');
exit();
?>
