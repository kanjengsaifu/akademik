-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13 Jan 2016 pada 17.02
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

DELIMITER $$
--
-- Prosedur
--
DROP PROCEDURE IF EXISTS `listdept`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listdept` ()  BEGIN
	SELECT replid, nama departemen from departemen order by nama asc;
END$$

DROP PROCEDURE IF EXISTS `listTingkatByDept`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listTingkatByDept` (IN `dept` INT)  BEGIN
	SELECT t.replid, t.tingkat,t.urutan
	FROM
		aka_tingkat t
		JOIN aka_subtingkat st ON st.tingkat = t.replid
		JOIN aka_kelas k ON k.subtingkat = st.replid
	WHERE k.departemen = dept
	GROUP BY t.replid
	ORDER BY t.urutan ASC;
END$$

--
-- Fungsi
--
DROP FUNCTION IF EXISTS `getAnggaranKuota`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranKuota` (`idAnggaranTahunan` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE anggaranKuota DECIMAL; 
		SELECT 
			SUM(a.hargasatuan * na.jml)INTO anggaranKuota
		FROM 
			keu_nominalanggaran  na
			JOIN keu_anggarantahunan a on a.replid = na.anggarantahunan
		WHERE 
			na.anggarantahunan = idAnggaranTahunan;
	RETURN anggaranKuota;
END$$

DROP FUNCTION IF EXISTS `getAnggaranPerItem`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranPerItem` (`idanggarantahunan` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE detilanggaranTotal DECIMAL;
	SELECT
		sum((
			SELECT (na.jml * hargasatuan) 
			FROM keu_anggarantahunan 
			WHERE replid=na.anggarantahunan
		)) INTO detilanggaranTotal
	FROM
		keu_nominalanggaran na
	WHERE
		na.anggarantahunan = idanggarantahunan;
	RETURN detilanggaranTotal;
END$$

DROP FUNCTION IF EXISTS `getAnggaranPerKategori`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranPerKategori` (`idkategorianggaran` INT, `idtahunajaran` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE nom DECIMAL(14);
	SELECT 
		sum((getAnggaranPerItem(ath.replid))) INTO nom
	FROM keu_detilanggaran da 
		left JOIN keu_anggarantahunan ath on ath.detilanggaran = da.replid
	WHERE
		ath.tahunajaran = idtahunajaran and 
		da.kategorianggaran = idkategorianggaran;
	RETURN nom;
END$$

DROP FUNCTION IF EXISTS `getAnggaranTerpakai`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranTerpakai` (`idAnggaranTahunan` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE nom DECIMAL;
	SELECT sum(nominal) INTO nom
	FROM vw_transaksi
	WHERE idanggarantahunan = idAnggaranTahunan;
	RETURN nom;
END$$

DROP FUNCTION IF EXISTS `getBiayaAfterDiskonReg`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaAfterDiskonReg` (`idsiswabiaya` INT) RETURNS DECIMAL(14,0) READS SQL DATA
BEGIN
	declare biayaAfterDR DECIMAL default getBiayaAwal(idsiswabiaya);
	declare vDiskon FLOAT;
	declare rowHabis1 INT DEFAULT 0;  
	declare cursor1 cursor for
		SELECT
			dd.nilai
		FROM
			psb_siswadiskon sd
			JOIN psb_detaildiskon dd on dd.replid = sd.detaildiskon
		WHERE
			sd.siswabiaya = idsiswabiaya;
	declare continue handler for not found set rowHabis1 = 1;
	open cursor1;
	LOOP1: loop
		fetch cursor1
		into  vDiskon;
		if rowHabis1 then close cursor1; leave LOOP1;
		end if;
		
		SET biayaAfterDR=biayaAfterDR-(biayaAfterDR*vDiskon/100);
	END loop LOOP1;
	return biayaAfterDR;
END$$

DROP FUNCTION IF EXISTS `getBiayaAwal`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaAwal` (`idsiswabiaya` INT) RETURNS DECIMAL(11,0) BEGIN
	DECLARE hasil int;
		SELECT
			db.nominal INTO hasil
		FROM  psb_siswabiaya sb 
			JOIN psb_detailbiaya db on db.replid = sb.detailbiaya
		WHERE 
			sb.replid = idsiswabiaya;
	RETURN hasil;
END$$

DROP FUNCTION IF EXISTS `getbiayaNett`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getbiayaNett` (`idsiswabiaya` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE ret decimal default getBiayaAfterDiskonReg(idsiswabiaya);
		declare r decimal;
        select ifnull(diskonkhusus,0)  into r 
        from psb_siswabiaya 
        where replid=idsiswabiaya;
	set ret=ret-r;
    RETURN ret;
END$$

DROP FUNCTION IF EXISTS `getBiayaTerbayar`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaTerbayar` (`idsiswabiaya` INT) RETURNS DECIMAL(10,0) READS SQL DATA
BEGIN
	declare ret decimal default getBiayaNett(idsiswabiaya);
	declare r decimal;
	SELECT IFNULL(sum(nominal),0) INTO r  from keu_penerimaansiswa where siswabiaya = idsiswabiaya;
	set ret=ret-r;
	RETURN r;
END$$

DROP FUNCTION IF EXISTS `getDiskonKhusus`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getDiskonKhusus` (`idsiswa` INT, `idbiaya` INT) RETURNS INT(11) BEGIN
	DECLARE hasil int;
		SELECT
			sb.diskonkhusus INTO hasil
		FROM  psb_siswabiaya sb 
			JOIN psb_detailbiaya db on db.replid = sb.detailbiaya
		WHERE
			db.biaya = idbiaya and 
			sb.siswa = idsiswa;
	RETURN hasil;
END$$

DROP FUNCTION IF EXISTS `getKuotaAnggaran2`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getKuotaAnggaran2` (`idDetilAnggaran` INT, `idTahunAjaran` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE kuotaAnggaran DECIMAL; 
	SELECT (
			SELECT sum(ath.hargasatuan * na.jml) 
			FROM keu_nominalanggaran na 
			WHERE na.anggarantahunan= ath.replid
		)into kuotaAnggaran
	FROM
		keu_anggarantahunan ath 
		JOIN keu_detilanggaran da on da.replid = ath.detilanggaran
	WHERE
		ath.tahunajaran = idTahunAjaran and
		ath.detilanggaran = idDetilAnggaran;	
	RETURN kuotaAnggaran ;
END$$

DROP FUNCTION IF EXISTS `getNamaAnggaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getNamaAnggaran` (`idAnggaranTahunan` INT) RETURNS VARCHAR(250) CHARSET latin1 BEGIN
	DECLARE nama VARCHAR(250); 
		SELECT
			CONCAT(da.detilanggaran," (",ka.kategorianggaran,")") INTO nama
		FROM
			keu_anggarantahunan ath
			JOIN keu_detilanggaran da ON da.replid = ath.detilanggaran
			JOIN keu_kategorianggaran ka ON ka.replid = da.kategorianggaran
		WHERE
			ath.replid = idAnggaranTahunan;
	RETURN nama;
END$$

DROP FUNCTION IF EXISTS `getSaldoAwalRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoAwalRekening` (`idDetilRekening` INT, `idTahunAjaran` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE saldoRekening decimal(14);
	SELECT nominal INTO saldoRekening
	from keu_saldorekening 
	WHERE detilrekening = idDetilRekening and tahunajaran = idTahunAjaran;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekening` (`idDetilRekening` INT, `idTahunAjaran` INT) RETURNS DECIMAL(14,0) BEGIN
	DECLARE saldoRekening DECIMAL; 
		SELECT sr.nominal into saldoRekening
		FROM keu_saldorekening sr
		WHERE 
			sr.detilrekening = idDetilRekening and 
			sr.tahunajaran = idTahunAjaran;
	RETURN saldoRekening ;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekeningByTgl`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekeningByTgl` (`idDetRek` INT, `tgl1` DATE, `tgl2` DATE) RETURNS DECIMAL(14,0) BEGIN
	DECLARE saldoRekening DECIMAL(14);
		SELECT IFNULL(sum(concat(operator,nominal)),0) into saldoRekening
		FROM vw_transaksi
		WHERE 
			(tanggal BETWEEN  tgl1 and tgl2 )
			and iddetilrekening = idDetRek
		ORDER BY tanggal ASC;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getOperatorDetRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getOperatorDetRekening` (`idDetilRekening` INT, `jenisRekening` CHAR) RETURNS CHAR(1) CHARSET latin1 BEGIN
	DECLARE operator char(1);
	SELECT 
		t.operator INTO operator
	FROM(
		SELECT
			(kr.jenistambah)jenis,
			if(kr.jenis="","+","+") as operator,
			dr.replid iddetilrekening
		FROM
			keu_detilrekening dr 
			JOIN keu_kategorirekening kr on kr.replid = dr.kategorirekening
		UNION
		SELECT
			(kr.jeniskurang)jenis,
			if(kr.jenis="","-","-") as operator,
			dr.replid iddetilrekening
		FROM
			keu_detilrekening dr 
			JOIN keu_kategorirekening kr on kr.replid = dr.kategorirekening
	)t
	WHERE	
		t.iddetilrekening= idDetilRekening AND
		t.jenis=jenisRekening;
	RETURN operator;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekeningSkrg`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekeningSkrg` (`idDetilRekening` INT) RETURNS DECIMAL(14,0) BEGIN
	declare saldoRekening DECIMAL (14);
	SELECT (
		getSaldoAwalRekening(idDetilRekening,getTahunAjaran(CURDATE()))+
		getSaldoRekeningByTgl(idDetilRekening,getTglMulaiTahunAjaran(getTahunAjaran(CURDATE())),getTglSelesaiTahunAjaran(getTahunAjaran(CURDATE())))
	)INTO saldoRekening;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getSemester`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSemester` (`tgl` DATE) RETURNS INT(11) BEGIN
	DECLARE idSemester INT;
		SELECT replid into idSemester
		FROM aka_semester 
		WHERE tgl BETWEEN tglMulai and tglSelesai;
	RETURN idSemester;
END$$

DROP FUNCTION IF EXISTS `getStatusBayar`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getStatusBayar` (`idsiswabiaya` INT) RETURNS VARCHAR(25) CHARSET latin1 BEGIN
	DECLARE s varchar(25);
	    declare terbayar  decimal default getBiayaTerbayar(idsiswabiaya);
	    declare tagihan decimal default getBiayaNett(idsiswabiaya);
		
	    IF terbayar = tagihan THEN SET s = 'lunas';
		ELSEIF terbayar =0 THEN SET s = 'belum';
		ELSE SET s = 'kurang';
		END IF;
	RETURN s;
END$$

DROP FUNCTION IF EXISTS `getTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTahunAjaran` (`tgl` DATE) RETURNS INT(11) BEGIN
	DECLARE idTahunAjaran INT;
	SELECT tahunajaran into idTahunAjaran
	FROM aka_semester 
	WHERE tgl BETWEEN tglMulai and tglSelesai;
	RETURN idTahunAjaran;
END$$

DROP FUNCTION IF EXISTS `getTglMulaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTglMulaiTahunAjaran` (`idThn` INT) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE tgl VARCHAR(10);
		SELECT MIN(tglMulai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DROP FUNCTION IF EXISTS `getTglSelesaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTglSelesaiTahunAjaran` (`idThn` INT) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE tgl VARCHAR(10);
	SELECT MAX(tglSelesai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DROP FUNCTION IF EXISTS `getTgSelesaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTgSelesaiTahunAjaran` (`idThn` INT) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE tgl VARCHAR(10);
		SELECT MAX(tglMulai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DELIMITER ;

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
(6, '1', '2016-01-28 00:00:00', '2016-01-28 00:00:00', 'u6u'),
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
(2, 1, 'ElyonSukoToodler1', 4, 20, 'ga ada', '2016-01-13 14:51:29', 12, 59, 1);

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
-- Struktur dari tabel `akad_situs`
--

DROP TABLE IF EXISTS `akad_situs`;
CREATE TABLE `akad_situs` (
  `id` int(2) NOT NULL,
  `email_master` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `judul_situs` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `url_situs` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `slogan` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `maxkonten` int(2) NOT NULL DEFAULT '5',
  `maxadmindata` int(2) NOT NULL DEFAULT '5',
  `maxdata` int(2) NOT NULL DEFAULT '5',
  `maxgalleri` int(2) NOT NULL DEFAULT '4',
  `widgetshare` int(2) NOT NULL DEFAULT '0',
  `theme` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT 'tcms',
  `author` text COLLATE latin1_general_ci NOT NULL,
  `alamatkantor` text COLLATE latin1_general_ci NOT NULL,
  `publishwebsite` int(1) NOT NULL DEFAULT '1',
  `publishnews` int(2) NOT NULL,
  `maxgalleridata` int(11) NOT NULL,
  `widgetkomentar` int(2) NOT NULL DEFAULT '1',
  `widgetpenulis` int(2) NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `akad_situs`
--

INSERT INTO `akad_situs` (`id`, `email_master`, `judul_situs`, `url_situs`, `slogan`, `description`, `keywords`, `maxkonten`, `maxadmindata`, `maxdata`, `maxgalleri`, `widgetshare`, `theme`, `author`, `alamatkantor`, `publishwebsite`, `publishnews`, `maxgalleridata`, `widgetkomentar`, `widgetpenulis`) VALUES
(1, 'rekysda@gmail.com', 'Akademik', 'http://localhost/sister/akademik/', 'Akademik', 'WebDesign dengan sistem Responsive', 'akademik,student service,surabaya,indonesia', 5, 50, 5, 4, 3, 'pos', 'Elyon Christian School', 'Surabaya', 1, 1, 12, 1, 2);

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@elyon.sch.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', 1, '2016-01-13 22:00:40', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>'),
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
-- Indexes for table `akad_situs`
--
ALTER TABLE `akad_situs`
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
-- AUTO_INCREMENT for table `akad_jam`
--
ALTER TABLE `akad_jam`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  MODIFY `replid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- AUTO_INCREMENT for table `akad_situs`
--
ALTER TABLE `akad_situs`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
