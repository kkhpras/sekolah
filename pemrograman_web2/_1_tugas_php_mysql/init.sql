CREATE DATABASE IF NOT EXISTS php_mysql_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE php_mysql_app;

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contacts (name, email, phone) VALUES
('Budi Santoso', 'budi@example.com', '08123456789'),
('Siti Aminah', 'siti@example.com', '08234567890');