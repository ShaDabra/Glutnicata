CREATE DATABASE IF NOT EXISTS vacation_manager;
USE vacation_manager;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(255),
    group_name VARCHAR(255)
);
