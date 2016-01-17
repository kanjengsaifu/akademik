-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17 Jan 2016 pada 07.51
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sister_siadu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_guru`
--

DROP TABLE IF EXISTS `akad_guru`;
CREATE TABLE `akad_guru` (
  `id` int(4) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `guru` varchar(50) NOT NULL,
  `sks` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_guru`
--

INSERT INTO `akad_guru` (`id`, `lokasi`, `matpel`, `guru`, `sks`, `status`) VALUES
(1, '2', '4', '132', '11', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_hari`
--

DROP TABLE IF EXISTS `akad_hari`;
CREATE TABLE `akad_hari` (
  `id` int(4) NOT NULL,
  `nama` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_hari`
--

INSERT INTO `akad_hari` (`id`, `nama`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat'),
(6, 'Sabtu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_jadwal`
--

DROP TABLE IF EXISTS `akad_jadwal`;
CREATE TABLE `akad_jadwal` (
  `id` int(4) NOT NULL,
  `lokasi` int(4) NOT NULL,
  `jenjang` int(4) NOT NULL,
  `tahunajaran` int(4) NOT NULL,
  `tingkat` int(4) NOT NULL,
  `kelas` int(4) NOT NULL,
  `matpel` int(4) NOT NULL,
  `guru` int(4) NOT NULL,
  `hari` int(4) NOT NULL,
  `jam` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_jadwal`
--

INSERT INTO `akad_jadwal` (`id`, `lokasi`, `jenjang`, `tahunajaran`, `tingkat`, `kelas`, `matpel`, `guru`, `hari`, `jam`) VALUES
(6, 1, 1, 12, 4, 2, 4, 132, 3, 1),
(7, 1, 1, 12, 4, 2, 4, 132, 1, 3),
(8, 1, 2, 12, 5, 3, 4, 132, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_jam`
--

DROP TABLE IF EXISTS `akad_jam`;
CREATE TABLE `akad_jam` (
  `id` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `mulai` varchar(10) NOT NULL,
  `selesai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_jam`
--

INSERT INTO `akad_jam` (`id`, `nama`, `jenjang`, `mulai`, `selesai`) VALUES
(1, '1', '1', '06.30', '07.15'),
(2, '2', '1', '07.15', '08.00'),
(3, '3', '1', '08.00', '08.45'),
(4, '4', '1', '08.45', '09.30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_kalender`
--

DROP TABLE IF EXISTS `akad_kalender`;
CREATE TABLE `akad_kalender` (
  `id` int(10) NOT NULL,
  `lokasi` varchar(4) NOT NULL,
  `tgl1` datetime NOT NULL,
  `tgl2` datetime NOT NULL,
  `nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_kalender`
--

INSERT INTO `akad_kalender` (`id`, `lokasi`, `tgl1`, `tgl2`, `nama`) VALUES
(1, '2', '2016-01-01 08:00:00', '2016-01-08 11:00:00', 'Bersihkan kamar'),
(7, '1', '2016-01-05 00:00:00', '2016-01-07 00:00:00', 'test sukomanunggal'),
(8, '4', '2016-01-14 00:00:00', '2016-01-22 00:00:00', 'ssf wrew rw werwer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_kegiatan`
--

DROP TABLE IF EXISTS `akad_kegiatan`;
CREATE TABLE `akad_kegiatan` (
  `id` int(5) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `jenis` varchar(256) NOT NULL,
  `penilaian` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_kegiatan`
--

INSERT INTO `akad_kegiatan` (`id`, `matpel`, `jenis`, `penilaian`) VALUES
(1, '5', 'wer wer', 'wer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_kegiatannon`
--

DROP TABLE IF EXISTS `akad_kegiatannon`;
CREATE TABLE `akad_kegiatannon` (
  `id` int(5) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `sks` varchar(256) NOT NULL,
  `thnajar` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_kelas`
--

DROP TABLE IF EXISTS `akad_kelas`;
CREATE TABLE `akad_kelas` (
  `replid` int(11) NOT NULL,
  `departemen` int(11) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `subtingkat` int(11) NOT NULL,
  `kapasitas` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `keterangan` text,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tahunajaran` int(5) NOT NULL,
  `walikelas` int(5) NOT NULL,
  `jenjang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `akad_kelas`
--

INSERT INTO `akad_kelas` (`replid`, `departemen`, `kelas`, `subtingkat`, `kapasitas`, `keterangan`, `ts`, `tahunajaran`, `walikelas`, `jenjang`) VALUES
(2, 1, 'ElyonSukoToodler1', 4, 20, 'ga ada', '2016-01-13 14:51:29', 12, 59, 1),
(3, 1, 'PG1A', 5, 10, 'Keterangan', '2016-01-17 05:51:27', 12, 133, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_lessonplan`
--

DROP TABLE IF EXISTS `akad_lessonplan`;
CREATE TABLE `akad_lessonplan` (
  `id` int(5) NOT NULL,
  `matpel` varchar(10) NOT NULL,
  `tujuan` varchar(512) NOT NULL,
  `target` varchar(215) NOT NULL,
  `jangkawaktu` varchar(215) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_lomba`
--

DROP TABLE IF EXISTS `akad_lomba`;
CREATE TABLE `akad_lomba` (
  `id` int(5) NOT NULL,
  `nama` varchar(215) NOT NULL,
  `pic` varchar(215) NOT NULL,
  `bulan` varchar(215) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_matpel`
--

DROP TABLE IF EXISTS `akad_matpel`;
CREATE TABLE `akad_matpel` (
  `id` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `sks` varchar(10) NOT NULL,
  `slot` varchar(10) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kuota` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_matpel`
--

INSERT INTO `akad_matpel` (`id`, `nama`, `sks`, `slot`, `jenjang`, `tingkat`, `kuota`) VALUES
(4, 'Matematika', '2', '10', '3', '1', '1'),
(5, 'Bahasa Indonesia', '0', '2', '1', '1', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_pelanggaran`
--

DROP TABLE IF EXISTS `akad_pelanggaran`;
CREATE TABLE `akad_pelanggaran` (
  `id` int(5) NOT NULL,
  `nama` varchar(215) NOT NULL,
  `point` varchar(215) NOT NULL,
  `hukuman` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_siswakelas`
--

DROP TABLE IF EXISTS `akad_siswakelas`;
CREATE TABLE `akad_siswakelas` (
  `id` int(5) NOT NULL,
  `kelas` int(5) NOT NULL,
  `siswa` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_ulangan`
--

DROP TABLE IF EXISTS `akad_ulangan`;
CREATE TABLE `akad_ulangan` (
  `id` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_ulangan`
--

INSERT INTO `akad_ulangan` (`id`, `nama`, `kode`) VALUES
(1, 'Ulangan Harian 1', 'uh1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_useraura`
--

DROP TABLE IF EXISTS `akad_useraura`;
CREATE TABLE `akad_useraura` (
  `UserId` int(15) NOT NULL,
  `user` varchar(250) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `avatar` varchar(250) NOT NULL DEFAULT '',
  `level` enum('Administrator','Penjualan','Kasir','Gudang','Accounting','Auditor') NOT NULL DEFAULT 'Administrator',
  `tipe` varchar(250) NOT NULL DEFAULT '',
  `is_online` int(5) NOT NULL DEFAULT '0',
  `last_ping` text NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `exp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `biodata` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_useraura`
--

INSERT INTO `akad_useraura` (`UserId`, `user`, `password`, `email`, `avatar`, `level`, `tipe`, `is_online`, `last_ping`, `start`, `exp`, `biodata`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@elyon.sch.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', 1, '2016-01-15 09:16:15', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>'),
(28, 'superadmin', 'b11d5ece6353d17f85c5ad30e0a02360', 'rekysda@gmail.com', '', 'Administrator', 'aktif', 1, '2015-03-21 23:05:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akad_guru`
--
ALTER TABLE `akad_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_hari`
--
ALTER TABLE `akad_hari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_jadwal`
--
ALTER TABLE `akad_jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_jam`
--
ALTER TABLE `akad_jam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_kalender`
--
ALTER TABLE `akad_kalender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_kegiatan`
--
ALTER TABLE `akad_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_kegiatannon`
--
ALTER TABLE `akad_kegiatannon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_kelas`
--
ALTER TABLE `akad_kelas`
  ADD PRIMARY KEY (`replid`),
  ADD KEY `departemenFK` (`departemen`),
  ADD KEY `subtingkatFK` (`subtingkat`);

--
-- Indexes for table `akad_lessonplan`
--
ALTER TABLE `akad_lessonplan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_lomba`
--
ALTER TABLE `akad_lomba`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_matpel`
--
ALTER TABLE `akad_matpel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_pelanggaran`
--
ALTER TABLE `akad_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_siswakelas`
--
ALTER TABLE `akad_siswakelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_ulangan`
--
ALTER TABLE `akad_ulangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_useraura`
--
ALTER TABLE `akad_useraura`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akad_guru`
--
ALTER TABLE `akad_guru`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akad_hari`
--
ALTER TABLE `akad_hari`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `akad_jadwal`
--
ALTER TABLE `akad_jadwal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `akad_jam`
--
ALTER TABLE `akad_jam`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `akad_kalender`
--
ALTER TABLE `akad_kalender`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `akad_kegiatan`
--
ALTER TABLE `akad_kegiatan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akad_kegiatannon`
--
ALTER TABLE `akad_kegiatannon`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `akad_kelas`
--
ALTER TABLE `akad_kelas`
  MODIFY `replid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `akad_lessonplan`
--
ALTER TABLE `akad_lessonplan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `akad_lomba`
--
ALTER TABLE `akad_lomba`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `akad_matpel`
--
ALTER TABLE `akad_matpel`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `akad_pelanggaran`
--
ALTER TABLE `akad_pelanggaran`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `akad_siswakelas`
--
ALTER TABLE `akad_siswakelas`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `akad_ulangan`
--
ALTER TABLE `akad_ulangan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akad_useraura`
--
ALTER TABLE `akad_useraura`
  MODIFY `UserId` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
