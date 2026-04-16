CREATE DATABASE IF NOT EXISTS emisora_app;
USE emisora_app;

CREATE TABLE IF NOT EXISTS emisoras (
    id VARCHAR(36) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    canal INT NOT NULL,
    banda_fm VARCHAR(10) NULL,
    banda_am VARCHAR(10) NULL,
    num_locutores INT NOT NULL DEFAULT 0,
    genero VARCHAR(50) NOT NULL,
    horario VARCHAR(100) NOT NULL,
    patrocinador VARCHAR(100) NULL,
    pais VARCHAR(50) NOT NULL,
    descripcion TEXT NULL,
    num_programas INT NOT NULL DEFAULT 0,
    num_ciudades INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(36) PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar un usuario de prueba (contraseña: "admin123")
INSERT INTO users (id, email, password_hash) 
VALUES ('123e4567-e89b-12d3-a456-426614174000', 'admin@emisora.com', '$2y$10$XLZMGJK9ZhTLZezWlsueo.eIYOJFdFc3TFf7WVwAqacXqTrHWUoRi')
ON DUPLICATE KEY UPDATE email=email;
