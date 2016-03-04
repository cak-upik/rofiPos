/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : kara

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-01-15 21:18:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `detail_pembelian`
-- ----------------------------
DROP TABLE IF EXISTS `detail_pembelian`;
CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_pembelian` bigint(11) DEFAULT NULL,
  `id_pemesanan_unit` bigint(11) DEFAULT NULL,
  `id_unit` bigint(11) DEFAULT NULL,
  `id_detail_unit` bigint(11) DEFAULT NULL,
  `id_supplier` bigint(11) DEFAULT NULL,
  `kuantitas` varchar(255) DEFAULT NULL,
  `sisa_kuantiti` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detail_pembelian`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detail_pembelian
-- ----------------------------
INSERT INTO `detail_pembelian` VALUES ('47', '38', '1', '1', '1', '1', '3', '0', '');

-- ----------------------------
-- Table structure for `detail_penjualan`
-- ----------------------------
DROP TABLE IF EXISTS `detail_penjualan`;
CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_unit` bigint(11) DEFAULT NULL,
  `id_detail_unit` bigint(11) DEFAULT NULL,
  `id_penjualan` bigint(11) DEFAULT NULL,
  `uang_muka` double(50,0) DEFAULT NULL,
  `diskon` double(50,0) DEFAULT NULL,
  `jumlah` double(50,0) DEFAULT NULL,
  `subsidi` double(50,0) DEFAULT NULL,
  `tambah_subsidi` double(50,0) DEFAULT NULL,
  `real` double(50,0) DEFAULT NULL,
  `profit` double(50,0) DEFAULT NULL,
  `up_price` double(50,0) DEFAULT NULL,
  `diskon_stsj` double(50,0) DEFAULT NULL,
  `insentif` double(50,0) DEFAULT NULL,
  `hadiah` double(50,0) DEFAULT NULL,
  `jaket` double(50,0) DEFAULT NULL,
  `lain_lain` double(50,0) DEFAULT NULL,
  `bonus` double(50,0) DEFAULT NULL,
  `laba_kotor` double(100,0) DEFAULT NULL,
  `average` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detail_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detail_penjualan
-- ----------------------------
INSERT INTO `detail_penjualan` VALUES ('2', '2', '2', '2', '0', '0', '17700000', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `detail_penjualan` VALUES ('3', '1', '4', '3', '2000000', '1000000', '12300000', '1000000', '2000000', '1900000', '200000', '20000', '520000', '20000', '20000', '10000', '20000', '2000', '1708000', '557714.2857142857');

-- ----------------------------
-- Table structure for `login`
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id_login` int(30) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of login
-- ----------------------------

-- ----------------------------
-- Table structure for `pembelian`
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian` (
  `id_pembelian` bigint(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_pembelian`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES ('38', 'PJ-15012015-01', '2015-01-15');

-- ----------------------------
-- Table structure for `penjualan`
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan` (
  `id_penjualan` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(11) DEFAULT NULL,
  `id_leasing` bigint(11) DEFAULT NULL,
  `no_faktur` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `subtotal_penjualan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
INSERT INTO `penjualan` VALUES ('1', '1', '8', 'FA-15012015-00', '2015-01-15', '26200000');
INSERT INTO `penjualan` VALUES ('2', '1', '8', 'FA-15012015-01', '2015-01-15', '35400000');
INSERT INTO `penjualan` VALUES ('3', '1', '8', 'FA-15012015-02', '2015-01-15', '24600000');

