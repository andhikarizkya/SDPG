-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jun 2020 pada 14.43
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scpk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot`
--

CREATE TABLE `bobot` (
  `id_variabel_parameter` int(2) NOT NULL,
  `id_variabel` int(2) NOT NULL,
  `parameter` varchar(50) NOT NULL,
  `bobot` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `bobot`
--

INSERT INTO `bobot` (`id_variabel_parameter`, `id_variabel`, `parameter`, `bobot`) VALUES
(14, 12, 'Kurang dari 37 kg', 35),
(15, 12, '37 kg', 37),
(16, 12, '38 kg', 38),
(17, 12, '39 kg', 39),
(18, 12, '40 kg', 40),
(19, 12, '41 kg', 41),
(20, 12, '42 kg', 42),
(21, 12, '43 kg', 43),
(22, 12, '44 kg', 44),
(23, 12, '45 kg', 45),
(24, 12, '46 kg', 46),
(25, 12, '47 kg', 47),
(26, 12, '48 kg', 48),
(27, 12, '49 kg', 49),
(28, 12, '50 kg ', 50),
(29, 12, '51 kg', 51),
(30, 12, '52 kg', 52),
(31, 12, '53 kg', 53),
(32, 12, '54 kg', 54),
(33, 12, '55 kg', 55),
(34, 12, '56 kg', 56),
(35, 12, '57 kg', 57),
(36, 12, '58 kg', 58),
(37, 12, '59 kg ', 59),
(38, 12, '60 kg', 60),
(39, 12, '61 kg', 61),
(40, 12, '62 kg', 62),
(41, 12, 'Lebih dari 62 kg', 64),
(42, 13, 'Kurang dari 35.5 Â°C', 35),
(43, 13, '35.5 Â°C', 35.5),
(44, 13, '35.6 Â°C', 35.6),
(45, 13, '35.7 Â°C', 35.7),
(46, 13, '35.8 Â°C', 35.8),
(47, 13, '35.9 Â°C', 35.9),
(48, 13, '36 Â°C', 36),
(49, 13, '36.1 Â°C', 36.1),
(50, 13, '36.2 Â°C', 36.2),
(51, 13, '36.3 Â°C', 36.3),
(52, 13, '36.4 Â°C', 36.4),
(53, 13, '36.5 Â°C', 36.5),
(54, 13, '36.6 Â°C', 36.6),
(55, 13, '36.7 Â°C', 36.7),
(56, 13, '36.8 Â°C', 36.8),
(57, 13, '36.9 Â°C', 36.9),
(58, 13, '37 Â°C', 37),
(59, 13, '37.1 Â°C', 37.1),
(60, 13, '37.2 Â°C', 37.2),
(61, 13, '37.3 Â°C', 37.3),
(62, 13, '37.4 Â°C', 37.4),
(63, 13, '37.5 Â°C', 37.5),
(64, 13, 'Lebih dari 37.5 Â°C', 38),
(65, 14, 'Ya', 1),
(66, 14, 'Tidak', 0),
(67, 15, 'Ya', 1),
(68, 15, 'Tidak', 0),
(69, 16, 'Ya', 1),
(70, 16, 'Tidak', 0),
(71, 17, 'Ya', 1),
(72, 17, 'Tidak', 0),
(73, 18, 'Ya', 1),
(74, 18, 'Tidak', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `himpunan`
--

CREATE TABLE `himpunan` (
  `id_variabel_himpunan` int(2) NOT NULL,
  `id_variabel` int(2) NOT NULL,
  `kode` varchar(3) NOT NULL,
  `himpunan` varchar(30) NOT NULL,
  `range` varchar(30) NOT NULL,
  `kurva` varchar(20) NOT NULL COMMENT 'diisi jenis kurva'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `himpunan`
--

INSERT INTO `himpunan` (`id_variabel_himpunan`, `id_variabel`, `kode`, `himpunan`, `range`, `kurva`) VALUES
(36, 19, 'R', 'Rendah', '0-1', 'Linear Turun'),
(35, 19, 'T', 'Tinggi', '0-1', 'Linear Naik'),
(34, 18, 'T', 'Tidak', '0-1', 'Linear Turun'),
(33, 18, 'Y', 'Ya', '0-1', 'Linear Naik'),
(32, 17, 'T', 'Tidak', '0-1', 'Linear Turun'),
(31, 17, 'Y', 'Ya', '0-1', 'Linear Naik'),
(30, 16, 'T', 'Tidak', '0-1', 'Linear Turun'),
(29, 16, 'Y', 'Ya', '0-1', 'Linear Naik'),
(28, 15, 'T', 'Tidak', '0-1', 'Linear Turun'),
(27, 15, 'Y', 'Ya', '0-1', 'Linear Naik'),
(26, 14, 'T', 'Tidak', '0-1', 'Linear Turun'),
(24, 13, 'P', 'Panas', '36-37', 'Linear Naik'),
(25, 14, 'Y', 'Ya', '0-1', 'Linear Naik'),
(22, 13, 'N', 'Normal', '36-37', 'Linear Turun'),
(21, 12, 'G', 'Gemuk', '57-62', 'Linear Naik'),
(20, 12, 'N', 'Normal', '40-42-57-58', 'Trapesium'),
(19, 12, 'K', 'Kurus', '37-42', 'Linear Turun');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsul_diagnosa`
--

