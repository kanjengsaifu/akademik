/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:11:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_matpel
-- ----------------------------
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

-- ----------------------------
-- Records of akad_matpel
-- ----------------------------
INSERT INTO `akad_matpel` VALUES ('4', 'Matematika', '2', '10', '3', '1', '1');
INSERT INTO `akad_matpel` VALUES ('5', 'Bahasa Indonesia', '0', '2', '1', '1', '2');
