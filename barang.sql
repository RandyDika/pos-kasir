-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 01:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `merk` varchar(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `stok` text NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  `tgl_update` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `tgl_input`, `tgl_update`) VALUES
(1, 'BR001', 12, 'FRENCH FRIES', 'Custom', '7000', '15000', 'PCS', '50', '6 October 2020, 0:41', '12 June 2025, 20:01'),
(2, 'BR002', 12, 'CIRENG', 'Custom', '8000', '16000', 'PCS', '49', '6 October 2020, 0:41', '12 June 2025, 20:03'),
(3, 'BR003', 12, 'DOUGHNUT', 'Custom', '5000', '13000', 'PCS', '50', '6 October 2020, 1:34', '12 June 2025, 20:02'),
(4, 'BR004', 8, 'KOPI SUSU 808', 'Kapal Api', '10000', '18000', 'PCS', '47', '12 June 2025, 12:39', '12 June 2025, 19:48'),
(5, 'BR005', 8, 'HAZELNUT LATTE', 'ABC', '12000', '20000', 'PCS', '48', '12 June 2025, 12:40', '12 June 2025, 19:48'),
(6, 'BR006', 8, 'VANILLA LATTE', 'White Koffie', '12000', '20000', 'PCS', '50', '12 June 2025, 19:49', NULL),
(7, 'BR007', 8, 'CARAMEL LATTE', 'Good Day', '12000', '20000', 'PCS', '50', '12 June 2025, 19:49', NULL),
(8, 'BR008', 8, 'MATCHA', 'Chocolatos', '14000', '22000', 'PCS', '50', '12 June 2025, 19:50', NULL),
(9, 'BR009', 8, 'CHOCO HAZELNUT', 'Chocolatos', '14000', '22000', 'PCS', '50', '12 June 2025, 19:50', '12 June 2025, 19:54'),
(10, 'BR010', 0, 'RED VELVET', 'Good Day', '14000', '22000', 'PCS', '50', '12 June 2025, 19:51', NULL),
(11, 'BR011', 8, 'LYCHEE YAKULT', 'Custom', '15000', '23000', 'PCS', '50', '12 June 2025, 19:52', NULL),
(12, 'BR012', 8, 'LYCHEE TEA', 'Custom', '7000', '15000', 'PCS', '50', '12 June 2025, 19:54', NULL),
(13, 'BR013', 8, 'STRAWBERRY TEA', 'Custom', '7000', '15000', 'PCS', '50', '12 June 2025, 19:55', NULL),
(14, 'BR014', 9, 'ES TEH 808', 'Sariwangi', '4000', '12000', 'PCS', '49', '12 June 2025, 19:55', NULL),
(15, 'BR015', 9, 'MILO 808', 'Milo', '4000', '12000', 'PCS', '48', '12 June 2025, 19:56', NULL),
(16, 'BR016', 9, 'TEH TARIK', 'Sariwangi', '4000', '12000', 'PCS', '50', '12 June 2025, 19:56', NULL),
(17, 'BR017', 9, 'KOPI TUBRUK', 'Custom', '2000', '10000', 'PCS', '50', '12 June 2025, 19:56', NULL),
(18, 'BR018', 9, 'AMERICANO', 'Custom', '7000', '15000', 'PCS', '50', '12 June 2025, 19:57', NULL),
(19, 'BR019', 10, 'CHILI NOODLE 808', 'Custom', '7000', '15000', 'PCS', '49', '12 June 2025, 19:57', NULL),
(20, 'BR020', 10, 'ACEH NOODLE 808', 'Custom', '7000', '15000', 'PCS', '49', '12 June 2025, 19:57', NULL),
(21, 'BR021', 10, 'CREAMY NOODLE 808', 'Custom', '8000', '16000', 'PCS', '49', '12 June 2025, 19:58', NULL),
(22, 'BR022', 11, 'AYAM TERIYAKI', 'Custom', '12000', '20000', 'PCS', '50', '12 June 2025, 19:58', NULL),
(23, 'BR023', 11, 'AYAM BLACKPEPPER', 'Custom', '12000', '20000', 'PCS', '50', '12 June 2025, 19:59', NULL),
(24, 'BR024', 11, 'SAMBEL MATAH', 'Custom', '12000', '20000', 'PCS', '50', '12 June 2025, 19:59', NULL),
(25, 'BR025', 11, 'THAI BASIL', 'Custom', '12000', '20000', 'PCS', '49', '12 June 2025, 19:59', NULL),
(29, 'BR026', 8, 'Nheir', 'Custom', '10000', '18000', '#', '50', '15 June 2025, 1:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
