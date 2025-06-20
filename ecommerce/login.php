<?php
session_start();
include 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #000;
      color: white;
      overflow: hidden;
    }

    video#bg-video {
      position: fixed;
      right: 0;
      bottom: 0;
      min-width: 100%;
      min-height: 100%;
      z-index: -1;
      object-fit: cover;
    }

    .form-wrapper {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.55);
      border-radius: 20px;
      padding: 40px;
      width: 90%;
      max-width: 400px;
      backdrop-filter: blur(15px);
      box-shadow: 0 0 60px rgba(0, 255, 0, 0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 26px;
      color: #00ffcc;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 14px;
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.2);
    }

    button {
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(to right, #00ffcc, #009966);
      color: #000;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      width: 100%;
    }

    button:hover {
      background: linear-gradient(to right, #00ffcc, #00cc99);
    }

    .error {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-top: 10px;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      margin-top: 20px;
      color: #ccc;
    }

    .footer a {
      color: #00ffcc;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Background video -->
  <video autoplay muted loop id="bg-video">
    <source src="background.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Login Form -->
  <div class="form-wrapper">
    <h2>Login</h2>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Log In</button>
    </form>

    <?php if ($error_message): ?>
      <div class="error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <div class="footer">
      Don't have an account? <a href="register.html">Sign up here</a>
    </div>
  </div>
</body>
</html>
