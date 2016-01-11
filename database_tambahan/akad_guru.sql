/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:11:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_guru
-- ----------------------------
DROP TABLE IF EXISTS `akad_guru`;
CREATE TABLE `akad_guru` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(50) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `guru` varchar(50) NOT NULL,
  `sks` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_guru
-- ----------------------------
INSERT INTO `akad_guru` VALUES ('1', '2', '4', '132', '11', '1');
