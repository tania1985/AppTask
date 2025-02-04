-- 📌 Crear la base de datos
CREATE DATABASE tareas_app;
USE tareas_app;

-- 📌 Tabla de Usuarios (Usuarios registrados)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Se recomienda almacenar el password encriptado
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 📌 Tabla de Estados de las Tareas (Ejemplo: En proceso, Terminada)
CREATE TABLE estados (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
);

-- 📌 Insertar Estados Iniciales
INSERT INTO estados (nombre) VALUES ('En proceso'), ('Terminada');

-- 📌 Tabla de Tareas (Usuarios registrados pueden gestionarlas)
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Cambié SERIAL por INT AUTO_INCREMENT
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_id INT NOT NULL DEFAULT 1,
    user_id INT NOT NULL,
    FOREIGN KEY (estado_id) REFERENCES estados(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
