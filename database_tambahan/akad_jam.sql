/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:11:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_jam
-- ----------------------------
DROP TABLE IF EXISTS `akad_jam`;
CREATE TABLE `akad_jam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `mulai` varchar(10) NOT NULL,
  `selesai` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_jam
-- ----------------------------
INSERT INTO `akad_jam` VALUES ('1', '1', '3', '06.45', '07.30');
