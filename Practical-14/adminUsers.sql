CREATE DATABASE IF NOT EXISTS adminpanel;
USE adminpanel;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    role ENUM('admin', 'user') DEFAULT 'user'
);

INSERT INTO users (username, email, status, role) VALUES
('admin', 'admin@example.com', 'active', 'admin'),
('priyansh', 'priyansh@example.com', 'active', 'user'),
('aarav', 'aarav@example.com', 'inactive', 'user');