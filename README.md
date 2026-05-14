# <3 AynBook

> A contact management web app named after my girlfriend, Ayn. Built as part of a practical interview for a dev position. It's simple, secure, and gets the job done.

I'm Jade, 22, and this is a full-stack PHP app I put together using **Laravel 11** and **Bootstrap 5**. It covers user authentication, a personal dashboard, and full CRUD operations — all with proper security baked in.

---

## What it does

- Register and log in with your own account
- Keep a personal list of contact records (name, email, phone, address, notes)
- Add, edit, and delete records — only you can see your own
- Session auto-expires after 30 minutes of inactivity (so nobody sneaks in)
- Clean, responsive UI using Bootstrap 5

---

## Tech stack

| Layer | What I used |
|---|---|
| Language | PHP 8.2 |
| Framework | Laravel 11 |
| Database | MariaDB via XAMPP |
| Frontend | Bootstrap 5.3 + Bootstrap Icons (CDN) |
| Auth | Laravel session-based auth |

---

## Security features

I didn't cut corners here — this is what's covered:

- **CSRF protection** — every form has a `@csrf` token, auto-validated by Laravel
- **XSS prevention** — all output goes through Blade's `{{ }}` auto-escaping + `e()` where needed
- **SQL injection** — using Eloquent (PDO prepared statements under the hood), no raw queries
- **Password hashing** — bcrypt via `Hash::make()`, same thing as `password_hash()` — cost factor 12
- **Session fixation** — session ID regenerated on login, invalidated on logout
- **Session timeout** — custom middleware kicks you out after 30 mins idle
- **HTTP-only cookies** — JS can't read the session cookie
- **Ownership checks** — `abort_if($record->user_id !== Auth::id(), 403)` so you can't touch other users' data

---

## How to set it up locally (XAMPP)

### Requirements

- XAMPP running with MariaDB started
- PHP 8.x in your system PATH (usually `C:\xampp\php`)
- Composer installed globally

### Steps

**1. Clone the repo**
```bash
git clone https://github.com/<your-username>/aynbook.git
cd aynbook
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Set up your .env**
```bash
copy .env.example .env
php artisan key:generate
```

Then open `.env` and update the DB section:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306       # mine runs on 3307 because system MySQL took 3306 — check yours
DB_DATABASE=crud_app
DB_USERNAME=root
DB_PASSWORD=       # blank by default on XAMPP
```

**4. Create the database**

Open phpMyAdmin at `http://localhost/phpmyadmin` and create a database called `crud_app`.

Or just import the SQL file I included:
```bash
mysql -u root -P 3306 crud_app < database/crud_app.sql
```

**5. Run migrations**
```bash
php artisan migrate
```

**6. Start the server**
```bash
php artisan serve
```

Go to `http://127.0.0.1:8000` — you should land on the login page.

---

## Database tables

### `users`
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | auto-increment |
| name | varchar(255) | full name |
| email | varchar(255) | unique |
| password | varchar(255) | bcrypt hash |
| remember_token | varchar(100) | for "remember me" |
| created_at / updated_at | timestamp | |

### `records`
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | auto-increment |
| user_id | bigint FK | ties to `users.id`, cascades on delete |
| name | varchar(255) | contact name |
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
      AuthController.php      ← handles register, login, logout
      RecordController.php    ← all the CRUD stuff
    Middleware/
      AuthMiddleware.php      ← blocks guests + handles session timeout
  Models/
    Record.php
    User.php

resources/views/
  layouts/app.blade.php       ← main Bootstrap layout + navbar
  auth/
    login.blade.php
    register.blade.php        ← includes password strength meter
  dashboard/
    index.blade.php           ← the table with all your records
    create.blade.php
    edit.blade.php

routes/web.php                ← all routes defined here
database/
  migrations/                 ← schema definitions
  crud_app.sql                ← exported SQL if you don't want to migrate
```

---

> Built by Jade Mykel R. Ventic for a practical interview, dedicated to Ayn <3

