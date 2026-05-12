<p align="center">
  <h1 align="center">🛒 The Perfect Vape — E-Commerce Platform</h1>
  <p align="center">A production-ready, high-performance e-commerce platform built with a custom PHP MVC framework. Designed for scalability, SEO excellence, and a premium admin experience.</p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.0+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge" alt="License">
  <img src="https://img.shields.io/badge/Status-Production--Ready-brightgreen?style=for-the-badge" alt="Status">
</p>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Tech Stack](#-tech-stack)
- [Features](#-features)
- [Project Structure](#-project-structure)
- [Installation & Setup](#-installation--setup)
- [Production Deployment](#-production-deployment)
- [Architecture](#-architecture)
- [Security](#-security)
- [Author & Contact](#-author--contact)
- [License](#-license)

---

## 🔍 Overview

**The Perfect Vape** is a full-featured e-commerce platform purpose-built for online vape retail. It runs on a **custom, lightweight, object-oriented PHP MVC framework** — no Laravel, no Symfony, no bloat. Every line is hand-crafted for performance, security, and maintainability.

The platform features a **Shopify-inspired admin panel** with a drag-and-drop section builder, dynamic navigation system, media gallery, coupon management, review system, and deep SEO routing — all backed by a clean, scalable architecture.

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.0+ (Custom OOP MVC Framework) |
| **Database** | MySQL 8.0+ with PDO (Prepared Statements) |
| **Frontend** | HTML5, CSS3 (Vanilla), JavaScript (ES6+) |
| **Icons** | Lucide Icons |
| **Rich Text** | Quill.js Editor |
| **Server** | Apache with `mod_rewrite` |
| **Session** | PHP Native Sessions (Hardened) |
| **Image Processing** | GD Library (WebP conversion, Thumbnails) |

---

## ✨ Features

### Storefront
- 🛍️ **Dynamic Product Catalog** — Filterable by collection, brand, price range with AJAX search
- 🔗 **Deep SEO Routing** — Database-driven URLs with 301 canonical redirects
- 📱 **Fully Responsive** — Mobile-first design with mega menu navigation
- ⭐ **Product Reviews** — Guest review submission with honeypot anti-spam
- 💖 **Wishlist** — Client-side wishlist management
- 🛒 **Shopping Cart** — Dynamic cart with variant support
- 📰 **Blog System** — Category-based blog with related posts
- 📄 **Dynamic Pages** — CMS-powered pages with section builder
- 🏷️ **Coupon System** — Percentage and fixed-amount discounts
- 🔍 **Global Search** — Real-time product search

### Admin Panel
- 📊 **Dashboard** — Sales overview and quick stats
- 📦 **Product Management** — Multi-variant products, image gallery, SEO fields, CSV export
- 🗂️ **Collection Management** — Hierarchical categories with parent-child relationships
- 🏷️ **Brand Management** — Brand catalog with logo support
- 🧩 **Section Builder** — Polymorphic drag-and-drop content builder for any page
- 🧭 **Dynamic Navigation** — Entity-linked menus with auto URL resolution (slug changes auto-update)
- 🖼️ **Media Gallery** — Centralized asset management with WebP optimization
- 📝 **Blog Management** — Rich text editor, categories, featured images
- 🎟️ **Coupon Management** — Full CRUD with date ranges and usage limits
- 👥 **Customer Management** — Customer list and order history
- 📋 **Order Management** — Order tracking and detail views
- ↩️ **Refund Management** — Refund request handling
- ⚙️ **Settings** — Store name, logo, SEO defaults, social links
- 🎨 **Theme Settings** — Visual customization from admin

### Technical
- 🔒 **CSRF Protection** — Token-based on all POST requests
- 🛡️ **Security Headers** — CSP, HSTS, X-Frame-Options, nosniff
- 📁 **PSR-4 Autoloading** — Clean namespace-based class loading
- 🔑 **Session Hardening** — HttpOnly, SameSite=Strict, Secure cookies
- 📝 **Error Logging** — File-based logging with stack traces
- 🎯 **Professional Error Pages** — Branded 403, 404, 500 pages
- ⚡ **Request-Level Caching** — Navigation and settings cached per request
- 🗄️ **Database Singleton** — Single PDO connection per request

---

## 📁 Project Structure

```
vapestore/
├── app/
│   ├── Controllers/
│   │   ├── Admin/           # Admin panel controllers (19 files)
│   │   │   ├── AdminController.php    # Base class (auth + CSRF middleware)
│   │   │   ├── AuthController.php     # Login/logout with session fixation protection
│   │   │   ├── ProductController.php  # Full CRUD + CSV export
│   │   │   ├── CollectionController.php
│   │   │   ├── BrandController.php
│   │   │   ├── MenuController.php     # Dynamic navigation builder
│   │   │   ├── PageController.php
│   │   │   ├── BlogController.php
│   │   │   ├── MediaController.php    # Centralized media gallery
│   │   │   ├── CouponController.php
│   │   │   ├── ThemeController.php
│   │   │   ├── SettingController.php
│   │   │   └── ...
│   │   └── Front/           # Storefront controllers
│   │       ├── HomeController.php
│   │       ├── CollectionController.php  # Filtering + AJAX API
│   │       ├── ProductController.php     # Detail page + reviews
│   │       ├── PageController.php
│   │       └── BlogController.php
│   ├── Core/                # Framework core
│   │   ├── Router.php       # Static + Dynamic SEO routing with 301 canonicalization
│   │   ├── Controller.php   # Base controller (views, CSRF, JSON, redirects)
│   │   ├── Model.php        # Base model (find, all, delete, paginate, count, query)
│   │   ├── Database.php     # PDO Singleton with utf8mb4
│   │   ├── Session.php      # Hardened sessions with CSRF tokens
│   │   ├── ErrorHandler.php # Global exception/error/fatal handler
│   │   └── DotEnv.php       # Environment variable loader
│   ├── Helpers/
│   │   ├── NavigationHelper.php   # Dynamic menu rendering with entity URL resolution
│   │   ├── UIHelper.php           # Section builder data fetcher with caching
│   │   ├── ProductHelper.php      # Product card HTML renderer
│   │   ├── PaginationHelper.php   # Clean URL pagination
│   │   └── ImageHelper.php        # WebP conversion and thumbnails
│   ├── Models/              # Database models (11 files)
│   │   ├── Product.php      # Complex model (variants, images, filtering, reviews)
│   │   ├── Collection.php   # Hierarchical with recursive child resolution
│   │   ├── MenuItem.php     # Dynamic URL resolver for navigation
│   │   ├── UISection.php    # Polymorphic section builder
│   │   └── ...
│   └── Traits/
│       └── Sluggable.php    # URL slug generation trait
├── config/
│   └── config.php           # App constants (loaded from .env)
├── public/                  # Web root (Apache document root)
│   ├── index.php            # Front controller (autoloader + 60+ routes)
│   ├── .htaccess            # URL rewriting + security headers
│   ├── assets/              # CSS, images, uploads
│   ├── js/                  # Frontend JavaScript
│   └── admin_assets/        # Admin-specific CSS and JS
├── views/
│   ├── front/               # Storefront views
│   │   ├── partials/        # Header, footer, components
│   │   ├── home.php
│   │   ├── collection.php
│   │   ├── product-detail.php
│   │   ├── error.php        # Branded 403/404/500 page
│   │   └── ...
│   └── admin/               # Admin panel views
│       ├── partials/        # Sidebar, header, modals
│       └── ...
├── storage/
│   └── logs/                # Application error logs
├── .env                     # Environment config (not in git)
├── .env.example             # Environment template
├── .gitignore
├── .htaccess                # Root redirect to /public
├── LICENSE
├── CHANGELOG.md
└── README.md
```

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Apache with `mod_rewrite` enabled
- GD Library (for image processing)

### Local Development (XAMPP/WAMP)

1. **Clone** the repository into your `htdocs` directory:
   ```bash
   git clone https://github.com/your-repo/vapestore.git
   cd vapestore
   ```

2. **Configure environment** — copy and edit the `.env` file:
   ```bash
   cp .env.example .env
   ```
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=
   DB_NAME=vapestore

   APP_NAME="The Perfect Vape"
   APP_ENV=development
   APP_DEBUG=true
   # BASE_URL is auto-detected in development
   ```

3. **Create database** — import the schema into phpMyAdmin or MySQL CLI:
   ```bash
   mysql -u root -p vapestore < database.sql
   ```

4. **Create admin user** — insert into the `users` table:
   ```sql
   INSERT INTO users (first_name, last_name, email, password_hash, role)
   VALUES ('Admin', 'User', 'admin@example.com', '$2y$10$...', 'admin');
   ```
   > Use `password_hash('your_password', PASSWORD_DEFAULT)` in PHP to generate the hash.

5. **Access the application**:
   - Storefront: `http://localhost/vapestore`
   - Admin Panel: `http://localhost/vapestore/admin`

---

## 🌐 Production Deployment

### A. Server Requirements
- PHP 8.0+ with extensions: `pdo_mysql`, `gd`, `mbstring`, `openssl`
- MySQL 8.0+
- Apache 2.4+ with `mod_rewrite` and `mod_headers`
- SSL Certificate (HTTPS required for HSTS)

### B. Environment Configuration

Update `.env` for production:
```env
DB_HOST=localhost
DB_USER=your_db_user
DB_PASS=your_secure_password
DB_NAME=your_db_name

APP_NAME="The Perfect Vape"
APP_ENV=production
APP_DEBUG=false
BASE_URL=https://yourdomain.com
```

> ⚠️ **Critical**: Always set `APP_DEBUG=false` in production. This hides stack traces from end users.

### C. Document Root (Security)

Configure your web server so the **document root points to `/public`**, not the project root:

```
yourdomain.com → /home/user/vapestore/public/
```

This keeps `/app`, `/config`, `/views`, and `.env` completely inaccessible from the web.

### D. File Permissions

```bash
chmod 755 -R /path/to/vapestore
chmod 775 -R /path/to/vapestore/public/uploads
chmod 775 -R /path/to/vapestore/storage/logs
```

### E. Database Optimization

For large catalogs (1000+ products), ensure these indexes exist:
```sql
CREATE INDEX idx_products_custom_url ON products(custom_url);
CREATE INDEX idx_collections_custom_url ON collections(custom_url_path);
CREATE INDEX idx_pages_custom_url ON pages(custom_url_path);
CREATE INDEX idx_blog_custom_url ON blog_posts(custom_url_path);
```

---

## 🏗 Architecture

### MVC Pattern
```
Request → public/index.php → Router → Controller → Model → View → Response
```

### Dynamic SEO Routing
The router operates in two phases:
1. **Static Routes** — Pre-defined paths (e.g., `/admin/products`, `/checkout`)
2. **Dynamic SEO Fallback** — Queries the database across 4 entity tables (pages, collections, products, blogs) using a UNION query. If a match is found, it routes to the appropriate controller with automatic **301 canonical redirects** to prevent duplicate content.

### Entity-Linked Navigation
Menu items store an `entity_id` linking them to database records. When a page, collection, or brand slug changes, the navigation URLs **automatically update** — no manual menu editing required.

### Polymorphic Section Builder
UI sections are stored in `ui_sections` and `ui_section_items` tables with `entity_type` and `entity_id` columns. This allows attaching custom content blocks (hero banners, product grids, testimonials, etc.) to any entity — homepage, collection pages, product pages, or blog posts.

---

## 🔒 Security

| Feature | Implementation |
|---|---|
| **SQL Injection** | PDO Prepared Statements with `EMULATE_PREPARES=false` |
| **CSRF** | Cryptographic tokens (`random_bytes(32)`) with `hash_equals()` validation |
| **XSS** | `htmlspecialchars()` on all user-facing output |
| **Session Fixation** | `session_regenerate_id(true)` on login |
| **Session Hijacking** | `HttpOnly`, `SameSite=Strict`, `Secure` (on HTTPS) cookies |
| **Clickjacking** | `X-Frame-Options: SAMEORIGIN` |
| **MIME Sniffing** | `X-Content-Type-Options: nosniff` |
| **Content Security Policy** | Strict CSP with whitelisted CDNs |
| **Transport Security** | `Strict-Transport-Security` with 1-year max-age |
| **Admin Auth** | Middleware pattern — all admin controllers extend `AdminController` |
| **Password Storage** | `password_hash()` with `PASSWORD_DEFAULT` (bcrypt) |
| **Error Exposure** | Debug info hidden in production via `APP_DEBUG` flag |

---

## 👤 Author & Contact

**Developed by Amaan Ullah**

| | |
|---|---|
| 🌐 Website | [amaanullah.com](https://amaanullah.com) |
| 📧 Email | [info@amaanullah.com](mailto:info@amaanullah.com) |

For detailed information, custom development inquiries, or enterprise licensing, please visit [amaanullah.com](https://amaanullah.com) or reach out at [info@amaanullah.com](mailto:info@amaanullah.com).

---

## 📄 License

This project is **proprietary software**. All rights reserved.  
See the [LICENSE](LICENSE) file for full terms.

Unauthorized copying, modification, distribution, or use of this software is strictly prohibited without prior written consent from the author.

---

<p align="center">
  <sub>Built with ❤️ by <a href="https://amaanullah.com">Amaan Ullah</a></sub>
</p>
