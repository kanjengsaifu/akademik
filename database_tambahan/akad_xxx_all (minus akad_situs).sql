-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10 Feb 2016 pada 06.18
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
-- Struktur dari tabel `akad_afektifkat`
--

DROP TABLE IF EXISTS `akad_afektifkat`;
CREATE TABLE `akad_afektifkat` (
  `id` int(5) NOT NULL,
  `rapor` int(5) NOT NULL,
  `master` int(5) NOT NULL,
  `nama` varchar(512) NOT NULL,
  `urut` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_afektifkat`
--

INSERT INTO `akad_afektifkat` (`id`, `rapor`, `master`, `nama`, `urut`) VALUES
(2, 2, 0, 'Core Value', 0),
(3, 2, 0, 'Cognitive', 0),
(4, 2, 0, 'Life Skill', 0),
(5, 2, 0, 'Sports', 0),
(8, 2, 2, 'Is able to pray', 0),
(9, 2, 3, 'Understands a story', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_bulan`
--

DROP TABLE IF EXISTS `akad_bulan`;
CREATE TABLE `akad_bulan` (
  `id` int(2) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_bulan`
--

INSERT INTO `akad_bulan` (`id`, `nama`) VALUES
(1, 'Januari'),
(2, 'Februari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'Nopember'),
(12, 'Desember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_grade`
--

DROP TABLE IF EXISTS `akad_grade`;
CREATE TABLE `akad_grade` (
  `id` int(5) NOT NULL,
  `nilai` int(4) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `ket` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_grade`
--

INSERT INTO `akad_grade` (`id`, `nilai`, `nama`, `ket`) VALUES
(1, 90, 'A', ''),
(2, 80, 'B+', ''),
(3, 70, 'B', ''),
(4, 61, 'C', ''),
(5, 50, 'D', ''),
(6, 30, 'E', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_gradeafektif`
--

DROP TABLE IF EXISTS `akad_gradeafektif`;
CREATE TABLE `akad_gradeafektif` (
  `id` int(5) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `ket` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_gradeafektif`
--

INSERT INTO `akad_gradeafektif` (`id`, `nama`, `ket`) VALUES
(1, 'V', 'Very Good'),
(2, 'G', 'Good'),
(3, 'S', 'Satisfactory'),
(4, 'I', 'Needs Improvements');

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
  `status` varchar(50) NOT NULL,
  `jenjang` int(4) NOT NULL,
  `tingkat` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_guru`
--

INSERT INTO `akad_guru` (`id`, `lokasi`, `matpel`, `guru`, `sks`, `status`, `jenjang`, `tingkat`) VALUES
(1, '2', '4', '132', '11', '1', 1, 4),
(3, '1', '5', '108', '1', '1', 1, 4);

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
(8, 1, 2, 12, 5, 3, 4, 132, 1, 1),
(9, 1, 1, 5, 4, 2, 5, 108, 4, 1);

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
(7, '1', '2016-01-05 00:00:00', '2016-01-07 00:00:00', 'test sukomanunggal');

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
(2, 1, 'ElyonSukoToodler1', 4, 20, 'tidak ada', '2016-01-13 14:51:29', 5, 46, 1);

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
-- Struktur dari tabel `akad_linkssites`
--

DROP TABLE IF EXISTS `akad_linkssites`;
CREATE TABLE `akad_linkssites` (
  `id` int(5) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `url` varchar(512) NOT NULL,
  `gambar` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_linkssites`
--

INSERT INTO `akad_linkssites` (`id`, `nama`, `url`, `gambar`) VALUES
(2, 'Dispendik Surabaya', 'http://dispendik.surabaya.go.id', '62ec8da9ce78fcb483968b32d34dc341.jpg'),
(3, 'Surabaya Belajar', 'http://dispendik.surabaya.go.id/sb/index.php?lang=en', 'a32e83e5e67a671e78b7429d28394df5.jpg'),
(4, 'Profil Sekolah', 'http://profilsekolah.dispendik.surabaya.go.id/', '1d87028a330e30f1a756c0c17f34c86c.jpg'),
(5, 'Try Out Online', 'http://tryoutonline.dispendik.surabaya.go.id/', 'ba4a1d4b5195fae25a2cb0b77e880ed0.jpg'),
(6, 'Rapor Online', 'http://raporku.net/', '4220a633a7dc31ce20d5c550f1c8a8d5.jpg'),
(7, 'Dispendik Ketenagaan Surabaya', 'https://dispendiksurabaya.wordpress.com/', '07fc1703c92c64fa1f5050a9249a8e40.jpg');

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

--
-- Dumping data untuk tabel `akad_lomba`
--

INSERT INTO `akad_lomba` (`id`, `nama`, `pic`, `bulan`) VALUES
(1, 'Lomba SAINS', 'ELyon SUKO', '1');

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
-- Struktur dari tabel `akad_mnmaster`
--

DROP TABLE IF EXISTS `akad_mnmaster`;
CREATE TABLE `akad_mnmaster` (
  `id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `urut` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_mnmaster`
--

INSERT INTO `akad_mnmaster` (`id`, `nama`, `url`, `gambar`, `urut`) VALUES
(1, 'departemen', 'lokasi', 'lokasi', 1),
(2, 'jenjang', 'jenjang', 'jenjang', 2),
(3, 'kelas', 'kelas', 'kelas', 3),
(4, 'tahunajaran', 'tahunajaran', 'kalender', 4),
(5, 'mata pelajaran', 'matpel', 'matpel', 5),
(6, 'jam', 'jam', 'jam', 6),
(7, 'ulangan', 'ulangan', 'ulangan', 7),
(8, 'guru', 'guru', 'guru', 8),
(9, 'pelanggaran', 'pelanggaran', 'pelanggaran', 9),
(10, 'lesson plan', 'lessonplan', 'lessonplan', 10),
(11, 'rapor', 'raporafektif', 'rapor', 11),
(12, 'kegiatan', 'kegiatan', 'kegiatan', 12),
(13, 'kegiatan non akademik', 'kegiatannon', 'kegiatan', 13),
(14, 'grade', 'grade', 'grade', 14),
(15, 'linkssites', 'linkssites', 'linkssites', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_mntransaksi`
--

DROP TABLE IF EXISTS `akad_mntransaksi`;
CREATE TABLE `akad_mntransaksi` (
  `id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `urut` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_mntransaksi`
--

INSERT INTO `akad_mntransaksi` (`id`, `nama`, `url`, `gambar`, `urut`) VALUES
(1, 'kalender akademik', 'kalenderakademik', 'kalender', 1),
(2, 'jadwal', 'jadwal', 'timetable', 2),
(3, 'siswa kelas', 'siswakelas', 'siswakelas', 3),
(4, 'siswa absensi', 'siswapresensi', 'presensi', 4),
(5, 'siswa pelanggaran', 'siswapelanggaran', 'siswapelanggaran', 5),
(6, 'siswa lomba', 'siswalomba', 'siswalomba', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_pelanggaran`
--

DROP TABLE IF EXISTS `akad_pelanggaran`;
CREATE TABLE `akad_pelanggaran` (
  `id` int(5) NOT NULL,
  `kategori` int(4) NOT NULL,
  `nama` varchar(215) NOT NULL,
  `point` int(10) NOT NULL,
  `hukuman` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_pelanggaran`
--

INSERT INTO `akad_pelanggaran` (`id`, `kategori`, `nama`, `point`, `hukuman`) VALUES
(2, 1, 'Terlambat kurang dari 10 menit', 2, 'Peringatan lisan'),
(3, 1, 'Terlambat lebih dari 15 menit', 10, 'Membersihkan lingkungan sekolah dan diijinkan masuk pada jam ke dua'),
(4, 1, 'Izin keluar (piket) pekarangan sekolah dan tidak kembali lagi', 10, 'Surat peringatan'),
(5, 2, 'Siswa tidak masuk sekolah karena Sakit atau Izin tanpa keterangan', 2, 'Peringatan lisan'),
(6, 2, 'Tidak mengikuti upacara bendera, dan hari besar nasional', 10, 'Peringatan lisan'),
(7, 3, 'Seragam tidak sesuai dengan ketentuan', 10, 'Surat peringatan'),
(8, 3, ' Tidak memasukkan baju seragam (Siswa Putra)', 10, 'Peringatan lisan, Memasukkan baju'),
(9, 3, 'Menggunakan perhiasan / berhias berlebihan (Siswa Putri)', 10, 'Peringatan lisan, penyitaan barang'),
(10, 3, 'Memakai aksesoris gelang, kalung, anting  kecuali jam tangan (Siswa Pria)', 10, '	Peringatan lisan, penyitaan barang'),
(11, 3, 'Memiliki tattoo, Kuping/lidah/hidung ditindik', 25, 'Peringatan lisan, ubah/hapus warna ,Surat peringatan, Pemanggilan ORTU'),
(12, 4, 'Mencuri/mengambil barang milik orang lain', 50, 'Surat peringatan, Pemanggilan ORTU'),
(13, 4, ' Mencorat-coret dinding, tembok, meja, kursi, dan pagar sekolah', 25, 'Surat peringatan, Pemanggilan ORTU,  mengecat ulang'),
(14, 4, 'Menyita dengan paksa (merampas) barang milik teman', 50, 'Surat peringatan, Pemanggilan ORTU'),
(15, 4, ' Merusak/menghilangkan sarana dan prasarana milik sekolah, guru, karyawan, dan teman', 20, 'Surat peringatan, Pemanggilan ORTU'),
(16, 5, ' Membawa rokok milik sendiri (titipan)', 25, 'Surat peringatan, Pemanggilan ORTU'),
(17, 5, 'Membawa/menghidupkan HP berkamera/MP3/MP4/Wolkman/Portable saat belajar', 50, 'Surat peringatan, Pemanggilan ORTU, penyitaan barang'),
(18, 5, 'Berkelahi di lingkungan sekolah (lingkungan sekitar sekolah)', 50, 'Surat peringatan, Pemanggilan ORTU, skorsing bakti kampus 1 minggu.'),
(19, 5, '  Ditemukan diluar sekolah pada jam pelajaran berlangsung (Nongkrong)', 25, 'Surat peringatan, Pemanggilan ORTU'),
(20, 5, ' Melakukan tindak kriminal / berusan dengan pihak kepolisian (hukum)', 250, 'Surat peringatan, Pemanggilan ORTU, dikembalikan ke ORTU'),
(21, 5, 'Membawa /menggunakan/memperjual belikan  narkotika dan zat adiktif lainnya', 250, 'Surat peringatan, Pemanggilan ORTU, dikembalikan ke ORTU'),
(22, 6, ' Melawan kepala sekolah, Wakil kepala sekolah, Kepala Program, guru, dan karyawan dengan ucapan/tulisan kata-kata kasar', 250, 'Surat peringatan, Pemanggilan ORTU, dikembalikan ke ORTU'),
(23, 6, 'Melawan kepala sekolah, Wakil kepala sekolah, Kepala Program, guru, dan karyawan disertai ancaman', 250, 'Surat peringatan, Pemanggilan ORTU, dikembalikan ke ORTU'),
(24, 6, 'Melawan kepala sekola, Wakil kepala sekolah, Kepala Program, guru, dan karyawan disertai pemukulan', 250, 'Surat peringatan, Pemanggilan ORTU, dikembalikan ke ORTU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_pelanggarankat`
--

DROP TABLE IF EXISTS `akad_pelanggarankat`;
CREATE TABLE `akad_pelanggarankat` (
  `id` int(5) NOT NULL,
  `nama` varchar(215) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_pelanggarankat`
--

INSERT INTO `akad_pelanggarankat` (`id`, `nama`) VALUES
(1, 'Keterlambatan'),
(2, 'Kerajinan'),
(3, 'Kerapihan'),
(4, 'Kepribadian'),
(5, 'Ketertiban'),
(6, 'Pelanggaran terhadap Sekolah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_raporafektif`
--

DROP TABLE IF EXISTS `akad_raporafektif`;
CREATE TABLE `akad_raporafektif` (
  `id` int(5) NOT NULL,
  `lokasi` int(5) NOT NULL,
  `jenjang` int(5) NOT NULL,
  `tahunajaran` int(5) NOT NULL,
  `semester` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_raporafektif`
--

INSERT INTO `akad_raporafektif` (`id`, `lokasi`, `jenjang`, `tahunajaran`, `semester`) VALUES
(1, 1, 2, 5, 1),
(2, 1, 1, 5, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_semester`
--

DROP TABLE IF EXISTS `akad_semester`;
CREATE TABLE `akad_semester` (
  `id` int(4) NOT NULL,
  `nama` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_semester`
--

INSERT INTO `akad_semester` (`id`, `nama`) VALUES
(1, 'Semester 1'),
(2, 'Semester 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_setting`
--

DROP TABLE IF EXISTS `akad_setting`;
CREATE TABLE `akad_setting` (
  `id` int(4) NOT NULL,
  `semesteraktif` int(4) NOT NULL,
  `tahunaktif` int(5) NOT NULL,
  `tahunajaranaktif` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_setting`
--

INSERT INTO `akad_setting` (`id`, `semesteraktif`, `tahunaktif`, `tahunajaranaktif`) VALUES
(1, 1, 2015, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_siswaabsen`
--

DROP TABLE IF EXISTS `akad_siswaabsen`;
CREATE TABLE `akad_siswaabsen` (
  `id` int(4) NOT NULL,
  `semester` int(4) NOT NULL,
  `bulan` int(5) NOT NULL,
  `tahun` int(5) NOT NULL,
  `kelas` int(5) NOT NULL,
  `siswa` int(5) NOT NULL,
  `hadir` int(5) NOT NULL,
  `sakit` int(5) NOT NULL,
  `ijin` int(5) NOT NULL,
  `alpa` int(5) NOT NULL,
  `terlambat` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_siswaabsen`
--

INSERT INTO `akad_siswaabsen` (`id`, `semester`, `bulan`, `tahun`, `kelas`, `siswa`, `hadir`, `sakit`, `ijin`, `alpa`, `terlambat`) VALUES
(1, 1, 1, 2015, 2, 577, 0, 2, 0, 4, 5),
(3, 1, 12, 2014, 2, 577, 4, 4, 0, 4, 4),
(5, 1, 1, 2015, 2, 293, 5, 5, 0, 3, 1),
(6, 1, 12, 2014, 2, 293, 50, 4, 3, 2, 1),
(8, 2, 1, 2016, 2, 293, 0, 0, 0, 0, 1),
(9, 1, 1, 2016, 2, 293, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_siswakelas`
--

DROP TABLE IF EXISTS `akad_siswakelas`;
CREATE TABLE `akad_siswakelas` (
  `id` int(5) NOT NULL,
  `tahunajaran` int(10) NOT NULL,
  `kelas` int(5) NOT NULL,
  `siswa` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_siswakelas`
--

INSERT INTO `akad_siswakelas` (`id`, `tahunajaran`, `kelas`, `siswa`) VALUES
(1, 5, 2, 577),
(2, 5, 2, 102),
(3, 5, 2, 205),
(8, 5, 3, 0),
(14, 5, 3, 22),
(15, 5, 2, 293);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_siswalomba`
--

DROP TABLE IF EXISTS `akad_siswalomba`;
CREATE TABLE `akad_siswalomba` (
  `id` int(4) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `siswa` int(4) NOT NULL,
  `kelas` int(4) NOT NULL,
  `lomba` int(4) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `hasillomba` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_siswalomba`
--

INSERT INTO `akad_siswalomba` (`id`, `tgl`, `siswa`, `kelas`, `lomba`, `pic`, `hasillomba`) VALUES
(2, '2016-01-28', 293, 2, 1, 'ELyon SUKO', 'Menang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akad_siswapelanggaran`
--

DROP TABLE IF EXISTS `akad_siswapelanggaran`;
CREATE TABLE `akad_siswapelanggaran` (
  `id` int(4) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `siswa` int(4) NOT NULL,
  `kelas` int(4) NOT NULL,
  `pelanggaran` int(4) NOT NULL,
  `point` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akad_siswapelanggaran`
--

INSERT INTO `akad_siswapelanggaran` (`id`, `tgl`, `siswa`, `kelas`, `pelanggaran`, `point`) VALUES
(5, '2016-01-28', 205, 3, 3, 10),
(6, '2016-01-27', 205, 3, 15, 20),
(7, '2016-02-05', 577, 2, 2, 2),
(8, '2016-02-05', 577, 2, 2, 2);

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
(1, 'Ulangan Harian 1', 'uh1'),
(2, 'Ulangan Harian 2', 'uh2'),
(3, 'Ulangan Tengah Semester', 'uts');

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@elyon.sch.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', 1, '2016-02-10 10:20:58', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>'),
(28, 'superadmin', 'b11d5ece6353d17f85c5ad30e0a02360', 'rekysda@gmail.com', '', 'Administrator', 'aktif', 1, '2015-03-21 23:05:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akad_afektifkat`
--
ALTER TABLE `akad_afektifkat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_bulan`
--
ALTER TABLE `akad_bulan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_grade`
--
ALTER TABLE `akad_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_gradeafektif`
--
ALTER TABLE `akad_gradeafektif`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `akad_linkssites`
--
ALTER TABLE `akad_linkssites`
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
-- Indexes for table `akad_mnmaster`
--
ALTER TABLE `akad_mnmaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_mntransaksi`
--
ALTER TABLE `akad_mntransaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_pelanggaran`
--
ALTER TABLE `akad_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_pelanggarankat`
--
ALTER TABLE `akad_pelanggarankat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_raporafektif`
--
ALTER TABLE `akad_raporafektif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_semester`
--
ALTER TABLE `akad_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_setting`
--
ALTER TABLE `akad_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_siswaabsen`
--
ALTER TABLE `akad_siswaabsen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_siswakelas`
--
ALTER TABLE `akad_siswakelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_siswalomba`
--
ALTER TABLE `akad_siswalomba`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akad_siswapelanggaran`
--
ALTER TABLE `akad_siswapelanggaran`
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
-- AUTO_INCREMENT for table `akad_afektifkat`
--
ALTER TABLE `akad_afektifkat`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `akad_bulan`
--
ALTER TABLE `akad_bulan`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `akad_grade`
--
ALTER TABLE `akad_grade`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `akad_gradeafektif`
--
ALTER TABLE `akad_gradeafektif`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `akad_guru`
--
ALTER TABLE `akad_guru`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `akad_hari`
--
ALTER TABLE `akad_hari`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `akad_jadwal`
--
ALTER TABLE `akad_jadwal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
-- AUTO_INCREMENT for table `akad_linkssites`
--
ALTER TABLE `akad_linkssites`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `akad_lomba`
--
ALTER TABLE `akad_lomba`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akad_matpel`
--
ALTER TABLE `akad_matpel`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `akad_mnmaster`
--
ALTER TABLE `akad_mnmaster`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `akad_mntransaksi`
--
ALTER TABLE `akad_mntransaksi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `akad_pelanggaran`
--
ALTER TABLE `akad_pelanggaran`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `akad_pelanggarankat`
--
ALTER TABLE `akad_pelanggarankat`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `akad_raporafektif`
--
ALTER TABLE `akad_raporafektif`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akad_semester`
--
ALTER TABLE `akad_semester`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akad_setting`
--
ALTER TABLE `akad_setting`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akad_siswaabsen`
--
ALTER TABLE `akad_siswaabsen`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `akad_siswakelas`
--
ALTER TABLE `akad_siswakelas`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `akad_siswalomba`
--
ALTER TABLE `akad_siswalomba`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akad_siswapelanggaran`
--
ALTER TABLE `akad_siswapelanggaran`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `akad_ulangan`
--
ALTER TABLE `akad_ulangan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `akad_useraura`
--
ALTER TABLE `akad_useraura`
  MODIFY `UserId` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
