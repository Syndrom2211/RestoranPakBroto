-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2017 at 06:20 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restoran`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bahan` int(5) NOT NULL,
  `no_bahan` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `status_bahan_baku` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id_bahan`, `no_bahan`, `nama`, `jenis`, `status_bahan_baku`) VALUES
(7, 22, 'Beras', 'Beras Galo', 'Tersedia'),
(6, 35, 'Telor', 'Telor', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `detail_bahanbaku`
--

CREATE TABLE `detail_bahanbaku` (
  `id_detail` int(5) NOT NULL,
  `no_bahan` int(5) NOT NULL,
  `no_pegawai` int(5) NOT NULL,
  `pengecekan_bahan` date DEFAULT NULL,
  `pengecekan_selanjutnya` date DEFAULT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_kadaluarsa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_bahanbaku`
--

INSERT INTO `detail_bahanbaku` (`id_detail`, `no_bahan`, `no_pegawai`, `pengecekan_bahan`, `pengecekan_selanjutnya`, `tgl_masuk`, `tgl_kadaluarsa`) VALUES
(6, 35, 15, '2017-01-24', '2017-01-31', '2017-01-24', '2017-01-27'),
(7, 22, 15, '2017-01-25', '2017-02-01', '2017-01-24', '2017-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `detail_menu`
--

CREATE TABLE `detail_menu` (
  `id_detail_menu` int(5) NOT NULL,
  `no_makanan` int(5) NOT NULL,
  `no_bahan` int(5) NOT NULL,
  `status_makanan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_menu`
--

INSERT INTO `detail_menu` (`id_detail_menu`, `no_makanan`, `no_bahan`, `status_makanan`) VALUES
(6, 42, 22, 'Tersedia'),
(7, 42, 35, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(5) NOT NULL,
  `jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`) VALUES
(1, 'Pelayan'),
(2, 'Pantry'),
(3, 'Customer Service'),
(4, 'Kasir'),
(5, 'Koki'),
(6, 'Manajer');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL,
  `no_makanan` int(5) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `harga` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `no_makanan`, `nama`, `jenis`, `harga`) VALUES
(4, 42, 'Udang sambal goreng', 'Udang', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `menu_pesanan`
--

CREATE TABLE `menu_pesanan` (
  `id_menu_pemesanan` int(5) NOT NULL,
  `no_pelanggan` int(5) NOT NULL,
  `list_menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_pesanan`
--

INSERT INTO `menu_pesanan` (`id_menu_pemesanan`, `no_pelanggan`, `list_menu`) VALUES
(19, 25, 'Omelet (12000)');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `no_pegawai` int(5) NOT NULL,
  `id_jabatan` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `alamat` text NOT NULL,
  `no_handphone` varchar(30) NOT NULL,
  `waktu_kerja` varchar(20) NOT NULL,
  `bagian_kerja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`no_pegawai`, `id_jabatan`, `nama`, `username`, `password`, `jenis_kelamin`, `alamat`, `no_handphone`, `waktu_kerja`, `bagian_kerja`) VALUES
(8, 5, 'Koki', 'koki', 'c38be0f1f87d0e77a0cd2fe6941253eb', 'L', 'jalan terusan kopo, taman kopo katapang Block N17', '089686683730', '07:00 - 12:00', 'Menggoreng Makanan'),
(12, 1, 'Pelayan', 'pelayan', '511cc40443f2a1ab03ab373b77d28091', 'L', 'cxcxcxc', '085798160154', '07:00 - 12:00', 'sasasa'),
(13, 3, 'Customer Service', 'cs', '95cc64dd2825f9df13ec4ad683ecf339', 'L', 'Sekeloa Timur', '085798160154', '07:00 - 12:00', 'Melayani Pelanggan'),
(14, 4, 'Kasir', 'kasir', 'c7911af3adbd12a035b289556d96470a', 'L', 'Bojong Soang', '085798160154', '07:00 - 12:00', 'Melayani Pembayaran'),
(15, 2, 'Pantry', 'pantry', 'dfc1c8bed5de7350be927562047dd29f', 'L', 'BOJONGSOANG', '085798160154', '07:00 - 12:00', 'jAGA mAKANAN'),
(16, 6, 'Manajer', 'manajer', '69b731ea8f289cf16a192ce78a37b4f0', 'L', 'sasasasaas', '085798160154', '07:00 - 12:00', 'Cek Pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(5) NOT NULL,
  `no_pelanggan` int(10) NOT NULL,
  `no_pegawai` int(5) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `no_handphone` varchar(20) NOT NULL,
  `kritik_saran` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `no_pelanggan`, `no_pegawai`, `atas_nama`, `jenis_kelamin`, `no_handphone`, `kritik_saran`) VALUES
(30, 25, 12, 'Jodi Rizaldi Akbar', 'L', '089686683730', 'Mantap sekali pak broto'),
(28, 42, 12, 'Firdamdam Sasmita', 'L', '085798160154', NULL),
(27, 55, 12, 'Firdamdam Sasmita', 'L', '085798160154', NULL),
(29, 73, 12, 'Jodi Rizaldi Akbar', 'L', '089686683730', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_transaksi` int(5) NOT NULL,
  `no_pelanggan` int(5) NOT NULL,
  `makanan_pesanan` text NOT NULL,
  `tgl_bayar` date NOT NULL,
  `waktu_bayar` varchar(10) NOT NULL,
  `total_bayar` int(5) NOT NULL,
  `status_bayar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_transaksi`, `no_pelanggan`, `makanan_pesanan`, `tgl_bayar`, `waktu_bayar`, `total_bayar`, `status_bayar`) VALUES
(10, 25, 'Omelet (12000), , , , , ', '2017-01-24', '21:49:49', 12000, 'Belum Bayar');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pesanan` int(5) NOT NULL,
  `no_pelanggan` int(10) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `waktu_pesan` varchar(15) NOT NULL,
  `no_meja` int(5) NOT NULL,
  `status_pembuatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pesanan`, `no_pelanggan`, `tgl_pesan`, `waktu_pesan`, `no_meja`, `status_pembuatan`) VALUES
(23, 25, '2017-01-24', '21:49:01', 67, 'Belum Jadi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`no_bahan`),
  ADD UNIQUE KEY `id_bahan` (`id_bahan`);

--
-- Indexes for table `detail_bahanbaku`
--
ALTER TABLE `detail_bahanbaku`
  ADD UNIQUE KEY `id_detail` (`id_detail`),
  ADD KEY `no_bahan` (`no_bahan`),
  ADD KEY `no_pegawai` (`no_pegawai`);

--
-- Indexes for table `detail_menu`
--
ALTER TABLE `detail_menu`
  ADD UNIQUE KEY `id_detail_menu` (`id_detail_menu`),
  ADD KEY `no_makanan` (`no_makanan`),
  ADD KEY `no_bahan` (`no_bahan`),
  ADD KEY `no_makanan_2` (`no_makanan`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `no_makanan` (`no_makanan`);

--
-- Indexes for table `menu_pesanan`
--
ALTER TABLE `menu_pesanan`
  ADD PRIMARY KEY (`id_menu_pemesanan`),
  ADD KEY `id_pesanan` (`no_pelanggan`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`no_pegawai`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_pelanggan`),
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `tbl_pelanggan_ibfk_1` (`no_pegawai`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `no_pelanggan` (`no_pelanggan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD UNIQUE KEY `no_meja` (`no_meja`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `no_pelanggan` (`no_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id_bahan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `detail_bahanbaku`
--
ALTER TABLE `detail_bahanbaku`
  MODIFY `id_detail` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `detail_menu`
--
ALTER TABLE `detail_menu`
  MODIFY `id_detail_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `menu_pesanan`
--
ALTER TABLE `menu_pesanan`
  MODIFY `id_menu_pemesanan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `no_pegawai` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_transaksi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pesanan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_bahanbaku`
--
ALTER TABLE `detail_bahanbaku`
  ADD CONSTRAINT `detail_bahanbaku_ibfk_1` FOREIGN KEY (`no_bahan`) REFERENCES `bahan_baku` (`no_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_bahanbaku_ibfk_2` FOREIGN KEY (`no_pegawai`) REFERENCES `pegawai` (`no_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_menu`
--
ALTER TABLE `detail_menu`
  ADD CONSTRAINT `detail_menu_ibfk_2` FOREIGN KEY (`no_bahan`) REFERENCES `bahan_baku` (`no_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_menu_ibfk_3` FOREIGN KEY (`no_makanan`) REFERENCES `menu` (`no_makanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_pesanan`
--
ALTER TABLE `menu_pesanan`
  ADD CONSTRAINT `menu_pesanan_ibfk_1` FOREIGN KEY (`no_pelanggan`) REFERENCES `pelanggan` (`no_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`no_pegawai`) REFERENCES `pegawai` (`no_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`no_pelanggan`) REFERENCES `pelanggan` (`no_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`no_pelanggan`) REFERENCES `pelanggan` (`no_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
