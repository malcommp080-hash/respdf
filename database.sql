-- ============================================================
--  BASE DE DATOS: dav
--  Sistema de Gestión - Clientes, Ventas y Prendas
--  Creado automáticamente - Importar en phpMyAdmin o MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS `dav`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `dav`;

-- -----------------------------------------------------------
--  TABLA: cliente
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cliente` (
  `Id_cliente`  INT          NOT NULL AUTO_INCREMENT,
  `Nombre`      VARCHAR(100) NOT NULL,
  `Ap_paterno`  VARCHAR(100) NOT NULL,
  `Telefono`    VARCHAR(20)  NOT NULL,
  `Contrasena`  VARCHAR(255) NOT NULL,
  `Direccion`   VARCHAR(255) NOT NULL,
  `CP`          VARCHAR(10)  NOT NULL,
  PRIMARY KEY (`Id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
--  TABLA: prendas
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prendas` (
  `Id_prendas`  INT          NOT NULL AUTO_INCREMENT,
  `Prendas`     VARCHAR(150) NOT NULL,
  `Num_piezas`  INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_prendas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
--  TABLA: venta
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `venta` (
  `Id_venta`     INT           NOT NULL AUTO_INCREMENT,
  `Fecha`        DATE          NOT NULL,
  `Realizacion`  VARCHAR(255)  NOT NULL,
  `Total`        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `Id_cliente`   INT           NOT NULL,
  `Total_piezas` INT           NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_venta`),
  CONSTRAINT `fk_venta_cliente`
    FOREIGN KEY (`Id_cliente`) REFERENCES `cliente` (`Id_cliente`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
--  DATOS DE PRUEBA (opcionales — puedes borrar este bloque)
-- -----------------------------------------------------------
INSERT INTO `cliente` (`Nombre`, `Ap_paterno`, `Telefono`, `Contrasena`, `Direccion`, `CP`) VALUES
('Juan',   'García',   '2221000001', '$2y$12$examplehashAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Av. Reforma 100', '72000'),
('María',  'López',    '2221000002', '$2y$12$examplehashAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Calle Hidalgo 45', '72010'),
('Carlos', 'Martínez', '2221000003', '$2y$12$examplehashAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Blvd. Atlixco 200', '72530');

INSERT INTO `prendas` (`Prendas`, `Num_piezas`) VALUES
('Camisa', 50),
('Pantalón', 30),
('Vestido', 20);

INSERT INTO `venta` (`Fecha`, `Realizacion`, `Total`, `Id_cliente`, `Total_piezas`) VALUES
(CURDATE(), 'Venta inicial de prueba', 350.00, 1, 5),
(CURDATE(), 'Segunda venta de prueba', 820.50, 2, 12);
