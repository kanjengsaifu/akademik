# Host: localhost  (Version: 5.5.5-10.1.9-MariaDB)
# Date: 2016-01-10 23:55:13
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "akad_ulangan"
#

DROP TABLE IF EXISTS `akad_ulangan`;
CREATE TABLE `akad_ulangan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "akad_ulangan"
#

INSERT INTO `akad_ulangan` VALUES (1,'Ulangan Harian 1','uh1');
