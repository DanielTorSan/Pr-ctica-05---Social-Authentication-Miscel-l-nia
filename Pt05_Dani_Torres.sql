-- Crear la base de datos
CREATE DATABASE pt05_dani_torres;

-- Usar la base de datos creada
USE pt05_dani_torres;

-- Crear tabla 'articles'
CREATE TABLE articles (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    titol VARCHAR(255) NULL,
    cos TEXT NULL,
    imatge VARCHAR(255) NULL,
    created_by INT NULL,
    data_creacio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'usuaris'
CREATE TABLE usuaris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    remember_token VARCHAR(255) NULL,
    reset_token VARCHAR(255) UNIQUE NULL,
    reset_expiration DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
