CREATE DATABASE snack_paradise;

USE snack_paradise;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(10) NOT NULL
);