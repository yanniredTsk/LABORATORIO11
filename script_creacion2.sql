CREATE DATABASE IF NOT EXISTS farmacia_ventas;
USE farmacia_ventas;

CREATE TABLE categorias (id_categoria INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(50) NOT NULL);

CREATE TABLE medicamentos (
    id_medicamento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_categoria INT NOT NULL,
    precio_base DECIMAL(8,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_medicamento INT NOT NULL,
    cantidad INT NOT NULL,
    total DECIMAL(8,2) NOT NULL,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_medicamento) REFERENCES medicamentos(id_medicamento)
);

INSERT INTO categorias VALUES (NULL, 'Analgésicos');
INSERT INTO categorias VALUES (NULL, 'Antibióticos');
INSERT INTO medicamentos VALUES (NULL, 'Paracetamol 500mg', 1, 5.90, 50);
INSERT INTO medicamentos VALUES (NULL, 'Amoxicilina 500mg', 2, 12.50, 30);