-- ----------------------------
-- Table structure for `ref_biaya_sr`
-- ----------------------------
DROP TABLE IF EXISTS `ref_biaya_sr`;
CREATE TABLE `ref_biaya_sr` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `fotocopy` int(20) DEFAULT NULL,
  `lainlain` int(20) DEFAULT NULL,
  `iklan` int(20) DEFAULT NULL,
  `konsumsi` int(20) DEFAULT NULL,
  `bahanbakar` int(20) DEFAULT NULL,
  `atk` int(20) DEFAULT NULL,
  `parkir_tol` int(20) DEFAULT NULL,
  `keamanan` int(20) DEFAULT NULL,
  `minuman` int(20) DEFAULT NULL,
  `rektelp` int(20) DEFAULT NULL,
  `rekair` int(20) DEFAULT NULL,
  `listrik` int(20) DEFAULT NULL,
  `komisi` int(20) DEFAULT NULL,
  `gaji` int(20) DEFAULT NULL,
  `pajak` int(20) DEFAULT NULL,
  `sumbangan` int(20) DEFAULT NULL,
  `pemeliharaan` int(20) DEFAULT NULL,
  `materai` int(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_biaya_sr
-- ----------------------------
INSERT INTO `ref_biaya_sr` VALUES ('6', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', '9000', null);
INSERT INTO `ref_biaya_sr` VALUES ('7', '798770000', '21464700', '2164700', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', '2147483647', null);
INSERT INTO `ref_biaya_sr` VALUES ('8', '798770000', '214748300', '248364700', '78299900', '9289800', '78278800', '2874800', '83472800', '3847800', '23897200', '384900', '8343700', '7843700', '83743800', '87385700', '38752700', '73737300', '62600', null);
INSERT INTO `ref_biaya_sr` VALUES ('9', '90000000', '0', '0', '0', '0', '0', '0', '0', '100000', '0', '0', '0', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `ref_biaya_sr` VALUES ('10', '31', '2', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '11', null);
INSERT INTO `ref_biaya_sr` VALUES ('11', '100000', '10000', '100001', '1000', '1000', '900000', '90000', '80000', '80000', '7999', '78999', '7880', '79800', '80880', '89700', '78980', '78080', '878989', '0000-00-00');
INSERT INTO `ref_biaya_sr` VALUES ('12', '98900', '89000', '88000', '890000', '8900900', '9900009', '98', '980', '989', '8989', '8798798', '8987897', '897987', '8979', '79797', '9788978', '7987', '798798', '2015-01-14');

-- ----------------------------
-- Table structure for `ref_biayapenj`
-- ----------------------------
DROP TABLE IF EXISTS `ref_biayapenj`;
CREATE TABLE `ref_biayapenj` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `byJaket` int(20) NOT NULL,
  `byFaktur` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_biayapenj
-- ----------------------------

-- ----------------------------
-- Table structure for `ref_color`
-- ----------------------------
DROP TABLE IF EXISTS `ref_color`;
CREATE TABLE `ref_color` (
  `id_color` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  PRIMARY KEY (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_color
-- ----------------------------
INSERT INTO `ref_color` VALUES ('1', 'Putih');
INSERT INTO `ref_color` VALUES ('2', 'Merah');
INSERT INTO `ref_color` VALUES ('3', 'Kuning');
INSERT INTO `ref_color` VALUES ('4', 'Hitam');
INSERT INTO `ref_color` VALUES ('8', 'Biru');
INSERT INTO `ref_color` VALUES ('9', 'Orange');

-- ----------------------------
-- Table structure for `ref_customer`
-- ----------------------------
DROP TABLE IF EXISTS `ref_customer`;
CREATE TABLE `ref_customer` (
  `id_customer` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `no_ktp` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pekerjaan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_customer
-- ----------------------------
INSERT INTO `ref_customer` VALUES ('1', 'Angga Sebastian', 'Ds Sawotratap', 'Ds Sawotratap', '12222122', 'sby', '1999-10-10', 'Swasta');
INSERT INTO `ref_customer` VALUES ('2', 'dedy', 'jkt', 'jkt', '1111111', 'sby', '1999-10-10', 'Swasta');
INSERT INTO `ref_customer` VALUES ('3', 'Intan Agustina', 'Jl. Kebayoran', '085689237574', '29324986', 'Surabaya', '1992-08-17', 'Mahasiswa');
INSERT INTO `ref_customer` VALUES ('4', 'M. Rizky S', 'Jl. Kebonrejo S', '086494267295', '21474', 'Sby', '1991-09-04', 'Swasta');
INSERT INTO `ref_customer` VALUES ('5', 'coba', 'cobacoba', '089756483909', '214', 'Surabaya', '1992-02-09', 'dokter');
INSERT INTO `ref_customer` VALUES ('7', 'as', 'sb', '0847446', '22', 'sby', '2014-11-03', 'pns');
INSERT INTO `ref_customer` VALUES ('8', 'hinnza', 'sby', '0876566441', '144897419271', 'sby', '2014-11-10', 'swasta');
INSERT INTO `ref_customer` VALUES ('9', 'bb', 'ss', '203948', '293842008', 'sby', '2014-11-25', 'aaa');

-- ----------------------------
-- Table structure for `ref_leasing`
-- ----------------------------
DROP TABLE IF EXISTS `ref_leasing`;
CREATE TABLE `ref_leasing` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  `addres` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subLeasing` int(20) NOT NULL,
  `insentiveLeasing` int(20) NOT NULL,
  `subAdd` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_leasing
-- ----------------------------
INSERT INTO `ref_leasing` VALUES ('1', 'OTO', 'asda', '234324', '700000', '200000', '100000');
INSERT INTO `ref_leasing` VALUES ('7', 'BAF', 'dldsf', '081357690654', '1000000', '1000000', '1000000');
INSERT INTO `ref_leasing` VALUES ('8', 'ADIRA', 'CCSDC', '081357690654', '1000000', '1000000', '1000000');
INSERT INTO `ref_leasing` VALUES ('9', 'AXA', 'sby', '08476280', '80000', '100000', '750000');

-- ----------------------------
-- Table structure for `ref_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `ref_supplier`;
CREATE TABLE `ref_supplier` (
  `id_supplier` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `addres` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_supplier
-- ----------------------------
INSERT INTO `ref_supplier` VALUES ('1', 'PT. Surya Timur Sakti Jatim', 'Jl. Basuki Rahmat', '31531212');

-- ----------------------------
-- Table structure for `sisa_po`
-- ----------------------------
DROP TABLE IF EXISTS `sisa_po`;
CREATE TABLE `sisa_po` (
  `id_sisa_kirim` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_pemesanan_unit` bigint(11) DEFAULT NULL,
  `id_pembelian` bigint(11) DEFAULT NULL,
  `id_detail_pembelian` bigint(11) DEFAULT NULL,
  `sisa_order` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_sisa_kirim`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sisa_po
-- ----------------------------
INSERT INTO `sisa_po` VALUES ('1', '1', '1', '1', '4');

-- ----------------------------
-- Table structure for `stok`
-- ----------------------------
DROP TABLE IF EXISTS `stok`;
CREATE TABLE `stok` (
  `id_stok` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_pembelian` bigint(11) DEFAULT NULL,
  `id_pemesanan_unit` bigint(11) DEFAULT NULL,
  `id_penjualan` bigint(11) DEFAULT NULL,
  `jumlah_pemesanan_unit` varchar(100) DEFAULT NULL,
  `jumlah_penjualan_unit` varchar(100) DEFAULT NULL,
  `jumlah_pembelian_unit` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_stok`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stok
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_detail_hak_akses`
-- ----------------------------
DROP TABLE IF EXISTS `tb_detail_hak_akses`;
CREATE TABLE `tb_detail_hak_akses` (
  `id_jabatan` int(2) NOT NULL,
  `id_hak_akses` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan`,`id_hak_akses`),
  KEY `fk_tb_jabatan_has_tb_hak_akses_tb_hak_akses1_idx` (`id_hak_akses`),
  KEY `fk_tb_jabatan_has_tb_hak_akses_tb_jabatan1_idx` (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_detail_hak_akses
-- ----------------------------
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('3', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '1');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('3', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '2');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '6');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '6');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '6');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '6');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '7');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '8');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '8');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '8');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '8');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '8');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '9');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '9');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '9');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '9');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '10');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '10');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '10');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '10');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '11');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '11');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '12');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '13');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '14');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '15');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '15');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '15');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '15');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '15');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '16');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '16');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '16');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '16');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '16');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '17');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '17');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '17');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '18');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '18');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '18');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '19');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '19');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '19');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '20');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '21');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '22');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '22');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '22');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '23');
INSERT INTO `tb_detail_hak_akses` VALUES ('5', '23');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '23');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '23');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '24');
INSERT INTO `tb_detail_hak_akses` VALUES ('1', '25');
INSERT INTO `tb_detail_hak_akses` VALUES ('4', '25');
INSERT INTO `tb_detail_hak_akses` VALUES ('7', '25');
INSERT INTO `tb_detail_hak_akses` VALUES ('8', '25');

