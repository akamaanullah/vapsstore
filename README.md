# The Perfect Vape - Production Ready E-Commerce Platform

This project is built using a custom, lightweight, and highly optimized Object-Oriented PHP (OOP) MVC framework. It is designed to handle thousands of products with a completely dynamic backend (Polymorphic Section Builder, Deep SEO Routing, and Complete Order Management).

## Environment Setup

The application behaves differently depending on the environment (Development vs. Production). All environment-specific configurations are handled via the `.env` file. **You should never hardcode credentials or URLs in the PHP files.**

### 1. Local Development (XAMPP/WAMP)
1. Clone the repository into your `htdocs` or `www` folder.
2. Copy `.env.example` and rename it to `.env`.
3. Open the `.env` file and set your local variables:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=
   DB_NAME=vapestore
   APP_ENV=development
   BASE_URL=http://localhost/vapestore/public
   ```

4. Import the `database.sql` file into your local phpMyAdmin to create the tables and indexes.

---

### 2. Production Deployment Guide
When deploying this application to a live server (cPanel, VPS, or Cloud), follow these exact steps:

#### A. Database Migration
1. Export your local database (or use the provided `database.sql`).
2. Create a new MySQL database and user on your production server.
3. Import the SQL file into the production database.

#### B. Environment Variables Update (CRITICAL)
On your live server, open the `.env` file and update the variables to match your production environment. **This is the only place you need to change URLs and passwords.**

```env
DB_HOST=localhost
DB_USER=your_production_db_user
DB_PASS=your_production_db_secure_password
DB_NAME=your_production_db_name

APP_ENV=production
BASE_URL=https://theperfectvape.com     <-- Update this to your real domain
```

#### C. Document Root Configuration (Security)
For maximum security, the core framework (`/app`, `/config`, `/views`) should **not** be publicly accessible.
* Configure your web server (Apache/Nginx) so that the document root points directly to the `/public` folder. 
* Do not point the domain to the root `vapestore/` directory. Point it to `vapestore/public/`.
* Once pointed to `/public`, your `BASE_URL` in the `.env` will simply be `https://theperfectvape.com` (without `/public` at the end).

#### D. File Permissions
Ensure the web server has read/write access to any upload directories (e.g., `/public/assets/uploads`) for product images.

## Architecture Highlights
* **Deep SEO Routing:** Managed by `app/Core/Router.php`, allowing infinite levels of URL nesting (e.g., `/collections/shop/vapes/disposables/...`).
* **Polymorphic Sections:** The UI is 100% dynamic. Content is built via the `ui_sections` and `ui_section_items` tables, avoiding static HTML lock-in.
* **Security:** Powered by PDO Prepared Statements to prevent SQL injection, and a front-controller pattern (`public/index.php`) to protect core files.

