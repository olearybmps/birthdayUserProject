CREATE DATABASE your_database_name;
USE your_database_name;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);