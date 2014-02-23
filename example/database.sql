/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50615
 Source Host           : localhost
 Source Database       : fundo

 Target Server Type    : MySQL
 Target Server Version : 50615
 File Encoding         : utf-8

 Date: 02/21/2014 23:41:05 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `abono`
-- ----------------------------
DROP TABLE IF EXISTS `abono`;
CREATE TABLE `abono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `observacion` text,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `abono_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `abono_planta`
-- ----------------------------
DROP TABLE IF EXISTS `abono_planta`;
CREATE TABLE `abono_planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_abono` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `planta_abono` (`id_abono`,`id_planta`) USING BTREE,
  KEY `id_planta` (`id_planta`),
  CONSTRAINT `abono_planta_ibfk_1` FOREIGN KEY (`id_abono`) REFERENCES `abono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `abono_planta_ibfk_2` FOREIGN KEY (`id_planta`) REFERENCES `planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `cliente`
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL DEFAULT '',
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` char(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `cosecha`
-- ----------------------------
DROP TABLE IF EXISTS `cosecha`;
CREATE TABLE `cosecha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kilos_primera` double NOT NULL,
  `kilos_segunda` double NOT NULL,
  `kilos_descarte` double NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `cosecha_planta`
-- ----------------------------
DROP TABLE IF EXISTS `cosecha_planta`;
CREATE TABLE `cosecha_planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cosecha` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `planta_cosecha` (`id_cosecha`,`id_planta`) USING BTREE,
  KEY `id_planta` (`id_planta`),
  CONSTRAINT `cosecha_planta_ibfk_1` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cosecha_planta_ibfk_2` FOREIGN KEY (`id_planta`) REFERENCES `planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `empleado`
-- ----------------------------
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL DEFAULT '',
  `dni` char(8) DEFAULT '',
  `telefono` char(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empleado_dni_uk` (`dni`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `estado_ambiente`
-- ----------------------------
DROP TABLE IF EXISTS `estado_ambiente`;
CREATE TABLE `estado_ambiente` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `temperatura` float NOT NULL,
  `humedad` float NOT NULL,
  `presion_ambiental` float NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `fumigacion`
-- ----------------------------
DROP TABLE IF EXISTS `fumigacion`;
CREATE TABLE `fumigacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `observacion` text,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `fumigacion_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `fumigacion_planta`
-- ----------------------------
DROP TABLE IF EXISTS `fumigacion_planta`;
CREATE TABLE `fumigacion_planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL,
  `id_fumigacion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fumigacion_planta` (`id_planta`,`id_fumigacion`) USING BTREE,
  KEY `id_fumigacion` (`id_fumigacion`),
  CONSTRAINT `fumigacion_planta_ibfk_1` FOREIGN KEY (`id_planta`) REFERENCES `planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fumigacion_planta_ibfk_2` FOREIGN KEY (`id_fumigacion`) REFERENCES `fumigacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `pedido`
-- ----------------------------
DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `costo` double NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad_abono` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_proveedor` (`id_proveedor`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `planta`
-- ----------------------------
DROP TABLE IF EXISTS `planta`;
CREATE TABLE `planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_tipo_planta` int(11) NOT NULL,
  `columna` int(11) DEFAULT NULL,
  `fila` int(11) DEFAULT NULL,
  `estado` enum('SEMBRADA','REMOVIDA') DEFAULT 'SEMBRADA',
  PRIMARY KEY (`id`),
  KEY `id_tipo_planta` (`id_tipo_planta`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `planta_ibfk_2` FOREIGN KEY (`id_tipo_planta`) REFERENCES `tipo_planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `planta_ibfk_3` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `problema`
-- ----------------------------
DROP TABLE IF EXISTS `problema`;
CREATE TABLE `problema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `resuelto` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_planta` (`id_planta`),
  CONSTRAINT `problema_ibfk_1` FOREIGN KEY (`id_planta`) REFERENCES `planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `proveedor`
-- ----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL DEFAULT '',
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` char(12) DEFAULT NULL,
  `ruc` char(11) NOT NULL DEFAULT '',
  `contacto` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proveedor_ruc_uk` (`ruc`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `riego`
-- ----------------------------
DROP TABLE IF EXISTS `riego`;
CREATE TABLE `riego` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` int(11) NOT NULL,
  `observacion` text,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `riego_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `riego_planta`
-- ----------------------------
DROP TABLE IF EXISTS `riego_planta`;
CREATE TABLE `riego_planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_riego` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `riego_planta_uk` (`id_riego`,`id_planta`) USING BTREE,
  KEY `id_planta` (`id_planta`),
  CONSTRAINT `riego_planta_ibfk_1` FOREIGN KEY (`id_riego`) REFERENCES `riego` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `riego_planta_ibfk_2` FOREIGN KEY (`id_planta`) REFERENCES `planta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tipo_planta`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_planta`;
CREATE TABLE `tipo_planta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL DEFAULT '',
  `descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `venta`
-- ----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_cosecha` int(11) NOT NULL,
  `kilos_vendidos` double NOT NULL,
  `observaciones` text,
  `costo` double NOT NULL,
  `tipo` enum('PRIMERA','SEGUNDA','DESCARTE') DEFAULT 'DESCARTE',
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_cosecha` (`id_cosecha`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
