-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 04 Apr 2020 pada 10.22
-- Versi Server: 5.5.59-0ubuntu0.14.04.1
-- Versi PHP: 5.5.9-1ubuntu4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `ci3display`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `jabatan` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `foto` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `nama`, `jabatan`, `foto`, `status`) VALUES
(10, 'Vivi Dwi Susanti', 'Kabid. Kepegawaian', '20170207143443.jpg', 'N'),
(16, 'DALTON SASUE', 'Kepala Dinas', '20170207142937.jpg', 'Y'),
(9, 'Hanif Kurniawan', 'Kabid.Mutasi', '20170207143555.jpg', 'Y'),
(13, 'Moh. RIFAI JATIM', 'Sekretaris', '20170207143356.jpg', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `kegiatan` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `keterangan` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `agenda`
--

INSERT INTO `agenda` (`id`, `tanggal`, `waktu`, `kegiatan`, `keterangan`, `status`) VALUES
(1, '2017-02-07', '10:02:00', 'Rapat Koordinasi Kegiatan Amal', 'Ruang Sengkaling Satu', 'Y'),
(2, '2017-02-08', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 08', 'Ruang Sengkaling', 'Y'),
(3, '2017-02-09', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 09', 'Ruang Sengkaling', 'Y'),
(4, '2017-02-10', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 10', 'Ruang Sengkaling', 'Y'),
(5, '2017-02-11', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 11', 'Ruang Sengkaling', 'Y'),
(6, '2017-02-10', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 12', 'Ruang Sengkaling', 'Y'),
(7, '2017-02-12', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 13', 'Ruang Sengkaling', 'Y'),
(8, '2017-02-13', '10:02:00', 'Rapat Koordinasi Kegiatan Amal 14', 'Ruang Sengkaling', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktifitas`
--

CREATE TABLE IF NOT EXISTS `aktifitas` (
  `id` int(11) NOT NULL DEFAULT '0',
  `waktu` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `alamat` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `pengguna` varchar(255) NOT NULL DEFAULT '-',
  `simbol` varchar(255) NOT NULL DEFAULT 'fa-sticky-note-o',
  `keterangan` varchar(255) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `aktifitas`
--

INSERT INTO `aktifitas` (`id`, `waktu`, `alamat`, `pengguna`, `simbol`, `keterangan`) VALUES
(1, '2020-03-08 21:57:30', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(2, '2020-03-08 21:57:50', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(3, '2020-03-08 22:00:04', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(4, '2020-03-08 22:04:53', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(5, '2020-03-08 22:06:13', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(6, '2020-03-08 22:08:08', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(7, '2020-03-08 22:09:38', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(8, '2020-03-08 22:11:01', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(9, '2020-03-08 22:11:56', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(10, '2020-03-08 22:12:30', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(11, '2020-03-08 22:13:27', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(12, '2020-03-08 22:21:16', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(13, '2020-03-08 22:22:08', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(14, '2020-03-08 22:24:45', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(15, '2020-03-12 16:19:06', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(16, '2020-03-12 16:19:22', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(17, '2020-03-12 16:23:55', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(18, '2020-03-12 17:13:17', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(19, '2020-03-12 17:13:57', '::1', 'admin', 'fa-folder-open-o', 'buka data perusahaan'),
(20, '2020-03-12 17:14:00', '::1', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(21, '2020-03-12 17:14:03', '::1', 'admin', 'fa-check-square-o', 'enable/disable data user'),
(22, '2020-03-12 17:14:07', '::1', 'admin', 'fa-folder-open-o', 'buka form ubah hak akses'),
(23, '2020-03-12 17:45:43', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(24, '2020-03-12 17:45:53', '::1', 'admin', 'fa-folder-open-o', 'buka data perusahaan'),
(25, '2020-03-12 17:45:57', '::1', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(26, '2020-03-12 17:45:59', '::1', 'admin', 'fa-folder-open-o', 'buka form ubah kata sandi'),
(27, '2020-03-12 17:46:00', '::1', 'admin', 'fa-folder-open-o', 'buka form ubah hak akses'),
(28, '2020-03-12 23:34:06', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(29, '2020-03-12 23:34:11', '::1', 'admin', 'fa-folder-open-o', 'buka data perusahaan'),
(30, '2020-03-12 23:34:14', '::1', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(31, '2020-03-12 23:34:15', '::1', 'admin', 'fa-folder-open-o', 'buka form ubah kata sandi'),
(32, '2020-03-12 23:34:17', '::1', 'admin', 'fa-folder-open-o', 'buka form ubah hak akses'),
(33, '2020-03-12 23:34:20', '::1', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(34, '2020-03-12 23:35:19', '::1', 'admin', 'fa-save', 'simpan perubahan data aplikasi'),
(35, '2020-03-12 23:35:58', '::1', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(36, '2020-03-12 23:36:10', '::1', 'admin', 'fa-save', 'simpan perubahan data aplikasi'),
(37, '2020-03-12 23:36:12', '::1', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(38, '2020-03-12 23:37:51', '::1', 'admin', 'fa-save', 'simpan perubahan data aplikasi'),
(39, '2020-03-12 23:37:56', '::1', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(40, '2020-03-12 23:38:00', '::1', 'admin', 'fa-save', 'simpan perubahan data aplikasi'),
(41, '2020-03-12 23:38:03', '::1', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(42, '2020-03-14 11:43:15', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(43, '2020-03-14 11:43:25', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan berita'),
(44, '2020-03-14 11:43:27', '::1', 'admin', 'fa-folder-open-o', 'buka data laporan berita'),
(45, '2020-03-14 11:43:32', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(46, '2020-03-14 12:13:45', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(47, '2020-03-14 12:13:57', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan berita'),
(48, '2020-03-14 12:13:58', '::1', 'admin', 'fa-folder-open-o', 'buka data laporan berita'),
(49, '2020-03-14 12:14:01', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(50, '2020-03-14 12:14:17', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(51, '2020-03-14 12:14:53', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(52, '2020-03-14 12:15:14', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(53, '2020-03-14 12:15:41', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(54, '2020-03-14 12:17:12', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(55, '2020-03-14 12:17:55', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(56, '2020-03-14 12:18:25', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(57, '2020-03-14 12:22:05', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(58, '2020-03-14 12:23:49', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan berita'),
(59, '2020-03-14 12:23:51', '::1', 'admin', 'fa-folder-open-o', 'buka data laporan berita'),
(60, '2020-03-14 12:23:54', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(61, '2020-03-14 12:25:56', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(62, '2020-03-14 12:26:21', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan agenda'),
(63, '2020-03-14 12:26:23', '::1', 'admin', 'fa-folder-open-o', 'buka data laporan agenda'),
(64, '2020-03-14 12:26:27', '::1', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(65, '2020-03-14 12:26:40', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan agenda'),
(66, '2020-03-14 12:32:25', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan agenda'),
(67, '2020-03-14 12:39:45', '::1', 'admin', 'fa-folder-open-o', 'buka form filter laporan agenda'),
(68, '2020-03-14 13:09:12', '::1', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(69, '2020-03-14 13:36:11', '::1', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(70, '2020-03-14 19:47:42', '202.179.188.54', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(71, '2020-03-14 19:47:50', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan aktifitas'),
(72, '2020-03-14 19:47:53', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan berita'),
(73, '2020-03-14 19:47:58', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka data laporan berita'),
(74, '2020-03-14 19:48:03', '202.179.188.54', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(75, '2020-03-14 19:48:51', '202.179.188.54', 'admin', 'fa-print', 'cetak data laporan surat masuk'),
(76, '2020-03-14 21:31:57', '202.179.188.54', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(77, '2020-03-14 21:32:11', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka data perusahaan'),
(78, '2020-03-14 21:32:13', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(79, '2020-03-14 21:32:14', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form ubah kata sandi'),
(80, '2020-03-14 21:32:16', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form ubah hak akses'),
(81, '2020-03-14 21:32:19', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(82, '2020-03-14 21:32:29', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka data berita'),
(83, '2020-03-14 21:32:36', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka data terima berkas'),
(84, '2020-03-14 21:32:43', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan berita'),
(85, '2020-03-14 21:33:02', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan aktifitas'),
(86, '2020-03-14 21:33:05', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan agenda'),
(87, '2020-03-14 21:33:09', '202.179.188.54', 'admin', 'fa-folder-open-o', 'buka form filter laporan video'),
(88, '2020-04-04 09:28:20', '192.168.0.82', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(89, '2020-04-04 09:35:42', '192.168.0.82', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(90, '2020-04-04 09:38:22', '192.168.0.82', 'admin', 'fa-sign-in', 'login pengguna: berhasil'),
(91, '2020-04-04 09:54:23', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka data perusahaan'),
(92, '2020-04-04 09:54:24', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka data pengguna'),
(93, '2020-04-04 09:54:25', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka form ubah kata sandi'),
(94, '2020-04-04 09:54:26', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka form ubah hak akses'),
(95, '2020-04-04 09:54:27', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka form setting aplikasi'),
(96, '2020-04-04 09:54:29', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka data berita'),
(97, '2020-04-04 09:54:29', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka data video'),
(98, '2020-04-04 09:54:30', '192.168.0.82', 'admin', 'fa-folder-open-o', 'buka data agenda'),
(99, '2020-04-04 10:22:11', '192.168.0.82', 'admin', 'fa-sign-in', 'login pengguna: berhasil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL,
  `judul` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `isi` text COLLATE latin1_general_ci NOT NULL,
  `berakhir` date NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `tanggal`, `judul`, `isi`, `berakhir`, `status`) VALUES
(2, '2017-02-10', 'PENERIMAAN PEGAWAI KONTRAK DI LINGKUNGAN PEMDA', '-', '0000-00-00', 'Y'),
(3, '2017-02-11', 'PENGURUSAN KANAIKAN PANGKAT DIMULAI TANGGAL 1 APRIL 2017', '-', '0000-00-00', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar`
--

CREATE TABLE IF NOT EXISTS `gambar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `gambar` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=28 ;

--
-- Dumping data untuk tabel `gambar`
--

INSERT INTO `gambar` (`id`, `judul`, `gambar`, `size`) VALUES
(27, '', 'Manual book1.jpg', 107629),
(18, 'Kartukuning', 'ak1.jpg', 41762);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL DEFAULT '-',
  `alias` varchar(255) NOT NULL DEFAULT '-',
  `moto` varchar(255) NOT NULL DEFAULT '-',
  `bagian` varchar(255) NOT NULL DEFAULT '-',
  `subagian` varchar(9) NOT NULL DEFAULT '-',
  `alamat` varchar(255) NOT NULL DEFAULT '-',
  `kota` varchar(255) NOT NULL DEFAULT '-',
  `kodepos` varchar(255) NOT NULL DEFAULT '-',
  `telepon` varchar(255) NOT NULL DEFAULT '-',
  `fax` varchar(255) NOT NULL DEFAULT '-',
  `email` varchar(255) NOT NULL DEFAULT '-',
  `logo` varchar(255) NOT NULL DEFAULT '-',
  `logolap` varchar(255) NOT NULL DEFAULT '-',
  `format` varchar(255) NOT NULL DEFAULT '-',
  `ukuran` varchar(255) NOT NULL DEFAULT '-',
  `autorefresh` int(11) NOT NULL DEFAULT '0',
  `bataswaktu` int(11) NOT NULL DEFAULT '0',
  `kertas` varchar(255) NOT NULL DEFAULT '-',
  `orentasi` varchar(255) NOT NULL DEFAULT '-',
  `margin` varchar(255) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `alias`, `moto`, `bagian`, `subagian`, `alamat`, `kota`, `kodepos`, `telepon`, `fax`, `email`, `logo`, `logolap`, `format`, `ukuran`, `autorefresh`, `bataswaktu`, `kertas`, `orentasi`, `margin`) VALUES
(1, 'PEMERINTAH DAERAH KABUPATEN KEPULAUAN TALAUD', 'aplikasi DISPLAY', 'INFORMATION DIGITAL BOARD (PAPAN INFORMASI DIGITAL)', 'BADAN KEPEGAWAIAN DAN DIKLAT DAERAH', '', 'Jl. Buibatu No.101, ', 'Melonguane', '95885', '081280322237', '-', 'bkd@talaudkab.go.id', 'logo-perusahaan.png', '-', 'jpg|png|gif|bmp|flv|mp4|mpg', '102400', 5, 0, 'a4', 'portrait', '4|1|1|1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `userid` varchar(255) NOT NULL DEFAULT '-',
  `nama` varchar(255) NOT NULL DEFAULT '-',
  `alias` varchar(6) NOT NULL DEFAULT '-',
  `tmplahir` varchar(255) NOT NULL DEFAULT '-',
  `tglahir` varchar(255) NOT NULL DEFAULT '-',
  `kelamin` varchar(255) NOT NULL DEFAULT '-',
  `status` varchar(255) NOT NULL DEFAULT '-',
  `tmptinggal` varchar(255) NOT NULL DEFAULT '-',
  `selular` varchar(255) NOT NULL DEFAULT '-',
  `email` varchar(255) NOT NULL DEFAULT '-',
  `website` varchar(255) NOT NULL DEFAULT '-',
  `facebook` varchar(255) NOT NULL DEFAULT '-',
  `twitter` varchar(255) NOT NULL DEFAULT '-',
  `foto` varchar(255) NOT NULL DEFAULT '-',
  `keterangan` varchar(255) NOT NULL DEFAULT '-',
  `lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`userid`, `nama`, `alias`, `tmplahir`, `tglahir`, `kelamin`, `status`, `tmptinggal`, `selular`, `email`, `website`, `facebook`, `twitter`, `foto`, `keterangan`, `lastupdated`) VALUES
('admin', 'Admin', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'admin.jpg', '-', '2019-09-03 21:35:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL DEFAULT '-',
  `password` varchar(255) NOT NULL DEFAULT '-',
  `nama` varchar(255) NOT NULL DEFAULT '-',
  `jabatan` varchar(255) NOT NULL DEFAULT '-',
  `bagian` varchar(255) NOT NULL DEFAULT '-',
  `subagian` varchar(255) NOT NULL DEFAULT '-',
  `level` enum('Admin','User') NOT NULL DEFAULT 'User',
  `daftar` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `foto` varchar(255) NOT NULL DEFAULT '-',
  `S0` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|D',
  `S1` varchar(9) NOT NULL DEFAULT 'N|D|N|D|D',
  `S2` varchar(9) NOT NULL DEFAULT 'N|N|N|N|N',
  `S3` varchar(9) NOT NULL DEFAULT 'Y|D|Y|D|D',
  `S4` varchar(9) NOT NULL DEFAULT 'Y|Y|N|N|N',
  `S5` varchar(9) NOT NULL DEFAULT 'Y|Y|N|N|N',
  `T0` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|D',
  `T1` varchar(9) NOT NULL DEFAULT 'Y|Y|Y|N|N',
  `T2` varchar(9) NOT NULL DEFAULT 'Y|Y|Y|N|N',
  `T3` varchar(9) NOT NULL DEFAULT 'Y|Y|Y|N|N',
  `T4` varchar(9) NOT NULL DEFAULT 'Y|Y|Y|N|N',
  `L0` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|D',
  `L1` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|N',
  `L2` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|N',
  `L3` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|N',
  `L4` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|N',
  `L5` varchar(9) NOT NULL DEFAULT 'Y|D|D|D|N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `userid`, `password`, `nama`, `jabatan`, `bagian`, `subagian`, `level`, `daftar`, `lastlogin`, `aktif`, `foto`, `S0`, `S1`, `S2`, `S3`, `S4`, `S5`, `T0`, `T1`, `T2`, `T3`, `T4`, `L0`, `L1`, `L2`, `L3`, `L4`, `L5`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'nama jabatan', 'nama bagian', 'nama sub bagian', 'Admin', '2017-01-01 00:00:00', '2020-03-06 05:12:35', 'Y', 'admin.jpg', 'Y|D|D|D|D', 'Y|D|Y|D|D', 'Y|Y|Y|Y|Y', 'Y|D|Y|D|D', 'Y|D|Y|D|D', 'Y|D|Y|D|D', 'Y|D|D|D|D', 'Y|Y|Y|Y|N', 'Y|Y|Y|Y|N', 'Y|Y|Y|Y|N', 'Y|Y|Y|Y|N', 'Y|D|D|D|D', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y'),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'pengguna demo', '-', '-', '-', 'User', '2016-09-26 18:09:04', '0000-00-00 00:00:00', 'Y', 'nopicture.png', 'Y|D|D|D|D', 'N|D|N|D|D', 'N|N|N|N|N', 'Y|D|Y|D|D', 'Y|Y|N|N|N', 'Y|Y|N|N|N', 'Y|D|D|D|D', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|D|D|D|D', 'Y|D|D|D|N', 'Y|D|D|D|N', 'Y|D|D|D|N', 'Y|D|D|D|N', 'Y|D|D|D|N'),
(3, 'demo1', 'e368b9938746fa090d6afd3628355133', 'pengguna demo', '-', '-', '-', 'User', '2016-09-26 18:09:10', '2017-02-03 10:49:05', 'Y', 'nopicture.png', 'Y|D|D|D|D', 'Y|D|N|D|D', 'Y|N|N|N|N', 'Y|D|Y|D|D', 'Y|D|N|D|D', 'Y|D|N|D|D', 'Y|D|D|D|D', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|Y|Y|N|N', 'Y|D|D|D|D', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y', 'Y|D|D|D|Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `judul` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `video` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=24 ;

--
-- Dumping data untuk tabel `video`
--

INSERT INTO `video` (`id`, `tanggal`, `judul`, `video`, `status`) VALUES
(1, '2017-02-14', 'jadilah legenda', '20170214152108.mp4', 'Y'),
(2, '2017-02-19', 'Porodisa Multi Techno', '', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
