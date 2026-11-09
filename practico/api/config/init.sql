CREATE TABLE tipousuario (
    id_tipousuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    id_tipousuario INT NOT NULL,
    FOREIGN KEY (id_tipousuario) REFERENCES tipousuario(id_tipousuario)
);
CREATE TABLE tipoarticulo (
    id_tipoarticulo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE autor (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL
);
CREATE TABLE articulo (
    id_articulo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    id_tipoarticulo INT NOT NULL,
    id_autor INT NOT NULL,
    FOREIGN KEY (id_tipoarticulo) REFERENCES tipoarticulo(id_tipoarticulo),
    FOREIGN KEY (id_autor) REFERENCES autor(id_autor)
);
INSERT INTO tipousuario (id_tipousuario, nombre) VALUES
(1, 'Administrador'),
(2, 'Usuario');
INSERT INTO usuario (usuario, password_hash, nombre, id_tipousuario) VALUES
('admin', '$2y$10$5EpatUdUL4eepQLVMXsiFuKvmKt9DSAefQ4QnbAFKHVK.prJu7ugq', 'Rulo', 1),
('usuario', '$2y$10$Ts1zvYVBfJy9dbJUHS6C1ehZGClUlA8JPkyw/MP/y5ap/KtE52kCq', 'Lector', 2);
INSERT INTO tipoarticulo (id_tipoarticulo, nombre) VALUES
(1, 'Libro'),
(2, 'Audiolibro');
INSERT INTO autor (nombre) VALUES
('Horacio Quiroga'),
('George R. R. Martin'),
('Antoine de Saint-Exupéry'),
('Lewis Carroll'),
('Dr. Juan Pérez'),
('Hermanos Grimm');
INSERT INTO articulo (titulo, precio, imagen, id_tipoarticulo, id_autor) VALUES
('El almohadón de plumas', 500.00, 'assets/img/plumas.jpg', 1, 1),
('Juego de Tronos', 1500.00, 'assets/img/tronos.jpg', 1, 2),
('El principito', 800.00, 'assets/img/principito.jpg', 1, 3),
('Alicia en el País de las Maravillas', 1200.00, 'assets/img/audiolibro1.jpg', 2, 4),
('Biomoléculas', 900.00, 'assets/img/audiolibro2.jpg', 2, 5),
('Blancanieves', 1100.00, 'assets/img/audiolibro3.jpg', 2, 6);
