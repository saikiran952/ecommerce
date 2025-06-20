<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Auth Modal</title>
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

    .input-group {
      display: flex;
      gap: 10px;
    }

    input[type="text"],
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

    .tab-buttons {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    .tab-buttons button {
      width: 45%;
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

    #strengthMessage {
      font-size: 12px;
      margin-top: 5px;
    }

    .social-login {
      text-align: center;
      margin-top: 20px;
    }

    .social-login button {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      margin-top: 10px;
      padding: 10px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
    }

    .google-btn {
      background: #fff;
      color: #444;
    }

    .google-btn:hover {
      background: #eee;
    }

    .facebook-btn {
      background: #3b5998;
      color: #fff;
    }

    .facebook-btn:hover {
      background: #334d84;
    }

    .social-login img {
      width: 16px;
      height: 16px;
    }
  </style>
</head>
<body>
  <!-- Background video -->
  <video autoplay muted loop id="bg-video">
    <source src="background.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Modal Form -->
  <div class="form-wrapper">
    <div class="tab-buttons">
      <button onclick="showForm('signup')">Sign Up</button>
      <button onclick="redirectToLogin()">Log In</button>
    </div>

    <!-- Sign Up Form -->
    <form id="signupForm">
      <h2>Create Account</h2>
      <div class="input-group">
        <input type="text" placeholder="First Name" required />
        <input type="text" placeholder="Last Name" required />
      </div>

      <input type="email" id="email" placeholder="Email" required />
      <input type="password" id="password" placeholder="Password" required />
      <div id="strengthMessage"></div>
      <input type="password" placeholder="Confirm Password" required />

      <button type="submit">Create Account</button>

      <!-- Social Login -->
      <div class="social-login">
        <p style="color: #aaa; margin-top: 20px;">Or sign up with</p>

        <button type="button" class="google-btn" onclick="location.href='google_login.php'">
          <img src="https://img.icons8.com/color/16/000000/google-logo.png" alt="Google" />
          Sign Up with Google
        </button>

        <button type="button" class="facebook-btn" onclick="location.href='facebook_login.php'">
          <img src="https://img.icons8.com/color/16/000000/facebook.png" alt="Facebook" />
          Sign Up with Facebook
        </button>
      </div>

      <div class="footer">
        By creating an account, you agree to our <a href="#">Terms & Service</a>
      </div>
    </form>
  </div>

  <!-- JavaScript -->
  <script>
    function showForm(form) {
      document.getElementById("signupForm").style.display = form === "signup" ? "block" : "none";
    }

    function redirectToLogin() {
      window.location.href = "login.php";
    }

    const passwordInput = document.getElementById("password");
    const strengthMessage = document.getElementById("strengthMessage");

    passwordInput.addEventListener("input", () => {
      const value = passwordInput.value;
      let strength = "Weak";
      let color = "red";

      if (value.length >= 8 && /[A-Z]/.test(value) && /\d/.test(value) && /\W/.test(value)) {
        strength = "Strong";
        color = "lime";
      } else if (value.length >= 6 && /[A-Z]/.test(value) && /\d/.test(value)) {
        strength = "Moderate";
        color = "orange";
      }

      strengthMessage.textContent = `Strength: ${strength}`;
      strengthMessage.style.color = color;
    });
  </script>
</body>
</html>
