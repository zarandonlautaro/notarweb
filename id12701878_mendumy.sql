/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.3.16-MariaDB : Database - mendumy
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idusr` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `last_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`idusr`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `auth` */

insert  into `auth`(`id`,`idusr`,`username`,`password`,`last_modification`) values 
(1,1,'lefeldnicolas@gmail.com','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','2019-11-26 19:57:24');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values 
(1,'Contaduría');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `course` */

insert  into `course`(`id`,`price`,`name`,`description`,`category`,`creationdate`,`modificationdate`,`imgname`) values 
(1,50,'Curso 1','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(2,100,'Curso 2','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(3,135,'Curso 3','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(4,300,'Curso 4','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(5,100,'Curso 5','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(6,50,'Curso 6','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg'),
(7,100,'Curso 7','Lorem Imptun Inspute Ashen',1,'0000-00-00 00:00:00',NULL,'default.jpg');

/*Table structure for table `courseuser` */

DROP TABLE IF EXISTS `courseuser`;

CREATE TABLE `courseuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idcourse` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `courseuser` */

insert  into `courseuser`(`id`,`idcourse`,`iduser`) values 
(1,1,1),
(2,2,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol` int(11) DEFAULT 1,
  `name` tinytext DEFAULT NULL,
  `lastname` tinytext DEFAULT NULL,
  `legajo` varchar(11) DEFAULT NULL,
  `dni` varchar(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`rol`,`name`,`lastname`,`legajo`,`dni`,`active`) values 
(1,1,'Nicolás','Lefeld','112269',NULL,0);

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
