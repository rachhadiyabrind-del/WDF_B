
CREATE DATABASE studenthub;

USE studenthub;

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    year INT NOT NULL
);

CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL
);

CREATE TABLE registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    UNIQUE (student_id, event_id)
);

INSERT INTO students (name, email, course, year)
VALUES
('Rahul Patel', 'rahul@gmail.com', 'B.Tech CE', 2),
('Priya Shah', 'priya@gmail.com', 'B.Tech IT', 2);

INSERT INTO events (title, description, event_date)
VALUES
('Web Development Workshop', 'Learn HTML, CSS and PHP', '2026-11-10'),
('Technical Seminar', 'Technology and Innovation', '2026-11-15');
