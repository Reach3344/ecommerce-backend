# Ecommerce Backend

A Laravel 12 ecommerce backend with a Sanctum-powered API for customers and a Blade-based admin panel for managing catalog data, orders, and users.

## Features

- Customer registration, login, logout, and profile management
- Product catalog with categories, product details, and reviews
- Wishlist and cart endpoints for authenticated users
- Checkout flow with order history and order detail endpoints
- Admin dashboard with category, product, order, and user management
- Product image uploads using Laravel public storage
- Database seed data for an admin account and sample products

## Tech Stack

- PHP 8.2+
- Laravel 12
- Laravel Sanctum
- Vite
- Tailwind CSS
- PHPUnit

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js and npm
- A supported database such as MySQL, MariaDB, PostgreSQL, or SQLite

## Setup

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Create the environment file and application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database connection in `.env`.

5. Run migrations and seed the database:

   ```bash
   php artisan migrate --seed
   ```

6. Link public storage for uploaded product images:

   ```bash
   php artisan storage:link
   ```

7. Configure Telegram order notifications in `.env`:

   ```env
   TELEGRAM_NOTIFICATIONS_ENABLED=true
   TELEGRAM_BOT_TOKEN=your_bot_token_from_botfather
   TELEGRAM_CHAT_ID=your_telegram_chat_id
   ```

   Create a bot with Telegram BotFather, send your bot one message from the Telegram account or chat that should receive order alerts, then use Telegram `getUpdates` to find the `chat.id`. A `t.me` profile link such as `https://t.me/reach_db_rtk` is not enough for direct bot messages unless you use the actual chat id.

8. Start the app:

   ```bash
   composer run dev
   ```

The app will be available through the Laravel development server, usually at `http://127.0.0.1:8000`.

## Admin Login

The database seeder creates an admin user:

```text
Email: admin@ecommerce.com
Password: password123
```

Admin routes are available under `/admin` after login.

## API Routes

Public endpoints:

```text
GET    /api/categories
GET    /api/products
GET    /api/products/{product}
GET    /api/products/{product}/reviews
POST   /api/register
POST   /api/login
```

Authenticated endpoints require a Sanctum bearer token:

```text
POST   /api/logout
GET    /api/profile
PUT    /api/profile
PUT    /api/profile/password
GET    /api/wishlist
POST   /api/wishlist/{product}
DELETE /api/wishlist/{product}
GET    /api/cart
POST   /api/cart
PUT    /api/cart/{cartItem}
DELETE /api/cart/{cartItem}
POST   /api/checkout
GET    /api/orders
GET    /api/orders/{order}
POST   /api/products/{product}/reviews
```

## Useful Commands

Run tests:

```bash
composer test
```

Run the Laravel server only:

```bash
php artisan serve
```

Run Vite only:

```bash
npm run dev
```

Build frontend assets:

```bash
npm run build
```

Format PHP code:

```bash
./vendor/bin/pint
```

## Project Structure

```text
app/Http/Controllers/Api  Customer-facing API controllers
app/Http/Controllers      Admin and web controllers
app/Models                Eloquent models
database/migrations       Database schema
database/seeders          Seed data
resources/views           Blade admin views
routes/api.php            API routes
routes/web.php            Web and admin routes
```
