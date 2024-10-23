CREATE TABLE issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) DEFAULT 'Not Provided',
    priority ENUM('Low', 'Medium', 'High') NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    date_reported DATE NOT NULL,
    assigned_to VARCHAR(255) NOT NULL
);
