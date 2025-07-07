# 🛍️ E-Commerce Website

A modern, responsive e-commerce platform built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. Showcase your products, allow users to register, search, filter, add to cart, and complete orders seamlessly.

## 🚀 Features

* **User Authentication**: Secure registration and login flow.
* **Product Listing**: Browse products with images, descriptions, and prices.
* **Search & Filter**: Live search by name/description, category and price filters with AJAX and autocomplete.
* **Shopping Cart**: Add, remove, and update quantities in the cart.
* **Checkout Flow**: Order summary and confirmation page.
* **Admin Panel (Future)**: Manage products and view orders.
* **Responsive Design**: Mobile-first layout with Swiper.js slider.
* **Environment Variables**: Securely manage API keys and database credentials via `.env`.

## 📦 Technologies Used

* **Backend**: PHP 8+, MySQL
* **Frontend**: HTML5, CSS3, JavaScript, Swiper.js
* **AJAX**: Live search & autocomplete
* **Dependency Management**: Composer (`vlucas/phpdotenv`)
* **Version Control**: Git & GitHub

## 🛠️ Installation & Setup

1. **Clone the repository**:

   ```bash
   git clone https://github.com/YOUR_USERNAME/ecommerce.git
   cd ecommerce
   ```

2. **Install dependencies** (for dotenv):

   ```bash
   composer install
   ```

3. **Create and configure the database**:

   * Create a MySQL database (e.g., `ecommerce`).
   * Import `database.sql` via phpMyAdmin or CLI.

4. **Configure environment variables**:

   * Copy `.env.example` to `.env`:

     ```bash
     cp .env.example .env
     ```
   * Open `.env` and set:

     ```dotenv
     DB_HOST=localhost
     DB_NAME=ecommerce
     DB_USER=root
     DB_PASS=your_password
     GOOGLE_CLIENT_ID=your_google_client_id
     GOOGLE_CLIENT_SECRET=your_google_client_secret
     ```

5. **Run the application**:

   * Place the project under your web server root (e.g., `htdocs/ecommerce`).
   * Start Apache & MySQL via XAMPP.
   * Visit: `http://localhost/ecommerce`

## 🔧 Usage

* Register a new user or login.
* Browse products and use the search bar to find items instantly.
* Use category and price filters to narrow down results.
* Add items to the cart and proceed to checkout.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/YourFeature`.
3. Commit your changes: `git commit -m 'Add your feature'`.
4. Push to the branch: `git push origin feature/YourFeature`.
5. Open a Pull Request.

## 📄 License

This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for details.

## 📬 Contact

* **Developer**: Sai Kiran
* **Email**: [sai524753@gmail.com](mailto:sai524753@gmail.com)
* **Phone**: +91 95739 26353

---

> Built with ❤️ by Sai Kiran.
