/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.4.11-MariaDB : Database - mendumy
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mendumy` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `mendumy`;

/*Table structure for table `auth` */

DROP TABLE IF EXISTS `auth`;

CREATE TABLE `auth` (
  `id_auth` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idusr` int(10) unsigned NOT NULL,
  `last_auth` date DEFAULT NULL,
  PRIMARY KEY (`id_auth`) USING BTREE,
  KEY `idusr` (`idusr`),
  CONSTRAINT `auth_ibfk_1` FOREIGN KEY (`idusr`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `auth` */

insert  into `auth`(`id_auth`,`idusr`,`last_auth`) values (2,2,'2020-03-31');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values (1,'Contaduría');

/*Table structure for table `commentscourse` */

DROP TABLE IF EXISTS `commentscourse`;

CREATE TABLE `commentscourse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idvideo` varchar(50) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `commentdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `commentscourse` */

/*Table structure for table `course` */

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `modificationdate` datetime DEFAULT NULL,
  `imgname` varchar(100) DEFAULT 'default.jpg',
  `videoname` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `course` */

insert  into `course`(`id`,`price`,`name`,`description`,`category`,`creationdate`,`modificationdate`,`imgname`,`videoname`) values (1,50,'Curso 1','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4'),(2,100,'Curso 2','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','2.mp4'),(3,135,'Curso 3','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4'),(4,300,'Curso 4','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4'),(5,100,'Curso 5','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4'),(6,50,'Curso 6','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4'),(7,100,'Curso 7','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg','1.mp4');

/*Table structure for table `courseuser` */

DROP TABLE IF EXISTS `courseuser`;

CREATE TABLE `courseuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idcourse` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `courseuser` */

insert  into `courseuser`(`id`,`idcourse`,`iduser`) values (1,1,2),(2,2,2);

/*Table structure for table `recover` */

DROP TABLE IF EXISTS `recover`;

CREATE TABLE `recover` (
  `id_recover` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idusr` int(10) unsigned NOT NULL,
  `password_request` tinyint(10) NOT NULL DEFAULT 0,
  `token_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `last_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_recover`),
  KEY `idusr` (`idusr`),
  CONSTRAINT `recover_ibfk_1` FOREIGN KEY (`idusr`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `recover` */

insert  into `recover`(`id_recover`,`idusr`,`password_request`,`token_password`,`last_modification`) values (9,2,0,'a5ef1e82f18c058117bd50f374e7cbf9','2020-03-14 16:24:19');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol` int(11) DEFAULT 1,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `legajo` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `date_birth` date DEFAULT NULL,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`rol`,`name`,`lastname`,`legajo`,`dni`,`active`,`password`,`username`,`creation_date`,`date_birth`,`token`) values (2,0,'Bruno','Di Giorgio','112132','33443123',1,'8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414','brunobocalomejor@gmail.com','2020-03-14 13:16:31','2020-03-04','517c3ffaa85c03ecd9dc67fc4603fc70');

/*Table structure for table `videoscourse` */

DROP TABLE IF EXISTS `videoscourse`;

CREATE TABLE `videoscourse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idcourse` varchar(50) DEFAULT NULL,
  `videofile` varchar(100) DEFAULT NULL,
  `uploaddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `videoscourse` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
