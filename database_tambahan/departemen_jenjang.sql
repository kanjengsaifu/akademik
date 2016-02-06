-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06 Feb 2016 pada 13.46
-- Versi Server: 5.6.16
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

--
-- Dumping data untuk tabel `departemen`
--

REPLACE INTO `departemen` (`replid`, `nama`, `kepsek`, `urut`, `keterangan`, `alamat`, `telepon`, `photo`, `ts`) VALUES
(1, 'Elyon Sukomanunggal', 98, 1, '1', 'Jl. Raya Sukomanunggal Jaya 33A', '(031)732-5999', '', '2014-01-21 16:50:40'),
(2, 'Elyon Rungkut', 98, 2, '1', 'Ruko Rungkut Megah Raya A-25, Jl. Raya Kali Rungkut No. 5', '(031)879-8896', '', '2014-01-23 19:14:27'),
(3, 'Elyon Kertajaya', 98, 3, '6', 'Jl. Kertajaya Indah Timur VII/41', '(031)599-4994', '', '2014-01-23 19:14:34');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
