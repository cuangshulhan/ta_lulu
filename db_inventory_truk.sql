/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100411
Source Host           : localhost:3306
Source Database       : db_inventory_truk

Target Server Type    : MYSQL
Target Server Version : 100411
File Encoding         : 65001

Date: 2022-01-30 02:36:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for generate_number
-- ----------------------------
DROP TABLE IF EXISTS `generate_number`;
CREATE TABLE `generate_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(5) DEFAULT NULL,
  `tahun` varchar(5) DEFAULT '',
  `number` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of generate_number
-- ----------------------------
INSERT INTO `generate_number` VALUES ('2', 'sn', '2022', '11');
INSERT INTO `generate_number` VALUES ('3', 'kpn', '2022', '7');

-- ----------------------------
-- Table structure for m_barang
-- ----------------------------
DROP TABLE IF EXISTS `m_barang`;
CREATE TABLE `m_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barang` varchar(100) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT 0,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_barang
-- ----------------------------
INSERT INTO `m_barang` VALUES ('1', 'Kampas Rem', '1', '4', 'cuang', '2022-01-30 02:14:49', null, '2022-01-30 02:14:49', '1');
INSERT INTO `m_barang` VALUES ('2', 'Kabel', '19', '0', 'cuang', '2022-01-15 11:21:31', 'cuang', '2022-01-15 11:21:31', '0');
INSERT INTO `m_barang` VALUES ('3', 'ShockBreaker', '1', '0', 'cuang', '2022-01-25 16:05:50', null, '2022-01-25 16:05:50', '1');

-- ----------------------------
-- Table structure for m_barang_detail
-- ----------------------------
DROP TABLE IF EXISTS `m_barang_detail`;
CREATE TABLE `m_barang_detail` (
  `no_identitas` varchar(100) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`no_identitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_barang_detail
-- ----------------------------
INSERT INTO `m_barang_detail` VALUES ('12ssww2', '1', 'asasasasasasas', '2022-01-15 10:54:55', '2022-01-15 11:09:38', 'cuang', '2022-01-15 11:09:43', 'cuang', '2022-01-15 11:09:43', '1');
INSERT INTO `m_barang_detail` VALUES ('878sas', '1', 'sasa', '2022-01-15 10:54:55', null, null, '2022-01-23 12:48:18', 'aulia', '2022-01-23 12:48:18', '0');
INSERT INTO `m_barang_detail` VALUES ('eded', '1', 'ededede', '2022-01-15 11:15:48', null, 'cuang', '2022-01-15 11:15:48', null, null, '1');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0003', '1', 'coba dulu', '2022-01-15 15:29:05', '2022-01-30 00:00:00', 'cuang', '2022-01-30 01:50:21', 'aulia', '2022-01-30 01:50:21', '1');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0004', '1', 'tesd lgui', '2022-01-15 16:00:13', '2022-01-30 02:14:49', 'cuang', '2022-01-30 02:14:49', 'aulia', '2022-01-30 02:14:49', '1');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0005', '1', 'qdqdqdqwd', '2022-01-15 16:15:04', null, 'cuang', '2022-01-15 16:15:04', null, null, '1');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0008', '1', '----', '2022-01-23 15:18:58', null, 'aulia', '2022-01-29 12:11:47', 'aulia', '2022-01-29 12:11:47', '1');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0009', '3', 'test', '2022-01-23 15:26:57', null, 'aulia', '2022-01-25 16:05:50', 'aulia', '2022-01-25 16:05:50', '0');
INSERT INTO `m_barang_detail` VALUES ('SN-2022-0010', '1', '-', '2022-01-23 11:03:14', null, 'aulia', '2022-01-29 11:03:14', null, null, '1');

-- ----------------------------
-- Table structure for m_kendaraan
-- ----------------------------
DROP TABLE IF EXISTS `m_kendaraan`;
CREATE TABLE `m_kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plat` varchar(15) DEFAULT NULL,
  `merek` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_kendaraan
