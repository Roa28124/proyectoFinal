/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - comidas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`comidas` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `comidas`;

/*Table structure for table `recetas` */

DROP TABLE IF EXISTS `recetas`;

CREATE TABLE `recetas` (
  `id_receta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tiempo_preparacion` int(11) NOT NULL COMMENT 'Tiempo en minutos',
  `dificultad` enum('Fácil','Medio','Difícil') NOT NULL,
  `porciones` int(11) NOT NULL,
  `categoria` enum('Entrada','Principal','Postre','Aperitivo','Bebida') NOT NULL,
  PRIMARY KEY (`id_receta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `recetas` */

insert  into `recetas`(`id_receta`,`nombre`,`tiempo_preparacion`,`dificultad`,`porciones`,`categoria`) values 
(1,'Pie de Limon',45,'Medio',5,'Postre'),
(2,'Ensalada César',15,'Fácil',2,'Entrada');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
