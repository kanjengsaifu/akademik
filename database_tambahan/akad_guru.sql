# Host: localhost  (Version: 5.5.5-10.1.9-MariaDB)
# Date: 2016-01-10 23:54:29
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "akad_guru"
#

DROP TABLE IF EXISTS `akad_guru`;
CREATE TABLE `akad_guru` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(50) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `guru` varchar(50) NOT NULL,
  `sks` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "akad_guru"
#

INSERT INTO `akad_guru` VALUES (1,'2','4','132','11','1');
