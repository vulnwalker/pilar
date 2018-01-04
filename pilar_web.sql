-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `acara`;
CREATE TABLE `acara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_acara` text NOT NULL,
  `tanggal` text NOT NULL,
  `jam` text NOT NULL,
  `lokasi` text NOT NULL,
  `deskripsi` text NOT NULL,
  `koordinat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `acara` (`id`, `nama_acara`, `tanggal`, `jam`, `lokasi`, `deskripsi`, `koordinat`) VALUES
(5,	'Seminar Facebook',	'2018-01-02',	'08:00',	'Jl. Ir. H.Djuanda No.86, Lebakgede, Coblong, Kota Bandung, Jawa Barat 40132, Indonesia',	'<p>Seminar hahhashah shasha</p><p>sadasd</p><p>&nbsp;asdjsad</p><p>asd asd</p>',	'-6.896551151174962, 107.61304199695587'),
(6,	'Seminar GOogle dev fest',	'2018-01-02',	'04:00',	'Bandung',	'<p>hasha&nbsp;</p><p>dsad</p><p>&nbsp;sad</p><p>&nbsp;asd</p><p>sa d</p><p>s</p><p>adsa</p>',	'-25.7238055,28.2472399'),
(15,	'Ubah',	'2017-12-27',	'04:47',	'jl madhapi no 8',	'\n                                                                \n                                                                                                                  ',	'-6.9102532,107.6350995');

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `email` text COLLATE latin1_general_ci NOT NULL,
  `nama` text COLLATE latin1_general_ci NOT NULL,
  `hak_akses` text COLLATE latin1_general_ci NOT NULL,
  `status` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `nama`, `hak_akses`, `status`) VALUES
(2,	'kszxpo',	'319949ab1252fc41bf437c3dea2859bdd1cad966',	'vulnwalker@tuyul.online',	'VulnWalker',	'',	'1');

DROP TABLE IF EXISTS `general_setting`;
CREATE TABLE `general_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` text NOT NULL,
  `option_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `general_setting` (`id`, `option_name`, `option_value`) VALUES
(1,	'informasi_title',	'Informasi 2;TEXT;LEFT'),
(2,	'produk_title',	'Produk 2;TEXT;RIGHT'),
(3,	'acara_title',	'Acara ;TEXT;CENTER'),
(4,	'informasi_background',	'#000000'),
(5,	'produk_background',	'#50951b'),
(6,	'acara_background',	'#c03b3b');

DROP TABLE IF EXISTS `informasi`;
CREATE TABLE `informasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `isi_informasi` text NOT NULL,
  `tanggal_create` text NOT NULL,
  `jam_create` text NOT NULL,
  `tanggal_update` text NOT NULL,
  `jam_update` text NOT NULL,
  `penulis` text NOT NULL,
  `status` text NOT NULL,
  `jumlah_baca` text NOT NULL,
  `posisi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `informasi` (`id`, `judul`, `isi_informasi`, `tanggal_create`, `jam_create`, `tanggal_update`, `jam_update`, `penulis`, `status`, `jumlah_baca`, `posisi`) VALUES
(3,	'Membersihkan Cahe DNS pada Linux 2',	'<p><strong>Membersihkan Cahe DNS pada Linux</strong></p>',	'2017-12-30',	'03:47',	'2017-12-30',	'03:47',	'VulnWalker',	'2',	'',	'2');