-- ----------------------------
INSERT INTO `m_kendaraan` VALUES ('1', 'B 7890 UBM', 'HINO DUTRO', 'TRUK', 'cuang', '2022-01-08 21:43:45', 'cuang', '2022-01-08 15:43:45', '1');
INSERT INTO `m_kendaraan` VALUES ('2', 'B 9867 TMN', 'MITSUBISHI', 'PICKUP1', 'cuang', '2022-01-13 21:56:00', 'cuang', '2022-01-13 15:56:00', '1');
INSERT INTO `m_kendaraan` VALUES ('3', 'qsqs', 'asas', 'asas', 'cuang', '2022-01-13 21:56:10', 'cuang', '2022-01-13 15:56:10', '0');

-- ----------------------------
-- Table structure for m_pemasok
-- ----------------------------
DROP TABLE IF EXISTS `m_pemasok`;
CREATE TABLE `m_pemasok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(50) DEFAULT '',
  `pic` varchar(50) DEFAULT '',
  `npwp` varchar(25) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_pemasok
-- ----------------------------
INSERT INTO `m_pemasok` VALUES ('1', 'PT. ABC', '02134567789', 'Shulhan', '987654321', 'Jl.in Aja Dulu', 'cuang', '2022-01-09 01:53:57', 'cuang', '2022-01-08 19:53:57', '1');
INSERT INTO `m_pemasok` VALUES ('2', 'PT. BCA', '021345677890', 'Cuang', '9876543212', 'Jl. Ah kita', 'cuang', '2022-01-09 02:12:49', 'cuang', '2022-01-08 20:12:49', '1');
INSERT INTO `m_pemasok` VALUES ('3', 'zaz', 'azaz', 'azaz', '121212', 'zazaz', 'cuang', '2022-01-13 21:48:59', 'cuang', '2022-01-13 15:48:59', '0');

-- ----------------------------
-- Table structure for m_pengguna
-- ----------------------------
DROP TABLE IF EXISTS `m_pengguna`;
CREATE TABLE `m_pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT '',
  `fullname` varchar(100) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `rec_id` int(11) DEFAULT 1,
  `created_by` varchar(20) DEFAULT '',
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT '',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_pengguna
-- ----------------------------
INSERT INTO `m_pengguna` VALUES ('2', 'super', '17c4520f6cfd1ab53d8745e84681eb49', 'Super Admin', 'super_admin', '1', '', '2022-01-23 11:59:39', 'super', '2022-01-23 05:59:39');
INSERT INTO `m_pengguna` VALUES ('3', 'soleh', 'c33367701511b4f6020ec61ded352059', 'Soleh Pati', 'manager', '1', '', '2022-01-23 11:59:54', 'super', '2022-01-23 05:59:54');
INSERT INTO `m_pengguna` VALUES ('4', 'budi', 'c33367701511b4f6020ec61ded352059', 'Budi Irawan', 'manager', '1', 'cuang', '2022-01-23 12:00:00', 'super', '2022-01-23 06:00:00');
INSERT INTO `m_pengguna` VALUES ('5', 'aulia', 'c33367701511b4f6020ec61ded352059', 'Aulia Tiara', 'admin', '1', 'cuang', '2022-01-23 12:00:05', 'super', '2022-01-23 06:00:05');

