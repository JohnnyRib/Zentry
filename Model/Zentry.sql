CREATE DATABASE IF NOT EXISTS Zentry;
USE Zentry;

DROP USER IF EXISTS 'Zentry_team'@'localhost';

CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';

GRANT ALL PRIVILEGES ON Zentry.* TO 'Zentry_team'@'localhost';

FLUSH PRIVILEGES;

DROP TABLE IF EXISTS `user`;
--Borra lo existente para evitar conflictos al crear la tabla nuevamente.

-- Estructura de la tabla user
CREATE TABLE IF NOT EXISTS `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('Cliente', 'Promotor') NOT NULL DEFAULT 'Cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Configuración de la Tabla de Usuario
-- ENGINE=InnoDB: Garantiza integridad referencial y recuperación de errores.
-- CHARSET=utf8mb4: Soporte completo para caracteres especiales y emojis.

DROP TABLE IF EXISTS `eventos`;
-- Elimina la tabla eventos si ya existe para evitar conflictos al crearla nuevamente.

CREATE TABLE IF NOT EXISTS `eventos` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha DATE NOT NULL,
    ubicacion VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Configuración de la Tabla de Eventos
-- ENGINE=InnoDB: Garantiza integridad referencial y recuperación de errores.
-- CHARSET=utf8mb4: Soporte completo para caracteres especiales y emojis.


