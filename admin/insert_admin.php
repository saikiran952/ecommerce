<?php
include('../includes/db.php');

$username = 'admin';
$password = password_hash('kiran12345', PASSWORD_DEFAULT); // Hashed password

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "✅ Admin created successfully!";
} else {
    echo "❌ Failed to create admin!";
}
?>
