/*
Navicat MySQL Data Transfer

Source Server         : lokalmysql
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : sister_siadu

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-01-11 13:11:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for akad_lessonplan
-- ----------------------------
DROP TABLE IF EXISTS `akad_lessonplan`;
CREATE TABLE `akad_lessonplan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `matpel` varchar(10) NOT NULL,
  `tujuan` varchar(512) NOT NULL,
  `target` varchar(215) NOT NULL,
  `jangkawaktu` varchar(215) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of akad_lessonplan
-- ----------------------------
