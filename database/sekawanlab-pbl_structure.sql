-- user table
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) CHECK (role IN ('admin', 'personil')) NOT NULL DEFAULT 'personil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