CREATE TABLE `konsul_diagnosa` (
  `id_kd` int(5) NOT NULL,
  `pertanyaan` varchar(200) NOT NULL,
  `bila_benar` int(2) NOT NULL,
  `bila_salah` int(2) NOT NULL,
  `mulai` char(1) NOT NULL,
  `selesai` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `konsul_diagnosa`
--

INSERT INTO `konsul_diagnosa` (`id_kd`, `pertanyaan`, `bila_benar`, `bila_salah`, `mulai`, `selesai`) VALUES
(1, 'Penyakit tidak teridentifikasi', 1, 1, 'N', 'Y'),
(2, 'Apakah pasien mengalami hipertensi?', 3, 4, 'Y', 'N'),
(3, 'Pasien memiliki resiko penyakit ginjal yang tinggi', 1, 1, 'N', 'Y'),
(4, 'Apakah pasien mengalami obesitas?', 5, 6, 'N', 'N'),
(5, 'Memiliki resiko penyakit ginjal yang tinggi', 1, 1, 'N', 'Y'),
(6, 'Apakah pasien mengalami diabetes?', 7, 8, 'N', 'N'),
(7, 'Memiliki tingkat resiko penyakit ginjal yang tinggi', 1, 1, 'N', 'Y'),
(8, 'Apakah pasien mengalami penyakit ginjal?', 9, 10, 'N', 'N'),
(9, 'Pasien memiliki tingkat resiko penyakit ginjal yang tinggi', 1, 1, 'N', 'Y'),
(10, 'Apakah pasien mengalami penyakit hati?', 11, 12, 'N', 'N'),
(11, 'Pasien memiliki tingkat resiko terkena penyakit ginjal yang tinggi', 1, 1, 'N', 'Y'),
(12, 'Tingkat resiko penyakit ginjal yang tinggi', 1, 1, 'N', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(2) NOT NULL,
  `kriteria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kriteria`) VALUES
(1, 'Hipertensi'),
(3, 'Obesitas'),
(4, 'Diabetes'),
(5, 'Penyakit Ginjal'),
(6, 'Penyakit Hati');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menganalisa`
--

CREATE TABLE `menganalisa` (
  `id_ahd` int(3) NOT NULL,
  `id_pasien` int(5) NOT NULL,
  `id_kd` int(5) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menganalisa`
--

INSERT INTO `menganalisa` (`id_ahd`, `id_pasien`, `id_kd`, `tanggal`) VALUES
(1, 10, 7, '2020-06-13'),
(2, 13, 12, '2020-06-14'),
(3, 14, 12, '2020-06-14'),
(4, 14, 3, '2020-06-15'),
(5, 14, 12, '2020-06-15'),
(6, 14, 3, '2020-06-15'),
(7, 14, 3, '2020-06-15'),
(8, 14, 3, '2020-06-15'),
(9, 14, 3, '2020-06-21'),
(10, 14, 3, '2020-06-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `id_variabel` int(2) NOT NULL,
  `id_variabel_parameter` int(2) NOT NULL,
  `bobot` double NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_permohonan`, `id_variabel`, `id_variabel_parameter`, `bobot`, `status`) VALUES
(213, 43, 18, 73, 1, 1),
(212, 43, 17, 71, 1, 1),
(211, 43, 16, 69, 1, 1),
(210, 43, 15, 67, 1, 1),
(209, 43, 14, 65, 1, 1),
(208, 43, 13, 64, 38, 1),
(207, 43, 12, 41, 64, 1),
(255, 49, 18, 73, 1, 1),
(254, 49, 17, 71, 1, 1),
(253, 49, 16, 69, 1, 1),
(252, 49, 15, 67, 1, 1),
(251, 49, 14, 66, 0, 1),
(250, 49, 13, 48, 36, 1),
(249, 49, 12, 20, 42, 1),
(214, 44, 12, 28, 50, 1),
(215, 44, 13, 48, 36, 1),
(216, 44, 14, 66, 0, 1),
(217, 44, 15, 68, 0, 1),
(218, 44, 16, 69, 1, 1),
(219, 44, 17, 71, 1, 1),
(220, 44, 18, 74, 0, 1),
(221, 45, 12, 28, 50, 1),
(222, 45, 13, 48, 36, 1),
(223, 45, 14, 65, 1, 1),
(224, 45, 15, 68, 0, 1),
(225, 45, 16, 69, 1, 1),
(226, 45, 17, 72, 0, 1),
(227, 45, 18, 74, 0, 1),
(241, 47, 18, 73, 1, 1),
(240, 47, 17, 72, 0, 1),
(239, 47, 16, 69, 1, 1),
(238, 47, 15, 68, 0, 1),
(237, 47, 14, 66, 0, 1),
(236, 47, 13, 48, 36, 1),
(235, 47, 12, 28, 50, 1),
(242, 48, 12, 18, 40, 1),
(243, 48, 13, 48, 36, 1),
(244, 48, 14, 65, 1, 1),
(245, 48, 15, 67, 1, 1),
(246, 48, 16, 69, 1, 1),
(247, 48, 17, 71, 1, 1),
(248, 48, 18, 73, 1, 1),
(256, 50, 12, 20, 42, 1),
(257, 50, 13, 48, 36, 1),
(258, 50, 14, 66, 0, 1),
(259, 50, 15, 68, 0, 1),
(260, 50, 16, 70, 0, 1),
(261, 50, 17, 72, 0, 1),
(262, 50, 18, 74, 0, 1),
(263, 51, 12, 18, 40, 1),
(264, 51, 13, 48, 36, 1),
(265, 51, 14, 65, 1, 1),
(266, 51, 15, 67, 1, 1),
(267, 51, 16, 69, 1, 1),
(268, 51, 17, 71, 1, 1),
(269, 51, 18, 73, 1, 1),
(275, 63, 12, 17, 39, 1),
(276, 63, 13, 48, 36, 1),
(277, 63, 14, 66, 0, 1),
(278, 63, 15, 68, 0, 1),
(279, 63, 16, 70, 0, 1),
(280, 63, 17, 72, 0, 1),
(281, 63, 18, 74, 0, 1),
(282, 64, 12, 17, 39, 1),
(283, 64, 13, 48, 36, 1),
(284, 64, 14, 65, 1, 1),
(285, 64, 15, 67, 1, 1),
(286, 64, 16, 69, 1, 1),
(287, 64, 17, 71, 1, 1),
(288, 64, 18, 73, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_defuzzy`
--

CREATE TABLE `nilai_defuzzy` (
  `id_nilai_defuzzy` int(11) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `nilai` double NOT NULL,
  `hasil` varchar(50) NOT NULL,
  `diupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `nilai_defuzzy`
--

INSERT INTO `nilai_defuzzy` (`id_nilai_defuzzy`, `id_permohonan`, `nilai`, `hasil`, `diupdate`) VALUES
(24, 43, 0, 'Rendah', '2020-06-13 07:23:02'),
(23, 42, 0, 'Rendah', '2020-06-10 06:29:06'),
(25, 45, 0, 'Rendah', '2020-06-14 15:01:52'),
(26, 46, 0, 'Rendah', '2020-06-14 15:28:13'),
(27, 47, 0, 'Rendah', '2020-06-15 01:15:45'),
(28, 48, 0.4, 'Rendah', '2020-06-15 01:18:13'),
(29, 44, 0, 'Rendah', '2020-06-15 01:29:18'),
(30, 49, 0, 'Rendah', '2020-06-15 01:36:07'),
(31, 50, 0, 'Rendah', '2020-06-15 01:39:54'),
(32, 51, 0.4, 'Rendah', '2020-06-15 01:41:34'),
(33, 52, 0, 'Rendah', '2020-06-20 14:15:05'),
(34, 63, 0.4, 'Rendah', '2020-06-21 12:27:43'),
(35, 64, 0.6, 'Tinggi', '2020-06-21 12:29:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_rule`
--

CREATE TABLE `nilai_rule` (
  `id_nilai_rule` int(11) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `id_rule` int(11) NOT NULL,
  `derajat_keanggotaan` varchar(250) NOT NULL,
  `min` double NOT NULL,
  `predikat` double NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `nilai_rule`
--

INSERT INTO `nilai_rule` (`id_nilai_rule`, `id_permohonan`, `id_rule`, `derajat_keanggotaan`, `min`, `predikat`, `status`) VALUES
(9, 48, 22, '12,19,0.4;13,22,1;14,25,1;15,27,1;16,29,1;17,31,1;18,33,1;', 0.4, 0.4, 1),
(10, 51, 22, '12,19,0.4;13,22,1;14,25,1;15,27,1;16,29,1;17,31,1;18,33,1;', 0.4, 0.4, 0),
(11, 63, 44, '12,19,0.6;13,22,1;14,26,1;15,28,1;16,30,1;17,32,1;18,34,1;', 0.6, 0.4, 1),
(12, 51, 45, '12,19,0.4;13,22,1;14,25,1;15,27,1;16,29,1;17,31,1;18,33,1;', 0.4, 0.4, 1),
(13, 64, 45, '12,19,0.6;13,22,1;14,25,1;15,27,1;16,29,1;17,31,1;18,33,1;', 0.6, 0.6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `no_pasien` varchar(16) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `alamat_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(13) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `no_pasien`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat_lengkap`, `no_telepon`, `pekerjaan`, `terdaftar`) VALUES
(10, '002', 'Dwi Indah', 'DIY', '1998-06-17', 'P', 'Jln. Magelang', '082254987526', 'Ibu Rumah Tangga', '2020-06-02 22:49:06'),
(9, '001', 'Suraji', 'Sleman', '1980-02-20', 'L', 'Jln. Kaliurang km 10', '081398423164', 'Pengusaha', '2020-06-02 22:45:55'),
(12, '003', 'Hartono ', 'Sleman', '1954-03-16', 'L', 'Jalan Raya Sambisari', '08953287639', 'Petani', '2020-06-14 21:49:39'),
(13, '004', 'Yanto Wijayanto', 'Sleman', '1954-02-17', 'L', 'Jln. Sambisari, Kalasan', '08932459234', 'Pedagang', '2020-06-14 22:00:31'),
(14, '005', 'Tono ', 'Jakarta', '2020-06-03', 'L', 'Kadisoka', '08944322342', 'Tukang Parkir', '2020-06-14 22:23:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan`
--

CREATE TABLE `permohonan` (
  `id_permohonan` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `nomor` char(10) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `permohonan`
--

INSERT INTO `permohonan` (`id_permohonan`, `id_pasien`, `nomor`, `tanggal`) VALUES
(43, 10, '0000000002', '2020-06-13'),
(49, 9, '0000000007', '2020-06-15'),
(44, 12, '0000000003', '2020-06-14'),
(45, 13, '0000000004', '2020-06-14'),
(47, 14, '0000000005', '2020-06-15'),
(48, 13, '0000000006', '2020-06-15'),
(50, 10, '0000000008', '2020-06-15'),
(51, 12, '0000000009', '2020-06-15'),
(63, 14, '0000000010', '2020-06-21'),
(64, 10, '0000000011', '2020-06-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `relasi`
--

CREATE TABLE `relasi` (
  `id_relasi` int(11) NOT NULL,
  `id_node` int(3) NOT NULL,
  `id_resiko` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `relasi`
--

INSERT INTO `relasi` (`id_relasi`, `id_node`, `id_resiko`) VALUES
(2, 3, 3),
(3, 5, 3),
(4, 7, 3),
(5, 9, 3),
(6, 11, 3),
(7, 12, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `resiko`
--

CREATE TABLE `resiko` (
  `id_resiko` int(11) NOT NULL,
  `resiko` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `resiko`
--

INSERT INTO `resiko` (`id_resiko`, `resiko`) VALUES
(3, 'Pasien memiliki tingkat resiko penyakit ginjal yang tinggi'),
(4, 'Disarankan lanjut ke FIS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `kode` varchar(5) NOT NULL,
  `rule` varchar(100) DEFAULT NULL COMMENT 'Misal : k,1,1;k,2,10 s/d ;p,6,30'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `kode`, `rule`) VALUES
(51, 'R08', 'k,12,21;k,13,24;k,14,25;k,15,28;k,16,29;k,17,32;k,18,33;p,19,35'),
(50, 'R07', 'k,12,20;k,13,24;k,14,25;k,15,27;k,16,29;k,17,31;k,18,34;p,19,35'),
(49, 'R06', 'k,12,19;k,13,22;k,14,26;k,15,28;k,16,30;k,17,32;k,18,33;p,19,36'),
(48, 'R05', 'k,12,20;k,13,22;k,14,25;k,15,27;k,16,29;k,17,31;k,18,34;p,19,35'),
(47, 'R04', 'k,12,21;k,13,22;k,14,26;k,15,27;k,16,29;k,17,32;k,18,33;p,19,35'),
(46, 'R03', 'k,12,20;k,13,22;k,14,25;k,15,28;k,16,29;k,17,32;k,18,34;p,19,36'),
(45, 'R02', 'k,12,19;k,13,22;k,14,25;k,15,27;k,16,29;k,17,31;k,18,33;p,19,35'),
(44, 'R01', 'k,12,19;k,13,22;k,14,26;k,15,28;k,16,30;k,17,32;k,18,34;p,19,36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(2) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_telepon` varchar(13) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tipe_akses` int(1) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `no_telepon`, `username`, `password`, `tipe_akses`, `terdaftar`) VALUES
(3, 'Admin Posyandu', '08993245648', 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, '2020-06-14 00:00:00'),
(2, 'Kader Posyandu', '081904013081', 'Kader', '48ac2159edaa832786111d01f63e9150', 1, '2020-06-14 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `variabel`
--

CREATE TABLE `variabel` (
  `id_variabel` int(2) NOT NULL,
  `variabel` varchar(30) NOT NULL,
  `sifat` varchar(30) NOT NULL,
  `jenis` int(1) NOT NULL COMMENT '1. Kriteria, 2. Keputusan'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `variabel`
--

INSERT INTO `variabel` (`id_variabel`, `variabel`, `sifat`, `jenis`) VALUES
(14, 'Berasal dari keturunan', 'Crisp', 1),
(13, 'Suhu Tubuh', 'Fuzzy', 1),
(12, 'Berat Badan', 'Fuzzy', 1),
(15, 'Sering mual muntah', 'Crisp', 1),
(16, 'Warna urine berubah', 'Crisp', 1),
(17, 'Terjadi pembengkakan', 'Crisp', 1),
(18, 'Sulit tidur', 'Crisp', 1),
(19, 'Resiko penyakit ginjal', 'Fuzzy', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`id_variabel_parameter`);

--
-- Indeks untuk tabel `himpunan`
--
ALTER TABLE `himpunan`
  ADD PRIMARY KEY (`id_variabel_himpunan`);

--
-- Indeks untuk tabel `konsul_diagnosa`
--
ALTER TABLE `konsul_diagnosa`
  ADD PRIMARY KEY (`id_kd`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `menganalisa`
--
ALTER TABLE `menganalisa`
  ADD PRIMARY KEY (`id_ahd`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `nilai_defuzzy`
--
ALTER TABLE `nilai_defuzzy`
  ADD PRIMARY KEY (`id_nilai_defuzzy`);

--
-- Indeks untuk tabel `nilai_rule`
--
ALTER TABLE `nilai_rule`
  ADD PRIMARY KEY (`id_nilai_rule`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id_permohonan`);

--
-- Indeks untuk tabel `relasi`
--
ALTER TABLE `relasi`
  ADD PRIMARY KEY (`id_relasi`);

--
-- Indeks untuk tabel `resiko`
--
ALTER TABLE `resiko`
  ADD PRIMARY KEY (`id_resiko`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `variabel`
--
ALTER TABLE `variabel`
  ADD PRIMARY KEY (`id_variabel`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bobot`
--
ALTER TABLE `bobot`
  MODIFY `id_variabel_parameter` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `himpunan`
--
ALTER TABLE `himpunan`
  MODIFY `id_variabel_himpunan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `konsul_diagnosa`
--
ALTER TABLE `konsul_diagnosa`
  MODIFY `id_kd` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `menganalisa`
--
ALTER TABLE `menganalisa`
  MODIFY `id_ahd` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT untuk tabel `nilai_defuzzy`
--
ALTER TABLE `nilai_defuzzy`
  MODIFY `id_nilai_defuzzy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `nilai_rule`
--
ALTER TABLE `nilai_rule`
  MODIFY `id_nilai_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id_permohonan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `relasi`
--
ALTER TABLE `relasi`
  MODIFY `id_relasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `resiko`
--
ALTER TABLE `resiko`
  MODIFY `id_resiko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `variabel`
--
ALTER TABLE `variabel`
  MODIFY `id_variabel` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
