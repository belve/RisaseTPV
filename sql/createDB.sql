/*
SQLyog Enterprise - MySQL GUI v6.07
Host - 5.5.32-0ubuntu0.12.04.1 : Database - RisaseTPV
*********************************************************************
Server version : 5.5.32-0ubuntu0.12.04.1
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `RisaseTPV`;

USE `RisaseTPV`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `actions` */

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `accion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `articulos` */

DROP TABLE IF EXISTS `articulos`;

CREATE TABLE `articulos` (
  `id` bigint(255) unsigned NOT NULL,
  `id_proveedor` int(8) DEFAULT NULL,
  `id_subgrupo` int(8) DEFAULT NULL,
  `id_color` int(8) DEFAULT NULL,
  `codigo` int(20) DEFAULT NULL,
  `refprov` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `stock` int(50) DEFAULT NULL,
  `uniminimas` int(50) DEFAULT NULL,
  `codbarras` varchar(12) DEFAULT NULL,
  `temporada` varchar(8) DEFAULT NULL,
  `preciocosto` decimal(8,2) DEFAULT NULL,
  `precioneto` decimal(8,2) DEFAULT NULL,
  `preciofran` decimal(8,2) DEFAULT NULL,
  `detalles` varchar(255) DEFAULT NULL,
  `comentarios` varchar(255) DEFAULT NULL,
  `pvp` decimal(8,2) DEFAULT NULL,
  `congelado` tinyint(1) DEFAULT NULL,
  `stockini` int(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_subgrupo` (`id_subgrupo`),
  KEY `id_color` (`id_color`),
  KEY `codigo` (`codigo`),
  KEY `refprov` (`refprov`),
  KEY `temporada` (`temporada`),
  KEY `pvp` (`pvp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `caja` */

DROP TABLE IF EXISTS `caja`;

CREATE TABLE `caja` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `id_empleado` bigint(10) DEFAULT NULL,
  `importe` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fecha` (`fecha`),
  KEY `id_empleado` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `colores` */

DROP TABLE IF EXISTS `colores`;

CREATE TABLE `colores` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `var` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `det_rebaja` */

DROP TABLE IF EXISTS `det_rebaja`;

CREATE TABLE `det_rebaja` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_rebaja` bigint(255) DEFAULT NULL,
  `id_articulo` bigint(50) DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `fecha_ini` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `empleados` */

DROP TABLE IF EXISTS `empleados`;

CREATE TABLE `empleados` (
  `id` bigint(255) unsigned NOT NULL,
  `id_tienda` varchar(40) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido1` varchar(255) DEFAULT NULL,
  `apellido2` varchar(255) DEFAULT NULL,
  `trabajando` varchar(2) DEFAULT NULL,
  `orden` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `grupos` */

DROP TABLE IF EXISTS `grupos`;

CREATE TABLE `grupos` (
  `id` bigint(255) unsigned NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `codbarras` bigint(255) unsigned NOT NULL,
  KEY `codbarras` (`codbarras`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `proveedores` */

DROP TABLE IF EXISTS `proveedores`;

CREATE TABLE `proveedores` (
  `id` bigint(255) unsigned NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cif` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `cp` varchar(255) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dto1` varchar(255) DEFAULT NULL,
  `dto2` varchar(255) DEFAULT NULL,
  `iva` varchar(255) DEFAULT NULL,
  `nomcorto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pvp_fijo` */

DROP TABLE IF EXISTS `pvp_fijo`;

CREATE TABLE `pvp_fijo` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` bigint(20) DEFAULT NULL,
  `pvp` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `roturas` */

DROP TABLE IF EXISTS `roturas`;

CREATE TABLE `roturas` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `codbarras` bigint(15) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `modo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stocklocal` */

DROP TABLE IF EXISTS `stocklocal`;

CREATE TABLE `stocklocal` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_art` bigint(100) DEFAULT NULL,
  `cod` bigint(50) DEFAULT NULL,
  `stock` int(22) DEFAULT NULL,
  `alarma` int(22) DEFAULT NULL,
  `pvp` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `subgrupos` */

DROP TABLE IF EXISTS `subgrupos`;

CREATE TABLE `subgrupos` (
  `id` bigint(10) unsigned NOT NULL,
  `id_grupo` bigint(10) DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `clave` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `syncupdate` */

DROP TABLE IF EXISTS `syncupdate`;

CREATE TABLE `syncupdate` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `syncSql` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ticket_det` */

DROP TABLE IF EXISTS `ticket_det`;

CREATE TABLE `ticket_det` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_tienda` bigint(255) DEFAULT NULL,
  `id_ticket` varchar(255) DEFAULT NULL,
  `id_articulo` bigint(255) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `importe` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tienda` (`id_tienda`),
  KEY `id_ticket` (`id_ticket`),
  KEY `id_articulo` (`id_articulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tickets` */

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_tienda` bigint(255) DEFAULT NULL,
  `id_ticket` varchar(255) DEFAULT NULL,
  `id_empleado` int(30) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `importe` decimal(8,2) DEFAULT NULL,
  `descuento` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tienda` (`id_tienda`),
  KEY `id_ticket` (`id_ticket`),
  KEY `id_empleado` (`id_empleado`),
  KEY `fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tiendas` */

DROP TABLE IF EXISTS `tiendas`;

CREATE TABLE `tiendas` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_tienda` varchar(8) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cp` varchar(8) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `telefonoConex` varchar(12) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `orden` int(12) DEFAULT NULL,
  `franquicia` int(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `activa` (`activa`),
  KEY `orden` (`orden`),
  KEY `id_tienda` (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
