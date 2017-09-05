/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50703
Source Host           : localhost:3306
Source Database       : 20161226

Target Server Type    : MYSQL
Target Server Version : 50703
File Encoding         : 65001

Date: 2016-12-26 12:38:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for student_table
-- ----------------------------
DROP TABLE IF EXISTS `student_table`;
CREATE TABLE `student_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `class` tinyint(4) DEFAULT NULL,
  `name` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student_table
-- ----------------------------
INSERT INTO `student_table` VALUES ('1', '1', '小明');
INSERT INTO `student_table` VALUES ('2', '2', '小红');
INSERT INTO `student_table` VALUES ('3', '1', '小刚');
INSERT INTO `student_table` VALUES ('4', '2', '小华');
INSERT INTO `student_table` VALUES ('5', '3', '小强');
INSERT INTO `student_table` VALUES ('6', '3', '小四');
INSERT INTO `student_table` VALUES ('7', '1', '小刘');
INSERT INTO `student_table` VALUES ('8', '1', '小花');
