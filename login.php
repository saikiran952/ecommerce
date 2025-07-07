<?php
session_start();
include('includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Ecommerce</title>
</head>
<body style="margin:0; font-family: 'Segoe UI', sans-serif; background: linear-gradient(to bottom right, #ff4d4d, #ffcc00, #33cc33, #3399ff, #9933ff); background-size: 400% 400%; animation: rainbow 15s ease infinite; color: #fff;">

<!-- Animate background -->
<style>
@keyframes rainbow {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}
</style>

<!-- 🔥 Navbar -->
<header style="background: rgba(0, 0, 0, 0.6); padding: 20px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-size: 24px; color: #ffffff; font-weight: bold;">🌈 ECOMMERCE</div>
    <nav>
        <a href="about.php" style="color: #fff; margin-right: 20px; text-decoration: none;">About Us</a>
        <a href="contact.php" style="color: #fff; text-decoration: none;">Contact</a>
    </nav>
</header>

<!-- Login Section -->
<section style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 40px;">
    <div style="background: rgba(0,0,0,0.7); padding: 40px; border-radius: 20px; width: 100%; max-width: 450px; box-shadow: 0 0 20px rgba(255,255,255,0.3);">
        <h1 style="margin-bottom: 10px; color: #fff;">Welcome Back 👋</h1>
        <p style="margin-bottom: 25px; color: #ddd;">Log in to your colorful world</p>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email Address" required
                style="width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 10px; border: 2px solid transparent; background: rgba(255,255,255,0.1); color: #fff; outline: none;" />
            <input type="password" name="password" placeholder="Password" required
                style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 10px; border: 2px solid transparent; background: rgba(255,255,255,0.1); color: #fff; outline: none;" />
            <button type="submit"
                style="width: 100%; padding: 12px; background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; text-shadow: 1px 1px 3px black;">🌟 Login</button>
        </form>
        <!-- 🌐 Social Login Buttons -->
<!-- 🌐 Social Login Buttons -->
<div style="margin-top: 25px; text-align: center;">
    <p style="color: #ccc; margin-bottom: 10px;">Or login with</p>

    <a href="google-login.php"
       style="display: inline-block; background: linear-gradient(to right,rgb(68, 22, 206),rgb(69, 11, 217)); color: white;
              padding: 12px 20px; margin: 5px; text-decoration: none; border-radius: 8px; font-weight: bold;
              box-shadow: 0 4px 10px rgba(0,0,0,0.2); transition: 0.3s;">
        🔐 Login with Google
    </a>

    
</div>



        <div class="message" style="margin-top: 20px;">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email']);
                $password = $_POST['password'];

                if (!empty($email) && !empty($password)) {
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 1) {
                        $user = $result->fetch_assoc();

                        if (password_verify($password, $user['password'])) {
                            $_SESSION['user_email'] = $user['email'];
                            header("Location: index.php");
                            exit();
                        } else {
                            echo "<p style='color: #ff6b6b;'>❌ Incorrect password.</p>";
                        }
                    } else {
                        echo "<p style='color: #ff6b6b;'>❌ Email not found.</p>";
                    }
                } else {
                    echo "<p style='color: #ff6b6b;'>❌ Please fill all fields.</p>";
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Register Link -->
<p style="text-align:center; font-size: 14px; color: #fff; margin-top:10px;">
    Don't have an account? <a href="register.php" style="color: #fff; text-decoration: underline;">Register now</a>
</p>

</body>
</html>
