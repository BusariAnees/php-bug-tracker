
# PHP Bug Tracker / Issue Management System

A lightweight PHP + MySQL + Bootstrap starter that demonstrates:
- Auth (register/login/logout) using `password_hash`
- Tickets CRUD (create, read, update)
- Admin assignment + status changes
- Dashboard filters by severity/status
- Role-based access (admin vs user)

> Built 2025-10-05.

## Stack
- PHP 8+ (PDO)
- MySQL 5.7+/MariaDB
- Bootstrap 5 (CDN)

## Quick Start

1) Create DB & tables
```sql
-- See database.sql in this repo
```

2) Copy `.env.example` to `.env` and edit DB creds.

3) Serve the `public/` directory with PHP's built-in server:

```bash
php -S localhost:8080 -t public
```

4) Login with the seeded admin:
- Email: admin@example.com
- Password: admin123

## Project Structure
```
bugtracker-php/
├─ README.md
├─ database.sql
├─ .env.example
├─ config.php
├─ db.php
├─ includes/
│  ├─ auth.php
│  ├─ header.php
│  ├─ footer.php
│  └─ helpers.php
├─ public/
│  ├─ index.php            # Dashboard + filters
│  ├─ login.php
│  ├─ logout.php
│  ├─ register.php
│  ├─ tickets/
│  │  ├─ create.php
│  │  ├─ edit.php
│  │  ├─ show.php
│  │  └─ delete.php
│  └─ users/
│     └─ index.php         # Admin-only user list (tiny)
├─ assets/
│  └─ style.css
```
