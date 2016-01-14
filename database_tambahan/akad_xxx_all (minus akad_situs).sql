-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2016 at 08:32 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sister_siadu`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `listdept`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listdept`()
BEGIN
	SELECT replid, nama departemen from departemen order by nama asc;
END$$

DROP PROCEDURE IF EXISTS `listTingkatByDept`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listTingkatByDept`(IN `dept` INT)
BEGIN
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
-- Functions
--
DROP FUNCTION IF EXISTS `getAnggaranKuota`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranKuota`(`idAnggaranTahunan` INT) RETURNS decimal(14,0)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranPerItem`(`idanggarantahunan` INT) RETURNS decimal(14,0)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranPerKategori`(`idkategorianggaran` INT, `idtahunajaran` INT) RETURNS decimal(14,0)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnggaranTerpakai`(`idAnggaranTahunan` INT) RETURNS decimal(14,0)
BEGIN
	DECLARE nom DECIMAL;
	SELECT sum(nominal) INTO nom
	FROM vw_transaksi
	WHERE idanggarantahunan = idAnggaranTahunan;
	RETURN nom;
END$$

DROP FUNCTION IF EXISTS `getBiayaAfterDiskonReg`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaAfterDiskonReg`(`idsiswabiaya` INT) RETURNS decimal(14,0)
    READS SQL DATA
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaAwal`(`idsiswabiaya` INT) RETURNS decimal(11,0)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getbiayaNett`(`idsiswabiaya` INT) RETURNS decimal(14,0)
BEGIN
	DECLARE ret decimal default getBiayaAfterDiskonReg(idsiswabiaya);
		declare r decimal;
        select ifnull(diskonkhusus,0)  into r 
        from psb_siswabiaya 
        where replid=idsiswabiaya;
	set ret=ret-r;
    RETURN ret;
END$$

DROP FUNCTION IF EXISTS `getBiayaTerbayar`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBiayaTerbayar`(`idsiswabiaya` INT) RETURNS decimal(10,0)
    READS SQL DATA
BEGIN
	declare ret decimal default getBiayaNett(idsiswabiaya);
	declare r decimal;
	SELECT IFNULL(sum(nominal),0) INTO r  from keu_penerimaansiswa where siswabiaya = idsiswabiaya;
	set ret=ret-r;
	RETURN r;
END$$

DROP FUNCTION IF EXISTS `getDiskonKhusus`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getDiskonKhusus`(`idsiswa` INT, `idbiaya` INT) RETURNS int(11)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getKuotaAnggaran2`(`idDetilAnggaran` INT, `idTahunAjaran` INT) RETURNS decimal(14,0)
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getNamaAnggaran`(`idAnggaranTahunan` INT) RETURNS varchar(250) CHARSET latin1
BEGIN
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

DROP FUNCTION IF EXISTS `getOperatorDetRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getOperatorDetRekening`(`idDetilRekening` INT, `jenisRekening` CHAR) RETURNS char(1) CHARSET latin1
BEGIN
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

DROP FUNCTION IF EXISTS `getSaldoAwalRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoAwalRekening`(`idDetilRekening` INT, `idTahunAjaran` INT) RETURNS decimal(14,0)
BEGIN
	DECLARE saldoRekening decimal(14);
	SELECT nominal INTO saldoRekening
	from keu_saldorekening 
	WHERE detilrekening = idDetilRekening and tahunajaran = idTahunAjaran;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekening`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekening`(`idDetilRekening` INT, `idTahunAjaran` INT) RETURNS decimal(14,0)
BEGIN
	DECLARE saldoRekening DECIMAL; 
		SELECT sr.nominal into saldoRekening
		FROM keu_saldorekening sr
		WHERE 
			sr.detilrekening = idDetilRekening and 
			sr.tahunajaran = idTahunAjaran;
	RETURN saldoRekening ;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekeningByTgl`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekeningByTgl`(`idDetRek` INT, `tgl1` DATE, `tgl2` DATE) RETURNS decimal(14,0)
BEGIN
	DECLARE saldoRekening DECIMAL(14);
		SELECT IFNULL(sum(concat(operator,nominal)),0) into saldoRekening
		FROM vw_transaksi
		WHERE 
			(tanggal BETWEEN  tgl1 and tgl2 )
			and iddetilrekening = idDetRek
		ORDER BY tanggal ASC;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getSaldoRekeningSkrg`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSaldoRekeningSkrg`(`idDetilRekening` INT) RETURNS decimal(14,0)
