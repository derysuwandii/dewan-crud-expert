/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : db_dewankomputer

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 22/09/2020 14:39:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_mahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `tbl_mahasiswa_expert`;
CREATE TABLE `tbl_mahasiswa_expert`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mahasiswa` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_masuk` date NOT NULL,
  `jurusan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `biodata` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_mahasiswa
-- ----------------------------
INSERT INTO `tbl_mahasiswa_expert` VALUES (1, 'Dewan Komputer', 'Cilacap', 'Laki-laki', '2019-01-01', 'Sistem Informasi', '', 'foto/no-image.png');
INSERT INTO `tbl_mahasiswa_expert` VALUES (2, 'Sule', 'Jakarta', 'Laki-laki', '2019-01-01', 'Teknik Informatika', '&lt;p&gt;tes&lt;/p&gt;\r\n', 'foto/no-image.png');
INSERT INTO `tbl_mahasiswa_expert` VALUES (3, 'Maemunah', 'Yogyakarta', 'Perempuan', '2019-01-01', 'Sistem Informasi', '', 'foto/no-image.png');
INSERT INTO `tbl_mahasiswa_expert` VALUES (4, 'Tukul Arwana', 'Surabaya', 'Laki-laki', '2019-01-16', 'Teknik Informatika', '&lt;p&gt;yge&lt;/p&gt;\r\n', 'foto/no-image.png');

SET FOREIGN_KEY_CHECKS = 1;
