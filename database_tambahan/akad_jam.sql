# Host: localhost  (Version: 5.5.5-10.1.9-MariaDB)
# Date: 2016-01-10 23:54:39
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "akad_jam"
#

DROP TABLE IF EXISTS `akad_jam`;
CREATE TABLE `akad_jam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `mulai` varchar(10) NOT NULL,
  `selesai` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "akad_jam"
#

INSERT INTO `akad_jam` VALUES (1,'1','3','06.45','07.30');
