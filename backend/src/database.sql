CREATE DATABASE IF NOT EXISTS moviedb;
USE moviedb;

CREATE TABLE users (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE reviews (
    movieID INTEGER NOT NULL,
    userID INTEGER NOT NULL,
    review TEXT NOT NULL,
    FOREIGN KEY (userID) REFERENCES users(ID) ON DELETE CASCADE
);