/*
SQLyog Enterprise - MySQL GUI v6.07
Host - 5.5.27 : Database - risase
*********************************************************************
Server version : 5.5.27
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `risase`;

USE `risase`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `agrupedidos` */

DROP TABLE IF EXISTS `agrupedidos`;

CREATE TABLE `agrupedidos` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'P',
  `tip` int(2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `estado` (`estado`),
  KEY `tip` (`tip`),
  KEY `fecha` (`fecha`)
) ENGINE=InnoDB AUTO_INCREMENT=14543 DEFAULT CHARSET=latin1;

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
  UNIQUE KEY `codbarras` (`codbarras`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_subgrupo` (`id_subgrupo`),
  KEY `id_color` (`id_color`),
  KEY `codigo` (`codigo`),
  KEY `refprov` (`refprov`),
  KEY `temporada` (`temporada`),
  KEY `pvp` (`pvp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `colores` */

DROP TABLE IF EXISTS `colores`;

CREATE TABLE `colores` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

/*Table structure for table `detreparto` */

DROP TABLE IF EXISTS `detreparto`;

CREATE TABLE `detreparto` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_reparto` bigint(50) DEFAULT NULL,
  `id_articulo` bigint(50) DEFAULT NULL,
  `id_tienda` int(8) DEFAULT NULL,
  `cantidad` int(8) DEFAULT NULL,
  `recibida` int(8) DEFAULT NULL,
  `stockmin` int(8) DEFAULT NULL,
  `estado` varchar(4) DEFAULT NULL,
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

/*Table structure for table `importadores` */

DROP TABLE IF EXISTS `importadores`;

CREATE TABLE `importadores` (
  `detreparto` bigint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` bigint(8) DEFAULT NULL,
  `id_tienda` bigint(5) DEFAULT NULL,
  `cantidad` int(5) DEFAULT NULL,
  `estado` varchar(2) DEFAULT '-',
  `tip` int(2) DEFAULT NULL,
  `agrupar` varchar(8) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `prov` int(5) DEFAULT NULL,
  `grupo` int(5) DEFAULT NULL,
  `subgrupo` int(5) DEFAULT NULL,
  `codigo` int(5) DEFAULT NULL,
  `pventa` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agrupar` (`agrupar`),
  KEY `orden` (`prov`,`grupo`,`subgrupo`,`codigo`),
  KEY `id_articulo` (`id_articulo`),
  KEY `tip` (`tip`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=1927567 DEFAULT CHARSET=latin1;

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

/*Table structure for table `repartir` */

DROP TABLE IF EXISTS `repartir`;

CREATE TABLE `repartir` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` bigint(12) unsigned NOT NULL,
  `id_tienda` int(5) DEFAULT NULL,
  `cantidad` int(5) DEFAULT NULL,
  `stockmin` int(5) DEFAULT NULL,
  `estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_articulo` (`id_articulo`),
  KEY `id_tienda` (`id_tienda`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=1765668 DEFAULT CHARSET=latin1;

/*Table structure for table `repartos` */

DROP TABLE IF EXISTS `repartos`;

CREATE TABLE `repartos` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `nomrep` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nomrep` (`nomrep`),
  KEY `fecha` (`fecha`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `roturas` */

DROP TABLE IF EXISTS `roturas`;

CREATE TABLE `roturas` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_tienda` bigint(10) DEFAULT NULL,
  `codbarras` bigint(15) DEFAULT NULL,
  `modo` varchar(4) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
  `id_tiend` int(20) DEFAULT NULL,
  `syncSql` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`id`),
  KEY `activa` (`activa`),
  KEY `orden` (`orden`),
  KEY `id_tienda` (`id_tienda`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