-- ----------------------------
-- Table structure for m_satuan
-- ----------------------------
DROP TABLE IF EXISTS `m_satuan`;
CREATE TABLE `m_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(50) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of m_satuan
-- ----------------------------
INSERT INTO `m_satuan` VALUES ('1', 'pcs', null, '2022-01-08 15:52:57', 'cuang', '2022-01-08 09:52:57', '1');
INSERT INTO `m_satuan` VALUES ('2', 'karton', null, '2022-01-08 16:07:56', 'cuang', '2022-01-08 10:07:56', '1');
INSERT INTO `m_satuan` VALUES ('3', 'test', 'cuang', '2022-01-08 16:16:48', 'cuang', '2022-01-08 10:16:48', '0');
INSERT INTO `m_satuan` VALUES ('4', 'sasas', 'cuang', '2022-01-15 11:21:57', 'cuang', '2022-01-15 05:21:57', '0');
INSERT INTO `m_satuan` VALUES ('5', 'asasas', 'cuang', '2022-01-08 16:16:50', 'cuang', '2022-01-08 10:16:50', '0');
INSERT INTO `m_satuan` VALUES ('6', 'qqq', 'cuang', '2022-01-08 16:20:25', 'cuang', '2022-01-08 10:20:25', '0');
INSERT INTO `m_satuan` VALUES ('7', 'wwww', 'cuang', '2022-01-08 16:17:18', 'cuang', '2022-01-08 10:17:18', '0');
INSERT INTO `m_satuan` VALUES ('8', 'vvvvv', 'cuang', '2022-01-08 16:20:21', 'cuang', '2022-01-08 10:20:21', '0');
INSERT INTO `m_satuan` VALUES ('9', 'ahay', 'cuang', '2022-01-15 11:21:44', 'cuang', '2022-01-15 05:21:44', '0');
INSERT INTO `m_satuan` VALUES ('10', 'qweqwewq', 'cuang', '2022-01-08 16:22:04', 'cuang', '2022-01-08 10:22:04', '0');
INSERT INTO `m_satuan` VALUES ('11', 'sfgdfgfd', 'cuang', '2022-01-08 16:22:06', 'cuang', '2022-01-08 10:22:06', '0');
INSERT INTO `m_satuan` VALUES ('12', 'fdgdfgfd', 'cuang', '2022-01-08 16:22:09', 'cuang', '2022-01-08 10:22:09', '0');
INSERT INTO `m_satuan` VALUES ('13', 'qweqweqw', 'cuang', '2022-01-08 16:22:11', 'cuang', '2022-01-08 10:22:11', '0');
INSERT INTO `m_satuan` VALUES ('14', 'tyjtjtj', 'cuang', '2022-01-08 16:22:15', 'cuang', '2022-01-08 10:22:15', '0');
INSERT INTO `m_satuan` VALUES ('15', 'l.l.lllliiu', 'cuang', '2022-01-08 16:30:40', 'cuang', '2022-01-08 10:30:40', '0');
INSERT INTO `m_satuan` VALUES ('16', 'zzzzzz', 'cuang', '2022-01-13 05:33:37', 'cuang', '2022-01-12 23:33:37', '0');
INSERT INTO `m_satuan` VALUES ('17', 'xxxxx', 'cuang', '2022-01-10 21:24:28', 'cuang', '2022-01-10 15:24:28', '0');
INSERT INTO `m_satuan` VALUES ('18', '', 'cuang', '2022-01-08 21:28:44', 'cuang', '2022-01-08 15:28:44', '0');
INSERT INTO `m_satuan` VALUES ('19', 'meter', 'cuang', '2022-01-15 11:21:54', 'cuang', '2022-01-15 05:21:54', '0');
INSERT INTO `m_satuan` VALUES ('20', 'asasa', 'cuang', '2022-01-15 11:21:52', 'cuang', '2022-01-15 05:21:52', '0');
INSERT INTO `m_satuan` VALUES ('21', 'qwsa', 'cuang', '2022-01-15 11:21:49', 'cuang', '2022-01-15 05:21:49', '0');
INSERT INTO `m_satuan` VALUES ('22', 'zazaz', 'cuang', '2022-01-15 11:21:46', 'cuang', '2022-01-15 05:21:46', '0');

-- ----------------------------
-- Table structure for t_beli_d
-- ----------------------------
DROP TABLE IF EXISTS `t_beli_d`;
CREATE TABLE `t_beli_d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_beli` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `no_identitas` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_beli_d
-- ----------------------------
INSERT INTO `t_beli_d` VALUES ('7', '2', '1', 'SN-2022-0010', '-');

-- ----------------------------
-- Table structure for t_beli_h
-- ----------------------------
DROP TABLE IF EXISTS `t_beli_h`;
CREATE TABLE `t_beli_h` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `faktur_beli` varchar(100) DEFAULT NULL,
  `upload_faktur` text DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_beli_h
-- ----------------------------

-- ----------------------------
-- Table structure for t_pemakaian
-- ----------------------------
DROP TABLE IF EXISTS `t_pemakaian`;
CREATE TABLE `t_pemakaian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  `no_identitas` varchar(255) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pemakaian
-- ----------------------------
INSERT INTO `t_pemakaian` VALUES ('1', '1', '2022-01-28', 'klklklklklkl', 'aulia', '2022-01-29 12:11:47', 'aulia', '2022-01-29 12:11:47', '0', 'SN-2022-0008', '1');
INSERT INTO `t_pemakaian` VALUES ('2', '1', '2022-01-30', '', 'aulia', '2022-01-30 01:50:21', null, null, '1', 'SN-2022-0003', '1');
INSERT INTO `t_pemakaian` VALUES ('3', '2', '2022-01-30', '', 'aulia', '2022-01-30 02:14:49', null, null, '1', 'SN-2022-0004', '1');

