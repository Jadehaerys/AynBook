# <3 AynBook

> A contact management web app named after my girlfriend, Ayn. Built for a practical interview for a dev position. Simple, secure, and gets the job done.

I'm Jade, 22, and this is a full-stack PHP app built with **Laravel 11** and **Bootstrap 5**. It covers secure user authentication, a personal contact dashboard, full CRUD operations — plus bonus features: CSRF protection, password reset via email, and role-based access control.

---

## Demo accounts (pre-seeded)

Run `php artisan db:seed` and these are ready to go:

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@aynbook.com | Admin1234! |
| **Regular user** | user@aynbook.com | User1234! |

> The regular user account already has 5 sample contact records seeded in.

---

## Deliverables

| Deliverable | Location |
|---|---|
| Complete PHP source code | `app/Http/Controllers/` · `app/Models/` · `app/Http/Middleware/` |
| SQL database file | `database/crud_app.sql` |
| README | This file |
| All routes | `routes/web.php` |
| Blade views | `resources/views/` |
| GitHub repo | https://github.com/Jadehaerys/AynBook |

### Requirements checklist

- [x] User registration with validation
- [x] Secure login and logout
- [x] Session management (30-min idle timeout, HTTP-only cookies)
- [x] Full CRUD for contact records
- [x] Ownership enforcement — you can only touch your own records
- [x] Password hashing (bcrypt, cost 12)
- [x] XSS prevention (Blade auto-escape + `e()`)
- [x] SQL injection prevention (Eloquent / PDO prepared statements)
- [x] CSRF protection on all forms
- [x] Client-side + server-side validation
- [x] User-friendly flash messages

### Bonus features

- [x] **Bonus A — CSRF** → `@csrf` on every form, verified automatically by Laravel middleware
- [x] **Bonus B — Password reset** → `app/Http/Controllers/PasswordResetController.php` · `resources/views/auth/forgot-password.blade.php` · `resources/views/auth/reset-password.blade.php`
- [x] **Bonus C — RBAC** → `app/Http/Middleware/AdminMiddleware.php` · `app/Http/Controllers/AdminController.php` · `resources/views/admin/index.blade.php`

---

## What it does

- Register and log in with your own account
- Manage a personal contact list (name, email, phone, address, notes)
- Add, edit, and delete records — only you can see your own
- Session auto-expires after 30 minutes of inactivity
- **Forgot password?** Reset link is sent by email (logs to `storage/logs/laravel.log` locally — no SMTP needed)
- **Admin panel** — admins can view all users, promote/demote roles, or remove accounts
- Pink/nude UI built with Bootstrap 5 and inline SVG icons

---

## Tech stack

| Layer | What I used |
|---|---|
| Language | PHP 8.2 |
| Framework | Laravel 11 |
| Database | MySQL via XAMPP |
| Frontend | Bootstrap 5.3 (CDN) + inline SVGs |
| Auth | Laravel session-based auth |
| Mail (password reset) | Log driver — reset link written to `storage/logs/laravel.log` |

---

## Security features

- **CSRF protection** — every form has a `@csrf` token, auto-validated by Laravel
- **XSS prevention** — all output uses Blade `{{ }}` auto-escaping + `e()` where needed
- **SQL injection** — Eloquent (PDO prepared statements), zero raw queries
- **Password hashing** — bcrypt via `Hash::make()`, cost factor 12
- **Session fixation** — session ID regenerated on login, invalidated on logout
- **Session timeout** — custom middleware logs you out after 30 mins idle
- **HTTP-only cookies** — JS cannot read the session cookie
- **Ownership checks** — `abort_if($record->user_id !== Auth::id(), 403)` on every record action
- **Role-based access** — `AdminMiddleware` returns 403 for non-admin users trying to reach `/admin`
- **No info leakage** — forgot-password form returns the same response whether the email exists or not

---

## How to set it up locally (XAMPP)

### Requirements

- XAMPP with MariaDB running
- PHP 8.x in your PATH (`C:\xampp\php`)
- Composer installed globally

### Steps

**1. Clone the repo**
```bash
git clone https://github.com/Jadehaerys/AynBook.git
cd AynBook
```

**2. Install dependencies**
```bash
composer install
```

**3. Set up .env**
```bash
copy .env.example .env
php artisan key:generate
```

Open `.env` and set your DB port (XAMPP MariaDB defaults to 3306, but check yours):
```
DB_PORT=3306
DB_DATABASE=crud_app
DB_USERNAME=root
DB_PASSWORD=
```

**4. Create the database + run migrations**
```bash
php artisan migrate
```

Or import the included SQL dump directly in phpMyAdmin: `database/crud_app.sql`

**5. Seed demo accounts (optional but recommended)**
```bash
php artisan db:seed
```

This creates `admin@aynbook.com` (Admin1234!) and `user@aynbook.com` (User1234!) with sample records.

**6. Start the server**
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` — lands on the login page.

---

## Testing the bonus features

### Password reset (Bonus B)

1. Click **Forgot your password?** on the login page
2. Enter any registered email and submit
3. Open `storage/logs/laravel.log` and search for `reset-password?token=`
4. Copy that URL into your browser — the reset form opens
5. Set a new password and log in with it

> No SMTP setup needed. The log driver handles everything locally.

### Admin panel (Bonus C)

1. Log in as `admin@aynbook.com` / `Admin1234!`
2. The **Admin** link appears in the navbar (with a badge)
3. From the admin panel you can promote/demote users or delete them
4. Log in as a regular user and try visiting `/admin` — you'll get a 403

---

## Database tables

### `users`
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | auto-increment |
| name | varchar(255) | |
| email | varchar(255) | unique |
| password | varchar(255) | bcrypt hash |
| role | varchar(255) | `user` (default) or `admin` |
| remember_token | varchar(100) | |
| created_at / updated_at | timestamp | |

### `records`
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | auto-increment |
| user_id | bigint FK | → `users.id`, cascade delete |
| name | varchar(255) | |
| email | varchar(255) | nullable |
| phone | varchar(20) | nullable |
| address | varchar(500) | nullable |
| notes | text | nullable |
| created_at / updated_at | timestamp | |

---

## Project structure

```
app/
  Http/
    Controllers/
      AuthController.php           <- register, login, logout
      RecordController.php         <- CRUD for contact records
      PasswordResetController.php  <- BONUS B: forgot/reset password
      AdminController.php          <- BONUS C: user management
    Middleware/
      AuthMiddleware.php           <- route guard + 30-min idle timeout
      AdminMiddleware.php          <- BONUS C: admin-only access
  Models/
    Record.php
    User.php

resources/views/
  layouts/app.blade.php            <- Bootstrap layout, navbar, flash messages
  auth/
    login.blade.php                <- includes "Forgot password?" link
    register.blade.php             <- includes password strength meter
    forgot-password.blade.php      <- BONUS B: request reset link
    reset-password.blade.php       <- BONUS B: enter new password
  dashboard/
    index.blade.php                <- paginated contact records table
    create.blade.php
    edit.blade.php
  admin/
    index.blade.php                <- BONUS C: user management table

routes/web.php                     <- all routes: auth, CRUD, reset, admin
database/
  migrations/                      <- all schema migrations
  crud_app.sql                     <- exported MariaDB dump
database/seeders/
  DatabaseSeeder.php               <- demo admin + user accounts
```

---

> Built by Jade Mykel R. Ventic for a practical interview, dedicated to Ayn <3