BEGIN
	declare saldoRekening DECIMAL (14);
	SELECT (
		getSaldoAwalRekening(idDetilRekening,getTahunAjaran(CURDATE()))+
		getSaldoRekeningByTgl(idDetilRekening,getTglMulaiTahunAjaran(getTahunAjaran(CURDATE())),getTglSelesaiTahunAjaran(getTahunAjaran(CURDATE())))
	)INTO saldoRekening;
	RETURN saldoRekening;
END$$

DROP FUNCTION IF EXISTS `getSemester`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getSemester`(`tgl` DATE) RETURNS int(11)
BEGIN
	DECLARE idSemester INT;
		SELECT replid into idSemester
		FROM aka_semester 
		WHERE tgl BETWEEN tglMulai and tglSelesai;
	RETURN idSemester;
END$$

DROP FUNCTION IF EXISTS `getStatusBayar`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getStatusBayar`(`idsiswabiaya` INT) RETURNS varchar(25) CHARSET latin1
BEGIN
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getTahunAjaran`(`tgl` DATE) RETURNS int(11)
BEGIN
	DECLARE idTahunAjaran INT;
	SELECT tahunajaran into idTahunAjaran
	FROM aka_semester 
	WHERE tgl BETWEEN tglMulai and tglSelesai;
	RETURN idTahunAjaran;
END$$

DROP FUNCTION IF EXISTS `getTglMulaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTglMulaiTahunAjaran`(`idThn` INT) RETURNS varchar(10) CHARSET latin1
BEGIN
	DECLARE tgl VARCHAR(10);
		SELECT MIN(tglMulai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DROP FUNCTION IF EXISTS `getTglSelesaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTglSelesaiTahunAjaran`(`idThn` INT) RETURNS varchar(10) CHARSET latin1
BEGIN
	DECLARE tgl VARCHAR(10);
	SELECT MAX(tglSelesai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DROP FUNCTION IF EXISTS `getTgSelesaiTahunAjaran`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTgSelesaiTahunAjaran`(`idThn` INT) RETURNS varchar(10) CHARSET latin1
BEGIN
	DECLARE tgl VARCHAR(10);
		SELECT MAX(tglMulai) INTO tgl FROM aka_semester WHERE tahunajaran = idThn;
	RETURN tgl;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `akad_guru`
--

DROP TABLE IF EXISTS `akad_guru`;
CREATE TABLE IF NOT EXISTS `akad_guru` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(50) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `guru` varchar(50) NOT NULL,
  `sks` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `akad_guru`
--

INSERT INTO `akad_guru` (`id`, `lokasi`, `matpel`, `guru`, `sks`, `status`) VALUES
(1, '2', '4', '132', '11', '1');

-- --------------------------------------------------------

--
-- Table structure for table `akad_jam`
--

DROP TABLE IF EXISTS `akad_jam`;
CREATE TABLE IF NOT EXISTS `akad_jam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `mulai` varchar(10) NOT NULL,
  `selesai` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `akad_jam`
--

INSERT INTO `akad_jam` (`id`, `nama`, `jenjang`, `mulai`, `selesai`) VALUES
(1, '1', '1', '06.30', '07.15'),
(2, '2', '1', '07.15', '08.00'),
(3, '3', '1', '08.00', '08.45'),
(4, '4', '1', '08.45', '09.30');

-- --------------------------------------------------------

--
-- Table structure for table `akad_kalender`
--

DROP TABLE IF EXISTS `akad_kalender`;
CREATE TABLE IF NOT EXISTS `akad_kalender` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(4) NOT NULL,
  `tgl1` datetime NOT NULL,
  `tgl2` datetime NOT NULL,
  `nama` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `akad_kalender`
--

INSERT INTO `akad_kalender` (`id`, `lokasi`, `tgl1`, `tgl2`, `nama`) VALUES
(1, '2', '2016-01-01 08:00:00', '2016-01-08 11:00:00', 'Bersihkan kamar'),
(6, '1', '2016-01-28 00:00:00', '2016-01-28 00:00:00', 'u6u'),
(7, '1', '2016-01-05 00:00:00', '2016-01-07 00:00:00', 'test sukomanunggal'),
(8, '4', '2016-01-14 00:00:00', '2016-01-22 00:00:00', 'ssf wrew rw werwer');

-- --------------------------------------------------------

--
-- Table structure for table `akad_kegiatan`
--

DROP TABLE IF EXISTS `akad_kegiatan`;
CREATE TABLE IF NOT EXISTS `akad_kegiatan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `matpel` varchar(50) NOT NULL,
  `jenis` varchar(256) NOT NULL,
  `penilaian` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `akad_kegiatan`
