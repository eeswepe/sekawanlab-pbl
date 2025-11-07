-- sekawanlab-pbl_structure.sql

-- Drop table if it exists to allow for clean re-creation
DROP TABLE IF EXISTS users;

-- Table structure for table `users`
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'personil') NOT NULL DEFAULT 'personil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add any initial data here if necessary
-- INSERT INTO users (username, password, role) VALUES ('admin', 'hashed_password', 'admin');