DROP TABLE IF EXISTS `kontak_web`;
CREATE TABLE `kontak_web` (
  `nama_perusahaan` text NOT NULL,
  `alamat` text NOT NULL,
  `telepon` text NOT NULL,
  `email` text NOT NULL,
  `media_sosial` text NOT NULL,
  `tentang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `kontak_web` (`nama_perusahaan`, `alamat`, `telepon`, `email`, `media_sosial`, `tentang`) VALUES
('PT. Pilar Wahana Artha',	'Jl. Junaedi No.6',	'(022) 87240297',	'office@pilar.web.id',	'{\"facebook\":\"plar\",\"twiter\":\"-\",\"instagram\":\"pilarwahanaartha\",\"line\":\"pilarwahanaartha\",\"bbm\":\"\",\"whatsapp\":\"085230817475\"}',	'PT pilar adalah perusahan yang bergerak di bidang Teknologi Informasi');

DROP TABLE IF EXISTS `lamaran`;
CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `telepon` text NOT NULL,
  `about` text NOT NULL,
  `cv` text NOT NULL,
  `id_lowongan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `lowongan_kerja`;
CREATE TABLE `lowongan_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posisi` text NOT NULL,
  `pendidikan` text NOT NULL,
  `salary` text NOT NULL,
  `jam_kerja` text NOT NULL,
  `pengalaman` text NOT NULL,
  `deskripsi` text NOT NULL,
  `spesifikasi` text NOT NULL,
  `usia` text NOT NULL,
  `gender` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `lowongan_kerja` (`id`, `posisi`, `pendidikan`, `salary`, `jam_kerja`, `pengalaman`, `deskripsi`, `spesifikasi`, `usia`, `gender`) VALUES
(1,	'4',	'1;3;5',	'2000000-2500000',	'FULL TIME',	'4',	'\n                                                              \n                                                              \n                                                              \n                                                              \n                                                              - Membuat web lah pekok\n- Mengintegrasikan khayalan jadi nyata                                                                                                                                                                                                                                                                                                                      ',	'- Bisa ngoding lah\n- Menguasai bahasa pemograman brainfuck dan malboge\n- Mampu bekerja di bawah kursi',	'',	''),
(3,	'5',	'1',	'2000000-5000000',	'FULL TIME',	'0-10',	'                                                                    <h3> asdas',	'bikin a\r\nbikin b',	'18-40',	'3');

DROP TABLE IF EXISTS `pesan_kontak`;
CREATE TABLE `pesan_kontak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `no_telepon` int(11) NOT NULL,
  `pesan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` text NOT NULL,
  `image_title` text NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` text NOT NULL,
  `status` text NOT NULL,
  `screen_shot` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `produk` (`id`, `nama_produk`, `image_title`, `deskripsi`, `tanggal`, `status`, `screen_shot`) VALUES
(3,	'ATISISBADA',	'images/produk/ATISISBADA/title.jpg',	'\n                                                              \n                                                              sdsd sdsd                                                            ',	'2017-12-31',	'1',	'[{\"fileName\":\"images/produk/ATISISBADA/b67f43db2a04b24412c7383d1337377e.jpg\",\"desc\":\"seeing things from\"},{\"fileName\":\"images/produk/ATISISBADA/fc2480e68ca0e96a72fc6908407481fc.jpg\",\"desc\":\"hcange the way we do thinks\"},{\"fileName\":\"images/produk/ATISISBADA/75d509b3e702eddb1d8aa7c8c7f9522c.jpg\",\"desc\":\"Know ledge is powe\"},{\"fileName\":\"images/produk/ATISISBADA/b239d2599d1a82d49566e9cf1e0ef253.jpg\",\"desc\":\"perfectly design for acuracy\"}]');

DROP TABLE IF EXISTS `ref_pendidikan`;
CREATE TABLE `ref_pendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tingkat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ref_pendidikan` (`id`, `tingkat`) VALUES
(1,	'SMA/SMK'),
(2,	'D1'),
(3,	'D2'),
(4,	'D3'),
(5,	'D4'),
(6,	'S1'),
(7,	'S2'),
(8,	'S3');

DROP TABLE IF EXISTS `ref_posisi`;
CREATE TABLE `ref_posisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posisi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ref_posisi` (`id`, `posisi`) VALUES
(1,	'WEB DEVELOPER'),
(2,	'DATABASE MAINTENANCE'),
(3,	'SYSTEM ANALYST'),
(4,	'PRODUK MANAGER'),
(5,	'SALES MARKETING');

DROP TABLE IF EXISTS `reservasi_acara`;
CREATE TABLE `reservasi_acara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_peserta` text NOT NULL,
  `email` text NOT NULL,
  `instansi` text NOT NULL,
  `jumlah_orang` text NOT NULL,
  `id_acara` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reservasi_acara` (`id`, `nama_peserta`, `email`, `instansi`, `jumlah_orang`, `id_acara`, `status`) VALUES
(1,	'Jajang',	'jajanggarung@nada.ltd',	'Kabupaten Bandung Barat',	'100',	'5',	'1');

DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `gambar` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `slider` (`id`, `nama`, `gambar`, `status`) VALUES
(6,	'Slider 2',	'images/slider/142dcaa044a42074008f5870343aa9d6f4a3c605ee0b1bc3f1a9851ea8fd7da4c93d2f84778bb2df05bd7c8bf5bbc36d.jpg',	'1');

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `tempat_lahir` text NOT NULL,
  `tanggal_lahir` text NOT NULL,
  `posisi` text NOT NULL,
  `foto` text NOT NULL,
  `tentang` text NOT NULL,
  `sosial_media` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `team` (`id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `posisi`, `foto`, `tentang`, `sosial_media`) VALUES
(1,	'Taufan Tritama Putra',	'Karawang',	'1999-11-16',	'1',	'images/team/Taufan Tritama Putra.jpg',	'saya weabu, aku benci kau ',	'{\"facebook\":\"pilarwahanaartha\",\"twiter\":\"-\",\"instagram\":\"pilarwahanaartha\",\"line\":\"pilarwahanaartha\",\"bbm\":\"\",\"whatsapp\":\"085230817475\"}'),
(2,	'Dzakir Harist Abdullah',	'Bandung',	'1998-02-02',	'1',	'images/team/Dzakir Harist Abdullah.jpg',	'who are you ? ',	'{\"facebook\":\"vulnwalker\",\"twiter\":\"vulnwalker\",\"instagram\":\"vulnwalker\",\"line\":\"kszxpo\",\"bbm\":\"D*Ysjsd\",\"whatsapp\":\"0881223744803\"}');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `nama` text NOT NULL,
  `telepon` text NOT NULL,
  `alamat` text NOT NULL,
  `instansi` text NOT NULL,
  `jenis_user` text NOT NULL,
  `status_online` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `nama`, `telepon`, `alamat`, `instansi`, `jenis_user`, `status_online`) VALUES
(1,	'kszxpo  ',	'vulnwalker@tuyul.online',	'319949ab1252fc41bf437c3dea2859bdd1cad966',	'VulnWalker 2',	'081223744803',	'Jl madhapi no 8 Bandung',	'PT Pilar',	'2',	''),
(2,	'sa',	'iwanhardiwan@yahoo.com',	'10470c3b4b1fed12c3baac014be15fac67c6e815',	'Iwan Hardiwan',	'081223744803',	'Jl. Junaedi no 6',	'PT Pilar',	'2',	'');

DROP TABLE IF EXISTS `wordlist`;
CREATE TABLE `wordlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wordlist` (`id`, `hash`, `password`) VALUES
(1,	'319949ab1252fc41bf437c3dea2859bdd1cad966',	'rf09thebye'),
(2,	'10470c3b4b1fed12c3baac014be15fac67c6e815',	'123456'),
(3,	'55c3b5386c486feb662a0785f340938f518d547f',	'password'),
(4,	'1f82ea75c5cc526729e2d581aeb3aeccfef4407e',	'12345678');

-- 2018-01-04 14:26:28
