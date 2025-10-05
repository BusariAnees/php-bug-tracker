PHP Bug Tracker / Issue Management System
A lightweight PHP + MySQL + Bootstrap starter that demonstrates:

Auth (register/login/logout) using password_hash
Tickets CRUD (create, read, update)
Admin assignment + status changes
Dashboard filters by severity/status
Role-based access (admin vs user)
Built 2025-10-05.

Stack
PHP 8+ (PDO)
MySQL 5.7+/MariaDB
Bootstrap 5 (CDN)
Quick Start
Create DB & tables
-- See database.sql in this repo
Copy .env.example to .env and edit DB creds.

Serve the public/ directory with PHP's built-in server:

php -S localhost:8080 -t public
Login with the seeded admin:
Email: admin@example.com
Password: admin123
Project Structure