-- ----------------------------
-- Table structure for `tb_detail_pemesanan_unit`
-- ----------------------------
DROP TABLE IF EXISTS `tb_detail_pemesanan_unit`;
CREATE TABLE `tb_detail_pemesanan_unit` (
  `id_detail_pemesanan_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_unit` int(11) NOT NULL,
  `id_pemesanan_unit` int(11) NOT NULL,
  `kuantitas` bigint(6) NOT NULL,
  `sisa_kuantitas` bigint(11) DEFAULT '0',
  `harga` bigint(12) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_detail_pemesanan_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_detail_pemesanan_unit
-- ----------------------------
INSERT INTO `tb_detail_pemesanan_unit` VALUES ('1', '1', '1', '6', '3', '1000000', '');
INSERT INTO `tb_detail_pemesanan_unit` VALUES ('2', '2', '2', '10', '0', '2000000', '');
INSERT INTO `tb_detail_pemesanan_unit` VALUES ('3', '1', '3', '3', '0', '13000000', '');
INSERT INTO `tb_detail_pemesanan_unit` VALUES ('4', '2', '3', '5', '0', '10000000', '');
INSERT INTO `tb_detail_pemesanan_unit` VALUES ('5', '4', '3', '10', '0', '13500000', '');

-- ----------------------------
-- Table structure for `tb_detail_stok_masuk`
-- ----------------------------
DROP TABLE IF EXISTS `tb_detail_stok_masuk`;
CREATE TABLE `tb_detail_stok_masuk` (
  `id_sparepart` int(11) NOT NULL,
  `id_stok_masuk` int(11) NOT NULL,
  `kuantitas` double(6,2) NOT NULL,
  PRIMARY KEY (`id_sparepart`,`id_stok_masuk`),
  KEY `fk_tb_sparepart_has_tb_stok_masuk_tb_stok_masuk1_idx` (`id_stok_masuk`),
  KEY `fk_tb_sparepart_has_tb_stok_masuk_tb_sparepart1_idx` (`id_sparepart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_detail_stok_masuk
-- ----------------------------
INSERT INTO `tb_detail_stok_masuk` VALUES ('17', '6', '3.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('22', '7', '2.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('28', '8', '6.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('29', '8', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('29', '9', '2.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('33', '14', '12.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('45', '8', '3.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('49', '12', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('52', '9', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('57', '8', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('61', '10', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('62', '10', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('63', '10', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('64', '10', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('66', '12', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('67', '10', '4.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('68', '12', '8.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('70', '12', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('71', '12', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('72', '12', '5.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('73', '11', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('74', '11', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('75', '11', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('76', '11', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('77', '11', '10.00');
INSERT INTO `tb_detail_stok_masuk` VALUES ('131', '12', '8.00');

-- ----------------------------
-- Table structure for `tb_detail_unit`
-- ----------------------------
DROP TABLE IF EXISTS `tb_detail_unit`;
CREATE TABLE `tb_detail_unit` (
  `id_detail_unit` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_unit` bigint(11) DEFAULT NULL,
  `id_color` bigint(11) DEFAULT NULL,
  `no_rangka` varchar(255) DEFAULT NULL,
  `no_mesin` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `hargaotr` varchar(255) DEFAULT NULL,
  `hargabeli` varchar(255) DEFAULT NULL,
  `hargakosongan` varchar(255) DEFAULT NULL,
  `plafonbbn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detail_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_detail_unit
-- ----------------------------
INSERT INTO `tb_detail_unit` VALUES ('1', '2', '3', '1234567788', '83749457758', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('2', '2', '2', '84849', '83884X', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('3', '2', '1', '8474997', '383939', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('4', '1', '8', '3739', '38383', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('5', '1', '9', '8393937', '38339', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('6', '1', '1', '8847589', '484994', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('7', '4', '2', '948499', '4849494', '2014', null, null, null, null);
INSERT INTO `tb_detail_unit` VALUES ('8', '4', '8', '84789', '895939', '2014', null, null, null, null);

-- ----------------------------
-- Table structure for `tb_expired_link`
-- ----------------------------
DROP TABLE IF EXISTS `tb_expired_link`;
CREATE TABLE `tb_expired_link` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `linkkey` varchar(50) NOT NULL,
  `expires` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `linkkey` (`linkkey`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_expired_link
-- ----------------------------
INSERT INTO `tb_expired_link` VALUES ('1', 'bWlmdGFzcEBnbWFpbC5jb218fDEzODcxODIwNTE=', '1387268460');
INSERT INTO `tb_expired_link` VALUES ('2', 'bWlmdGFzcEBnbWFpbC5jb218fDEzODcxODI1Mjk=', '1387268938');
INSERT INTO `tb_expired_link` VALUES ('3', 'bWlmdGFzcDcwQGdtYWlsLmNvbXx8MTM4OTkyOTk5MQ==', '1390016397');
INSERT INTO `tb_expired_link` VALUES ('4', 'bWlmdGFzcDcwQGdtYWlsLmNvbXx8MTM4OTkzMTA0Mw==', '1390017449');
INSERT INTO `tb_expired_link` VALUES ('5', 'bWlmdGFzcDcwQGdtYWlsLmNvbXx8MTM4OTkzMjczNQ==', '1390019145');

-- ----------------------------
-- Table structure for `tb_hak_akses`
-- ----------------------------
DROP TABLE IF EXISTS `tb_hak_akses`;
CREATE TABLE `tb_hak_akses` (
  `id_hak_akses` int(11) NOT NULL AUTO_INCREMENT,
  `hak_akses` varchar(45) NOT NULL,
  PRIMARY KEY (`id_hak_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_hak_akses
-- ----------------------------
INSERT INTO `tb_hak_akses` VALUES ('1', 'kelola_stok');
INSERT INTO `tb_hak_akses` VALUES ('2', 'kelola_master_leasing');
INSERT INTO `tb_hak_akses` VALUES ('6', 'kelola_master_suplier');
INSERT INTO `tb_hak_akses` VALUES ('7', 'kelola_master_unit');
INSERT INTO `tb_hak_akses` VALUES ('8', 'kelola_master_color');
INSERT INTO `tb_hak_akses` VALUES ('9', 'kelola_master_pegawai');
INSERT INTO `tb_hak_akses` VALUES ('10', 'kelola_master_jabatan');
INSERT INTO `tb_hak_akses` VALUES ('11', 'kelola_master_privilege');
INSERT INTO `tb_hak_akses` VALUES ('12', 'kelola_master_hak_akses');
INSERT INTO `tb_hak_akses` VALUES ('13', 'kelola_operasional_customer');
INSERT INTO `tb_hak_akses` VALUES ('14', 'kelola_operasional_pemesanan_unit');
INSERT INTO `tb_hak_akses` VALUES ('16', 'kelola_operasional_pembelian');
INSERT INTO `tb_hak_akses` VALUES ('17', 'kelola_biayasr');
INSERT INTO `tb_hak_akses` VALUES ('18', 'kelola_stok_masuk');
INSERT INTO `tb_hak_akses` VALUES ('19', 'kelola_stok_master');
INSERT INTO `tb_hak_akses` VALUES ('20', 'kelola_laporan_penjualan');
INSERT INTO `tb_hak_akses` VALUES ('21', 'kelola_laporan_pembelian');
INSERT INTO `tb_hak_akses` VALUES ('22', 'kelola_laporan_labarugi');
INSERT INTO `tb_hak_akses` VALUES ('23', 'kelola_operasional_penjualan');
INSERT INTO `tb_hak_akses` VALUES ('24', 'kelola_hrd_absensi');
INSERT INTO `tb_hak_akses` VALUES ('25', 'kelola_detail_unit');

-- ----------------------------
-- Table structure for `tb_jabatan`
-- ----------------------------
DROP TABLE IF EXISTS `tb_jabatan`;
CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(2) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(45) NOT NULL,
  `gaji_pokok` bigint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_jabatan
-- ----------------------------
INSERT INTO `tb_jabatan` VALUES ('1', 'Administrasi', '1710000');
INSERT INTO `tb_jabatan` VALUES ('2', 'Pimpinan', '3500000');
INSERT INTO `tb_jabatan` VALUES ('3', 'HRD', '2000000');
INSERT INTO `tb_jabatan` VALUES ('7', 'Owner', '0');

-- ----------------------------
-- Table structure for `tb_labarugi`
-- ----------------------------
DROP TABLE IF EXISTS `tb_labarugi`;
CREATE TABLE `tb_labarugi` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `tb_penjualan_id` int(30) NOT NULL,
  `tb_pembelian_id` int(30) DEFAULT NULL,
  `ref_biayaPenj_id` int(30) NOT NULL,
  `ref_biayaSr_id` int(30) NOT NULL,
  `realBbn` int(20) NOT NULL,
  `profitBbn` int(20) NOT NULL,
  `uppingpriceBbn` int(20) NOT NULL,
  `labaKotor` int(20) NOT NULL,
  `avgProfit` int(20) NOT NULL,
  `labaNett` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_labarugi_ref_biayapenj_1` (`ref_biayaPenj_id`),
  KEY `fk_tb_labarugi_ref_biaya_sr_1` (`ref_biayaSr_id`),
  CONSTRAINT `fk_tb_labarugi_ref_biayapenj_1` FOREIGN KEY (`ref_biayaPenj_id`) REFERENCES `ref_biayapenj` (`id`),
  CONSTRAINT `fk_tb_labarugi_ref_biaya_sr_1` FOREIGN KEY (`ref_biayaSr_id`) REFERENCES `ref_biaya_sr` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_labarugi
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_pegawai`
-- ----------------------------
DROP TABLE IF EXISTS `tb_pegawai`;
CREATE TABLE `tb_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(45) NOT NULL,
  `alamat` text NOT NULL,
  `tempat` varchar(45) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(70) NOT NULL,
  `id_jabatan` int(2) NOT NULL,
  `foto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`),
  KEY `fk_tb_pegawai_tb_jabatan2_idx` (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_pegawai
-- ----------------------------
INSERT INTO `tb_pegawai` VALUES ('2', 'Ivonne Lusitamia Achmad', 'Jln. Driyorejo 265 Gresik', 'Sidoarjo', '1992-06-09', '7592788', 'miftasp70@gmail.com', 'ivonne', 'NTQ2MjEz', '4', '1381926645.jpg');
INSERT INTO `tb_pegawai` VALUES ('5', 'Huda Anugerah', 'Jln. Melati 27 Sidoarjo', 'Makassar', '1990-08-21', '81456789', '-', 'huda', 'MTIzNDU2', '3', null);
INSERT INTO `tb_pegawai` VALUES ('6', 'Titik Pusparani', 'Jln. Tenaru 12 Gresik', 'Gresik', '1988-02-27', '85730104905', '-', 'titikp', 'MTIzNDU2', '1', '1378368136.jpg');
INSERT INTO `tb_pegawai` VALUES ('7', 'Cokok Hendratmo', 'Jln. Cangkir - Gresik', 'Gresik', '1987-10-08', '8123045698', '-', 'Cokok', 'MTIzNDU2', '1', '1385265021.jpg');
INSERT INTO `tb_pegawai` VALUES ('8', 'Kirana Damayanti', 'Perum. Kota Baru Driyorejo - Gresik', 'Surabaya', '1990-12-04', '811342844', 'kiranad@ymail.com', 'kirana', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('9', 'Eko Prasetya', 'Dsn Cangkir rt 17 rw 4', 'Surabaya', '1989-02-26', '8212369758', 'eko_prst@ymail.com', 'ekopras', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('10', 'Ida Lidyawati', 'Dsn. Krikilan - Driyorejo', 'Sumenep', '1992-11-21', '85640104951', 'idalid@yahoo.co.id', 'idalid', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('11', 'Rachmad Cahyadi', 'Jln. Tenaru rt 08 rw 03', 'Sidoarjo', '1980-05-26', '3178254944', '-', 'rachmad', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('12', 'Syaiful Anwar', 'Jln. Biduri Pandan 5 KotaBaru Driyorejo', 'Mojokerto', '1975-01-05', '81330254598', 'syaifulanwar@gmail.com', 'syaiful', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('13', 'Lukman Wijanarko', 'Jln. Bambe', 'Bojonegoro', '1975-08-12', '3178126000', '-', 'lukmanwi', 'MTIzNDU2', '1', null);
INSERT INTO `tb_pegawai` VALUES ('14', 'Ikarana', 'Jl. Karang Rejo Timur 1 / 40', 'Surabaya', '1992-10-29', '83857193429', 'kara.na2906@gmail.com', 'ikarana', 'aWthcmFuYTEyMzQ1', '7', '1403011516.jpg');
INSERT INTO `tb_pegawai` VALUES ('17', 'adu', 'asaaa', 'dek', '0000-00-00', '0927478939', 'choyyima.aja@gmail.com', 'root', 'cm9vdA==', '7', null);

-- ----------------------------
-- Table structure for `tb_pembelian`
-- ----------------------------
DROP TABLE IF EXISTS `tb_pembelian`;
CREATE TABLE `tb_pembelian` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `no_beli` varchar(15) DEFAULT NULL,
  `tb_unit_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `noRangka` int(18) NOT NULL,
  `noMesin` int(18) NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `id_color` int(20) DEFAULT NULL,
  `ref_supplier_id` int(30) NOT NULL,
  `qty` int(100) DEFAULT NULL,
  `total` bigint(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_pembelian
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_pemesanan_unit`
-- ----------------------------
DROP TABLE IF EXISTS `tb_pemesanan_unit`;
CREATE TABLE `tb_pemesanan_unit` (
  `id_pemesanan_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(11) NOT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_detail_pemesanan_unit` int(11) DEFAULT NULL,
  `no_faktur` varchar(18) NOT NULL,
  `tanggal` date NOT NULL,
  `kuantitas` int(20) NOT NULL,
  `jumlah_tagihan` double(20,2) NOT NULL,
  PRIMARY KEY (`id_pemesanan_unit`),
  KEY `fk_tb_pemesanan_stok_tb_pegawai_idx` (`id_pegawai`),
  KEY `fk_tb_pemesanan_stok_tb_suplier1_idx` (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_pemesanan_unit
-- ----------------------------
INSERT INTO `tb_pemesanan_unit` VALUES ('1', '1', '1', '14', '1', 'PO-13012015-00', '2015-01-13', '0', '0.00');
INSERT INTO `tb_pemesanan_unit` VALUES ('2', '1', '2', '14', '2', 'PO-13012015-01', '2015-01-13', '0', '0.00');
INSERT INTO `tb_pemesanan_unit` VALUES ('3', '1', '2', '14', '4', 'PO-14012015-02', '2015-01-14', '0', '224000000.00');

-- ----------------------------
-- Table structure for `tb_penjualan`
-- ----------------------------
DROP TABLE IF EXISTS `tb_penjualan`;
CREATE TABLE `tb_penjualan` (
  `id_penjualan` int(30) NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(30) DEFAULT NULL,
  `id_pembelian` bigint(30) DEFAULT NULL,
  `id_unit` bigint(30) DEFAULT NULL,
  `id_detail_unit` bigint(30) DEFAULT NULL,
  `id_leasing` int(30) DEFAULT NULL,
  `no_jual` varchar(15) DEFAULT NULL,
  `date` date NOT NULL,
  `hargaotr` int(20) DEFAULT NULL,
  `kuantiti` int(20) DEFAULT NULL,
  `uangmuka` int(20) DEFAULT NULL,
  `disc` int(20) NOT NULL,
  `nett` int(20) NOT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_penjualan
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_stok`
-- ----------------------------
DROP TABLE IF EXISTS `tb_stok`;
CREATE TABLE `tb_stok` (
  `id_stok` int(11) NOT NULL AUTO_INCREMENT,
  `id_sparepart` int(11) NOT NULL,
  `jumlah_stok` bigint(5) NOT NULL DEFAULT '0',
  `harga_jual_satuan` bigint(6) NOT NULL,
  `keterangan` text CHARACTER SET utf8,
  PRIMARY KEY (`id_stok`),
  KEY `fk_tb_stok_tb_sparepart1_idx` (`id_sparepart`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_stok
-- ----------------------------
INSERT INTO `tb_stok` VALUES ('1', '3', '2', '259000', ' ');
INSERT INTO `tb_stok` VALUES ('2', '4', '2', '432000', ' ');

-- ----------------------------
-- Table structure for `tb_unit`
-- ----------------------------
DROP TABLE IF EXISTS `tb_unit`;
CREATE TABLE `tb_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `hargakosongan` varchar(100) DEFAULT NULL,
  `plafonbbn` varchar(100) DEFAULT NULL,
  `hargaotr` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_unit
-- ----------------------------
INSERT INTO `tb_unit` VALUES ('1', 'SOUL GT', '13000000', '2300000', '15300000');
INSERT INTO `tb_unit` VALUES ('2', 'MIO GT', '15500000', '2200000', '17700000');
INSERT INTO `tb_unit` VALUES ('3', 'New Vixion', '20000000', '3200000', '23200000');
INSERT INTO `tb_unit` VALUES ('4', 'XEON RC', '14500000', '2100000', '16600000');

-- ----------------------------
-- View structure for `query_stok'e kara`
-- ----------------------------
DROP VIEW IF EXISTS `query_stok'e kara`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_stok'e kara` kara` AS select count(`dp`.`id_pembelian`) AS `tumbas`,(select count(`dpe`.`id_detail_penjualan`) AS `jual` from `detail_penjualan` `dpe`) AS `menjual` from `detail_pembelian` `dp` ;
