/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:12:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_ulangan
-- ----------------------------
DROP TABLE IF EXISTS `akad_ulangan`;
CREATE TABLE `akad_ulangan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_ulangan
-- ----------------------------
INSERT INTO `akad_ulangan` VALUES ('1', 'Ulangan Harian 1', 'uh1');
