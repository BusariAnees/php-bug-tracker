
-- Created database 
-- CREATED DATABASE bugtracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USED bugtracker;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT,
  severity ENUM('low','medium','high','critical') NOT NULL DEFAULT 'low',
  status ENUM('open','in_progress','resolved','closed') NOT NULL DEFAULT 'open',
  created_by INT NOT NULL,
  assigned_to INT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin
INSERT INTO users (name, email, password_hash, is_admin, created_at)
VALUES ('Admin', 'admin@example.com', '$2y$10$G6mYWHj9k9f7wHMc2dYzpe3FKm8mP6kXG0u8mXq3c0M6dKQ1H.4Zy', 1, NOW());
-- password: admin123

-- Sample tickets
INSERT INTO tickets (title, description, severity, status, created_by, assigned_to, created_at, updated_at)
VALUES
('Login button not responding', 'Steps: Click login -> nothing happens.
Expected: Redirect to dashboard.', 'medium', 'open', 1, NULL, NOW(), NOW()),
('Payment gateway error 500', 'Stripe callback throws 500 on production.', 'high', 'in_progress', 1, NULL, NOW(), NOW()),
('Typo on homepage CTA', 'CTA reads "Get Start" instead of "Get Started".', 'low', 'resolved', 1, NULL, NOW(), NOW()),
('Critical data loss bug', 'Data disappears after editing a record under high load.', 'critical', 'open', 1, NULL, NOW(), NOW());
