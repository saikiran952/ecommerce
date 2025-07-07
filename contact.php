<!-- ecommerce/contact.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | ECOMMERCE</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        h2 {
            color: #00ffcc;
            margin-bottom: 15px;
        }
        p {
            margin-bottom: 20px;
            color: #ccc;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            background: #2c2c2c;
            color: #fff;
            border: 1px solid #444;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        input::placeholder, textarea::placeholder {
            color: #aaa;
        }
        button {
            background: #00ffcc;
            color: #000;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #00e6b3;
        }
        .nav {
            margin-bottom: 30px;
            text-align: center;
        }
        .nav a {
            margin: 0 15px;
            color: #00ffcc;
            text-decoration: none;
            font-weight: bold;
        }
        .nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="nav">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
</div>

<div class="container">
    <h2>📞 Contact Us</h2>
    <p>Have a question or feedback? We'd love to hear from you.</p>

    <form method="POST" action="#">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
