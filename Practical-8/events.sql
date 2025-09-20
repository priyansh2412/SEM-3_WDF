CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    event_date DATE
);

INSERT INTO events (title, event_date) VALUES
('Hackathon', '2025-09-25'),
('Seminar', '2025-09-22'),
('Workshop', '2025-09-20');