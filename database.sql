-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2022 at 02:01 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_nomor` int(11) NOT NULL,
  `invoice_tanggal` date NOT NULL,
  `invoice_pelanggan` varchar(255) NOT NULL,
  `invoice_kasir` int(11) NOT NULL,
  `invoice_sub_total` int(11) NOT NULL,
  `invoice_diskon` int(11) NOT NULL,
  `invoice_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `kasir_id` int(11) NOT NULL,
  `kasir_nama` varchar(255) NOT NULL,
  `kasir_username` varchar(255) NOT NULL,
  `kasir_password` varchar(255) NOT NULL,
  `kasir_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kasir`
--

INSERT INTO `kasir` (`kasir_id`, `kasir_nama`, `kasir_username`, `kasir_password`, `kasir_foto`) VALUES
(1, 'PANDI', 'pandi', 'e10adc3949ba59abbe56e057f20f883e', ''),
(6, 'iqbal', 'iqbal', '6c31fc0f69bbf07cba275ff861d99123', ''),
(7, 'Kasir', 'kasir1', '29c748d4d8f4bd5cbc0f3f60cb7ed3d0', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `pengeluaran_kasir`
--

CREATE TABLE `pengeluaran_kasir` (
  `id_pengeluaran` int(11) NOT NULL,
  `kasir_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pengeluaran` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `pimpinan`
--

CREATE TABLE `pimpinan` (
  `pimpinan_id` int(11) NOT NULL,
  `pimpinan_nama` varchar(255) NOT NULL,
  `pimpinan_username` varchar(255) NOT NULL,
  `pimpinan_password` varchar(255) NOT NULL,
  `pimpinan_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pimpinan`
--

INSERT INTO `pimpinan` (`pimpinan_id`, `pimpinan_nama`, `pimpinan_username`, `pimpinan_password`, `pimpinan_foto`) VALUES
(1, 'Appimpinan Pattaya', 'pimpinan1', 'a1475279de60efc1b418fa651f695384', ''),
(2, 'iqbal', 'iqbal', '6c31fc0f69bbf07cba275ff861d99123', '');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL,
  `produk_kode` varchar(255) NOT NULL,
  `produk_nama` varchar(255) NOT NULL,
  `produk_satuan` varchar(20) NOT NULL,
  `produk_kategori` int(11) NOT NULL,
  `produk_stok` int(11) NOT NULL,
  `produk_harga_modal` int(11) NOT NULL,
  `produk_harga_jual` int(11) NOT NULL,
  `produk_keterangan` text NOT NULL,
  `produk_foto` varchar(255) NOT NULL,
  `produk_kwantitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `transaksi_invoice` int(11) NOT NULL,
  `transaksi_produk` int(11) NOT NULL,
  `transaksi_harga` int(11) NOT NULL,
  `transaksi_jumlah` int(11) NOT NULL,
  `transaksi_total` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `potongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_username`, `user_password`, `user_foto`) VALUES
(1, 'Admin', 'admin', '6c31fc0f69bbf07cba275ff861d99123', '482937136_avatar.png'),
(9, 'tria', 'tria', 'e10adc3949ba59abbe56e057f20f883e', '682582467_WhatsApp Image 2022-07-10 at 09.58.10.jpeg'),
(10, 'Admin', 'ngadimin', '46f94c8de14fb36680850768ff1b7f2a', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`kasir_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `pengeluaran_kasir`
--
ALTER TABLE `pengeluaran_kasir`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `pimpinan`
--
ALTER TABLE `pimpinan`
  ADD PRIMARY KEY (`pimpinan_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `kasir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12379;

--
-- AUTO_INCREMENT for table `pengeluaran_kasir`
--
ALTER TABLE `pengeluaran_kasir`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;

--
-- AUTO_INCREMENT for table `pimpinan`
--
ALTER TABLE `pimpinan`
  MODIFY `pimpinan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
