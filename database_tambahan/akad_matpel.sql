# Host: localhost  (Version: 5.5.5-10.1.9-MariaDB)
# Date: 2016-01-10 23:54:54
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "akad_matpel"
#

DROP TABLE IF EXISTS `akad_matpel`;
CREATE TABLE `akad_matpel` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `sks` varchar(10) NOT NULL,
  `slot` varchar(10) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kuota` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Data for table "akad_matpel"
#

INSERT INTO `akad_matpel` VALUES (4,'Matematika','2','10','3','1','1'),(5,'Bahasa Indonesia','0','2','1','1','2');
