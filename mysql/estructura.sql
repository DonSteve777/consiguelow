/*
IMPORTAR ESTE SCRIPT Y EL DE datos.sql
  Este script crea la Bdd, el usuario con privilegios sobre ella, y las tablas vacías
  Recuerda  deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
/**
      //create db
CREATE DATABASE IF NOT EXISTS `consiguelow` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;
      //create user
CREATE USER 'consiguelow'@'localhost' IDENTIFIED BY 'consiguelow';
GRANT ALL PRIVILEGES ON `consiguelow`.* TO 'consiguelow'@'localhost';
*/
USE `consiguelow`;

/*create tables*/
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `uploads`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `rolesUsuario`;
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `nombreUsuario` varchar(15) NOT NULL,
  `password` varchar(80) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `ciudad` varchar(12) NOT NULL,
  `codigo postal` varchar(5) NOT NULL,
  `tarjeta credito` varchar(16) NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `categorias` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(20) NOT NULL ,
  `descripcion` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- Estructura de tabla para la tabla `productos`
--
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `idVendedor` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `unidades` int(10) UNSIGNED NOT NULL,
  `talla` int(3) NOT NULL,
  `categoria` INT(11) NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`categoria`) REFERENCES `categorias`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idVendedor`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `uploads` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `producto` int(11) NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    `mime_type` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`producto`) REFERENCES `productos`(`id`) ON DELETE CASCADE ON UPDATE CASCADE)
  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `rolesUsuario` (
  `usuario` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  PRIMARY KEY (`usuario`,`rol`),
  KEY `rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `rolesUsuario`
  ADD CONSTRAINT `rolesUsuario_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rolesUsuario_rol` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `pedidos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `producto` int(11) NOT NULL,
    `pagado` TINYINT(1) NOT NULL,
    `comprador` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`producto`) REFERENCES `productos`(`id`)ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`comprador`) REFERENCES `usuarios`(`id`)ON DELETE CASCADE ON UPDATE CASCADE
    )
  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;
