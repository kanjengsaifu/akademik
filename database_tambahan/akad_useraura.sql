/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:12:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_useraura
-- ----------------------------
DROP TABLE IF EXISTS `akad_useraura`;
CREATE TABLE `akad_useraura` (
  `UserId` int(15) NOT NULL AUTO_INCREMENT,
  `user` varchar(250) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `avatar` varchar(250) NOT NULL DEFAULT '',
  `level` enum('Administrator','Penjualan','Kasir','Gudang','Accounting','Auditor') NOT NULL DEFAULT 'Administrator',
  `tipe` varchar(250) NOT NULL DEFAULT '',
  `is_online` int(5) NOT NULL DEFAULT '0',
  `last_ping` text NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `exp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `biodata` text NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_useraura
-- ----------------------------
INSERT INTO `akad_useraura` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@elyon.sch.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', '1', '2016-01-11 11:23:05', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>');
INSERT INTO `akad_useraura` VALUES ('28', 'superadmin', 'b11d5ece6353d17f85c5ad30e0a02360', 'rekysda@gmail.com', '', 'Administrator', 'aktif', '1', '2015-03-21 23:05:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
