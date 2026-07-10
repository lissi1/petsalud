CREATE DATABASE IF NOT EXISTS petsalud
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE petsalud;

-- Tabla de usuarios (login)
CREATE TABLE usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de propietarios
CREATE TABLE propietarios (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  nombre    VARCHAR(100) NOT NULL,
  telefono  VARCHAR(20)  NOT NULL,
  email     VARCHAR(150) NOT NULL,
  direccion VARCHAR(255) NULL
);

-- Tabla de mascotas
CREATE TABLE mascotas (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  nombre            VARCHAR(80) NOT NULL,
  especie           ENUM('Perro','Gato','Ave','Reptil','Otro') NOT NULL,
  raza              VARCHAR(80) NULL,
  fecha_nacimiento  DATE NULL,
  peso_kg           DECIMAL(5,2) NULL,
  propietario_id    INT NOT NULL,
  CONSTRAINT fk_mascota_propietario
    FOREIGN KEY (propietario_id) REFERENCES propietarios(id)
    ON DELETE CASCADE
);
