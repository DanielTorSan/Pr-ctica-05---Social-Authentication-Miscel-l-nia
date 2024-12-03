-- Crear la base de datos
CREATE DATABASE pt05_dani_torres;
USE pt05_dani_torres;

-- Crear la tabla articles
CREATE TABLE articles (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    DNI VARCHAR(50) UNIQUE,
    titol VARCHAR(255),
    cos TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear la tabla usuaris
CREATE TABLE usuaris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(255) UNIQUE,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_expiration DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
