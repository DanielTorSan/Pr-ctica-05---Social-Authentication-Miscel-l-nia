CREATE DATABASE pt05_dani_torres;
USE pt05_dani_torres;

-- Crear la tabla "articles"
CREATE TABLE articles (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    cos TEXT NULL,
    created_by INT,
    data_creacio DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    imatge VARCHAR(255) NULL,
    titol VARCHAR(255) NULL
);

-- Crear la tabla "usuaris"
CREATE TABLE usuaris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    avatar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(255) NULL,
    reset_expiration DATETIME NULL,
    reset_token VARCHAR(255) NULL,
    role ENUM('user') NULL,
    username VARCHAR(255) NOT NULL UNIQUE
);
