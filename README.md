# 💳 Top Up Website (PHP Native)

A responsive and user-friendly **Top Up Simulation Website** built using **PHP Native**. This site allows users to browse and search for digital top-up products like **games** and **e-wallets**, while providing an admin dashboard to manage product data via CRUD operations.

> ⚠️ **Note**: This website is a simulation only — no real top-up transactions are performed.

---

## 🧩 Features

- 🔍 **Product Search** — Quickly find top-up products using keywords.
- 🧮 **Category Filter** — Filter products by categories: **Game** and **E-Wallet**.
- 🛍️ **Clear Product Info** — Each product displays:
  - Name
  - Image
  - Price (nominal)
  - Top-up value to be received
- 🖼️ **Image Display** — Each product has a relevant image.
- 🧑‍💼 **Admin Dashboard** — Manage all product data with full **CRUD** functionality.
- 🌐 **Responsive Design** — Fully responsive for desktop and mobile views.
- 🛑 **Simulation-Only** — Real payments and top-ups are not processed.

---

## 🗂️ Pages Overview

### 🏠 Home Page
- Navigation bar for page links.
- Product listing section showing both **Game** and **E-Wallet** categories.
- Filter and search functionality.
- Product cards with essential details (image, price, top-up amount).

### ℹ️ About Us Page
- Photo/visual representation of the website.
- Description of the site's purpose, features, and goals.

### 📊 Admin Dashboard
- Restricted area for admin only.
- Admin can:
  - Create new product entries
  - Update or delete existing products
  - Assign products to categories
- Direct manipulation of database using forms and PHP logic.

---

## 🛠️ Tech Stack

- **Language**: PHP Native (No frameworks)
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL
- **Styling**: Custom CSS / Bootstrap
- **Icons**: FontAwesome or similar

---

## 📌 System Notes

- Each product belongs to a specific category: **Game** or **E-Wallet**.
- One admin account manages all product-related content.
- Product clarity includes both price and received value displayed to users.
- Fully mobile-responsive using modern layout techniques (Flexbox/Grid).

---

## 📷 Screenshots

<img width="781" height="384" alt="image" src="https://github.com/user-attachments/assets/29fc2c03-fd92-4176-bad2-8cb685df7fe9" />


---

## 🖥️ Installation

1. Clone or download this repository.
2. Import the `database.sql` file into your MySQL server.
3. Update `config.php` (or equivalent) with your DB credentials.
4. Place the project in your local server directory (e.g., `htdocs` if using XAMPP).
5. Access the website via `http://localhost/topup-website`.

---

## 🔐 Admin Access

- Ensure the admin panel is properly protected (authentication recommended).
- Admin can access `/admin/` or equivalent route to manage products.

