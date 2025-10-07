CREATE DATABASE IF NOT EXISTS eventdb;
USE eventdb;

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    date DATE NOT NULL,
    status ENUM('open', 'closed') DEFAULT 'open'
);

INSERT INTO events (title, description, date, status) VALUES
('Tech Talk', 'AI and ML trends', '2025-10-10', 'open'),
('Hackathon', '24-hour coding challenge', '2025-11-01', 'closed');