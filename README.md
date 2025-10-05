 PHP Bug Tracker / Issue Management System

A lightweight **PHP + MySQL + Bootstrap** starter that demonstrates:

- 🔐 Auth (register / login / logout) using `password_hash`
- 🧾 Tickets CRUD (create, read, update)
- 👑 Admin assignment + status changes
- 📊 Dashboard filters by severity / status
- 👥 Role-based access (admin vs user)

Built **2025-10-05**

---

 🧱 Stack

- PHP 8+ (PDO)
- MySQL 5.7+ / MariaDB
- Bootstrap 5 (via CDN)

---

 Quick Start

### 1️⃣ Create Database & Tables
See the provided SQL file:
```sql
-- database.sql

Configure Environment

Copy .env.example → .env and edit your database credentials.

Serve the App

Run PHP’s built-in server:
php -S localhost:8080 -t public


Default Admin Login
| Field        | Value                                         |
| ------------ | --------------------------------------------- |
| **Email**    | [admin@example.com](mailto:admin@example.com) |
| **Password** | admin123                                      |


Project Structure

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
│     └─ index.php         # Admin-only user list
├─ assets/
│  └─ style.css

Notes

Use prepared statements with PDO for security.

Update .htaccess if deploying to Apache.

Extend tickets to include file uploads or categories.

Keep .env out of version control (.gitignore).

