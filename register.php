<?php
session_start();
include('includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | ECOMMERCE</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styles for layout */
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f0f0f0;
        }
        .navbar {
            background: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar nav a {
            margin-left: 20px;
            text-decoration: none;
            color: black;
        }
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container h1 {
            margin-bottom: 10px;
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .message {
            margin-top: 15px;
            color: red;
        }
        .success { color: green; }
        img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<header class="navbar">
    <div class="logo">ECOMMERCE</div>
    <nav>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="register.php" style="background: orange; color: white; padding: 10px 15px; border-radius: 6px;">Register</a>
    </nav>
</header>

<!-- ✅ Registration Form -->
<section class="registration-section">
    <div class="form-container">
        <h1>Create Your Account</h1>
        <p>Start your journey with us. It’s quick and easy!</p>

        <form method="POST" action="register.php">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>

        <div class="message">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if (!empty($email) && !empty($password)) {
                    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $check->bind_param("s", $email);
                    $check->execute();
                    $result = $check->get_result();

                    if ($result->num_rows > 0) {
                        echo "<p class='error'>❌ Email already registered!</p>";
                    } else {
                        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                        $stmt->bind_param("ss", $email, $hashedPassword);

                        if ($stmt->execute()) {
                            echo "<p class='success'>✅ Registration successful! Redirecting to login...</p>";
                            header("refresh:2;url=login.php");
                            exit();
                        } else {
                            echo "<p class='error'>❌ Registration failed: " . $stmt->error . "</p>";
                        }
                    }
                } else {
                    echo "<p class='error'>❌ Please fill all fields.</p>";
                }
            }
            ?>
        </div>
    </div>

    <!-- Illustration -->
    <img src="https://via.placeholder.com/400x300?text=Ecommerce+Illustration" alt="Ecommerce Image">
</section>

<!-- Login link -->
<p class="login-link">
    Already have an account? <a href="login.php">Login here</a>
</p>

</body>
</html>
