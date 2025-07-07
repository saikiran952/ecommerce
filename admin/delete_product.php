<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../includes/db.php');

// Get product ID
$id = $_GET['id'] ?? 0;

// Optional: delete image file also
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product && !empty($product['image'])) {
    $image_path = '../images/' . $product['image'];
    if (file_exists($image_path)) {
        unlink($image_path); // Delete image file
    }
}

// Delete from DB
$delete = $conn->prepare("DELETE FROM products WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    header("Location: products.php");
    exit();
} else {
    echo "❌ Failed to delete product.";
}
?>