--

INSERT INTO `akad_kegiatan` (`id`, `matpel`, `jenis`, `penilaian`) VALUES
(1, '5', 'wer wer', 'wer');

-- --------------------------------------------------------

--
-- Table structure for table `akad_kegiatannon`
--

DROP TABLE IF EXISTS `akad_kegiatannon`;
CREATE TABLE IF NOT EXISTS `akad_kegiatannon` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(256) NOT NULL,
  `sks` varchar(256) NOT NULL,
  `thnajar` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `akad_kelas`
--

DROP TABLE IF EXISTS `akad_kelas`;
CREATE TABLE IF NOT EXISTS `akad_kelas` (
  `replid` int(11) NOT NULL AUTO_INCREMENT,
  `departemen` int(11) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `subtingkat` int(11) NOT NULL,
  `kapasitas` int(10) unsigned NOT NULL DEFAULT '0',
  `keterangan` text,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tahunajaran` int(5) NOT NULL,
  `walikelas` int(5) NOT NULL,
  `jenjang` int(5) NOT NULL,
  PRIMARY KEY (`replid`),
  KEY `departemenFK` (`departemen`),
  KEY `subtingkatFK` (`subtingkat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `akad_kelas`
--

INSERT INTO `akad_kelas` (`replid`, `departemen`, `kelas`, `subtingkat`, `kapasitas`, `keterangan`, `ts`, `tahunajaran`, `walikelas`, `jenjang`) VALUES
(2, 1, 'ElyonSukoToodler1', 4, 20, 'ga ada', '2016-01-13 14:51:29', 12, 59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `akad_lessonplan`
--

DROP TABLE IF EXISTS `akad_lessonplan`;
CREATE TABLE IF NOT EXISTS `akad_lessonplan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `matpel` varchar(10) NOT NULL,
  `tujuan` varchar(512) NOT NULL,
  `target` varchar(215) NOT NULL,
  `jangkawaktu` varchar(215) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `akad_lomba`
--

DROP TABLE IF EXISTS `akad_lomba`;
CREATE TABLE IF NOT EXISTS `akad_lomba` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(215) NOT NULL,
  `pic` varchar(215) NOT NULL,
  `bulan` varchar(215) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `akad_matpel`
--

DROP TABLE IF EXISTS `akad_matpel`;
CREATE TABLE IF NOT EXISTS `akad_matpel` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `sks` varchar(10) NOT NULL,
  `slot` varchar(10) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kuota` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `akad_matpel`
--

INSERT INTO `akad_matpel` (`id`, `nama`, `sks`, `slot`, `jenjang`, `tingkat`, `kuota`) VALUES
(4, 'Matematika', '2', '10', '3', '1', '1'),
(5, 'Bahasa Indonesia', '0', '2', '1', '1', '2');

-- --------------------------------------------------------

--
-- Table structure for table `akad_pelanggaran`
--

DROP TABLE IF EXISTS `akad_pelanggaran`;
CREATE TABLE IF NOT EXISTS `akad_pelanggaran` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(215) NOT NULL,
  `point` varchar(215) NOT NULL,
  `hukuman` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `akad_ulangan`
--

DROP TABLE IF EXISTS `akad_ulangan`;
CREATE TABLE IF NOT EXISTS `akad_ulangan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `akad_ulangan`
--

INSERT INTO `akad_ulangan` (`id`, `nama`, `kode`) VALUES
(1, 'Ulangan Harian 1', 'uh1');

-- --------------------------------------------------------

--
-- Table structure for table `akad_useraura`
--

DROP TABLE IF EXISTS `akad_useraura`;
CREATE TABLE IF NOT EXISTS `akad_useraura` (
  `UserId` int(15) NOT NULL AUTO_INCREMENT,
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
  `biodata` text NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `akad_useraura`
--

INSERT INTO `akad_useraura` (`UserId`, `user`, `password`, `email`, `avatar`, `level`, `tipe`, `is_online`, `last_ping`, `start`, `exp`, `biodata`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@elyon.sch.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', 1, '2016-01-14 08:13:32', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>'),
(28, 'superadmin', 'b11d5ece6353d17f85c5ad30e0a02360', 'rekysda@gmail.com', '', 'Administrator', 'aktif', 1, '2015-03-21 23:05:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