-- ----------------------------
-- Table structure for t_pengajuan
-- ----------------------------
DROP TABLE IF EXISTS `t_pengajuan`;
CREATE TABLE `t_pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesan` varchar(255) DEFAULT '',
  `status` varchar(100) DEFAULT 'menunggu' COMMENT '''Menunggu'',''Diterima'',''Ditolak''',
  `tanggal` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `keterangan` text DEFAULT NULL,
  `id_pemimpin` int(11) DEFAULT NULL,
  `tgl_proses` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pengajuan
-- ----------------------------
INSERT INTO `t_pengajuan` VALUES ('3', 'KPN-2022-0006', 'Diterima', '2022-01-23 11:31:19', 'dari saya harganya oke....', '4', '2022-01-23 05:31:19');

-- ----------------------------
-- Table structure for t_pesan_d
-- ----------------------------
DROP TABLE IF EXISTS `t_pesan_d`;
CREATE TABLE `t_pesan_d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesan` varchar(100) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pesan_d
-- ----------------------------
INSERT INTO `t_pesan_d` VALUES ('4', 'KPN-2022-0006', '3', '5', '500000', '2500000', 'test2');

-- ----------------------------
-- Table structure for t_pesan_h
-- ----------------------------
DROP TABLE IF EXISTS `t_pesan_h`;
CREATE TABLE `t_pesan_h` (
  `kode_pesan` varchar(100) NOT NULL,
  `id_toko` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Belum Diajukan' COMMENT '''Belum Diajukan'',''Menunggu'',''Diterima'',''Ditolak''',
  `id_pengguna` int(11) DEFAULT NULL,
  `id_pemimpin` int(11) DEFAULT NULL,
  `catatan_pemimpin` varchar(255) DEFAULT NULL,
  `total_pengajuan` int(11) DEFAULT 0,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `rec_id` int(11) DEFAULT 1,
  PRIMARY KEY (`kode_pesan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of t_pesan_h
-- ----------------------------
INSERT INTO `t_pesan_h` VALUES ('KPN-2022-0003', '1', '2022-01-16', 'test', 'Menunggu', null, null, null, '0', 'cuang', '2022-01-16 11:49:01', null, '2022-01-16 11:49:01', '1');
INSERT INTO `t_pesan_h` VALUES ('KPN-2022-0004', '2', '2022-01-16', 'test2', 'Belum Diajukan', null, null, null, '0', 'cuang', '2022-01-23 12:02:01', 'aulia', '2022-01-23 12:02:01', '0');
INSERT INTO `t_pesan_h` VALUES ('KPN-2022-0005', '1', '2022-01-16', 'test3', 'Belum Diajukan', '0', null, null, '0', 'cuang', '2022-01-23 12:02:03', 'aulia', '2022-01-23 12:02:03', '0');
INSERT INTO `t_pesan_h` VALUES ('KPN-2022-0006', '2', '2022-01-16', 'test  edit', 'Diterima', '5', '4', 'dari saya harganya oke....', '0', 'cuang', '2022-01-23 12:05:09', 'cuang', '2022-01-23 12:05:09', '1');
SET FOREIGN_KEY_CHECKS=1;
