CREATE DATABASE IF NOT EXISTS hotel_reservas;
USE hotel_reservas;

CREATE TABLE huespedes (id_huesped INT AUTO_INCREMENT PRIMARY KEY, dni VARCHAR(8) NOT NULL UNIQUE,
                        nombres VARCHAR(60) NOT NULL, apellidos VARCHAR(60) NOT NULL,
                        email VARCHAR(80), telefono VARCHAR(15));

CREATE TABLE habitaciones (id_habitacion INT AUTO_INCREMENT PRIMARY KEY, numero VARCHAR(10) NOT NULL UNIQUE,
                           tipo VARCHAR(30) NOT NULL, precio_noche DECIMAL(8,2) NOT NULL,
                           estado VARCHAR(20) DEFAULT 'Disponible');

CREATE TABLE reservas (id_reserva INT AUTO_INCREMENT PRIMARY KEY, id_huesped INT NOT NULL,
                       id_habitacion INT NOT NULL, fecha_entrada DATE NOT NULL, fecha_salida DATE NOT NULL,
                       total_pagar DECIMAL(10,2), estado VARCHAR(20) DEFAULT 'Activa',
                       FOREIGN KEY (id_huesped) REFERENCES huespedes(id_huesped) ON DELETE CASCADE,
                       FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id_habitacion));

INSERT INTO huespedes VALUES (NULL, '12345678', 'Roberto Jesús', 'Córdova Salinas', 'rcordova@email.com', '945123456');
INSERT INTO habitaciones VALUES (NULL, '101', 'Sencilla', 80.00, 'Disponible');
INSERT INTO habitaciones VALUES (NULL, '102', 'Doble', 120.00, 'Disponible');
INSERT INTO habitaciones VALUES (NULL, '201', 'Suite', 180.00, 'Disponible');
