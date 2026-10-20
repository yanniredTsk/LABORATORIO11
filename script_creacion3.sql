CREATE DATABASE IF NOT EXISTS peluqueria_citas;
USE peluqueria_citas;

CREATE TABLE clientes (id_cliente INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(80) NOT NULL, 
                       telefono VARCHAR(15), email VARCHAR(80));

CREATE TABLE servicios (id_servicio INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(60) NOT NULL,
                        precio DECIMAL(8,2) NOT NULL, duracion_minutos INT NOT NULL DEFAULT 30);

CREATE TABLE citas (id_cita INT AUTO_INCREMENT PRIMARY KEY, id_cliente INT NOT NULL,
                    id_servicio INT NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL,
                    estado VARCHAR(20) DEFAULT 'Programada',
                    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
                    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio));

INSERT INTO clientes VALUES (NULL, 'María García Rodríguez', '987654321', 'mgarcia@email.com');
INSERT INTO servicios VALUES (NULL, 'Corte de cabello', 35.00, 30);
INSERT INTO servicios VALUES (NULL, 'Tinte cabello', 65.00, 60);
