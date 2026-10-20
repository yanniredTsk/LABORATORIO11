CREATE DATABASE IF NOT EXISTS biblioteca_municipal;
USE biblioteca_municipal;
CREATE TABLE libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    año_publicacion INT,
    stock INT NOT NULL DEFAULT 0
);
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(8) NOT NULL UNIQUE,
    nombres VARCHAR(60) NOT NULL,
    apellidos VARCHAR(60) NOT NULL,
    email VARCHAR(80)
);
CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_libro INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_prestamo DATE DEFAULT (CURRENT_DATE),
    fecha_devolucion_estimada DATE,
    devuelto BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);
INSERT INTO libros VALUES (NULL, 'Cien años de soledad', 'García Márquez', 1967, 3);
INSERT INTO libros VALUES (NULL, 'La casa verde', 'Vargas Llosa', 1966, 2);
INSERT INTO usuarios VALUES (NULL, '12345678', 'Juan Carlos', 'Rojas Mendoza', 'jrojas@email.com');
INSERT INTO usuarios VALUES (NULL, '61022739', 'Yannired Kristall', 'Torres Parrillo', 'yantorrespa@uch.pe');

