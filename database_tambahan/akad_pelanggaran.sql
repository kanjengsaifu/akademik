/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:12:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_pelanggaran
-- ----------------------------
DROP TABLE IF EXISTS `akad_pelanggaran`;
CREATE TABLE `akad_pelanggaran` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(215) NOT NULL,
  `point` varchar(215) NOT NULL,
  `hukuman` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_pelanggaran
-- ----------------------------
