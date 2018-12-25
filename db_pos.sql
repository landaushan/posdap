-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2018 pada 14.31
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_barang`
--

CREATE TABLE `ma_barang` (
  `kd_barang` varchar(5) NOT NULL,
  `nm_barang` varchar(50) NOT NULL,
  `kd_satuan` varchar(10) NOT NULL,
  `kd_kategori` varchar(10) NOT NULL,
  `hrg_jual` int(11) NOT NULL,
  `hrg_beli` int(11) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_barang`
--

INSERT INTO `ma_barang` (`kd_barang`, `nm_barang`, `kd_satuan`, `kd_kategori`, `hrg_jual`, `hrg_beli`, `active`) VALUES
('00001', 'IKAN SALMON', 'S00002', 'K00004', 68000, 57000, 'Y'),
('00002', 'AVOCADO', 'S00001', 'K00001', 30000, 29800, 'Y'),
('00003', 'NASUBI (TERONG JEPANG)', 'S00003', 'K00002', 22000, 20000, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_customer`
--

CREATE TABLE `ma_customer` (
  `id_customer` varchar(7) NOT NULL,
  `nm_customer` varchar(255) NOT NULL,
  `alamat_customer` varchar(255) NOT NULL,
  `kota_customer` varchar(255) NOT NULL,
  `tlp_customer` varchar(255) NOT NULL,
  `email_customer` varchar(255) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_customer`
--

INSERT INTO `ma_customer` (`id_customer`, `nm_customer`, `alamat_customer`, `kota_customer`, `tlp_customer`, `email_customer`, `status`) VALUES
('CUS0001', 'PT SUSHI TEI INDONESIA', 'Kota Kasablanka', 'Jakarta', '(021) 4721 3123', 'purchteam@sushitei.co.id', 'Y'),
('CUS0002', 'PAPAYA SUSHI', 'Gd. City Walk Sudirman Unit', 'Jakarta', '(021) 52761876', 'Purchasing@papaya.co.id', 'Y'),
('CUS0003', 'SUSHI HIRO', 'PIK Avenue', 'Jakarta', '(021) 6125 1521', 'Purchasing@hirogroup.com', 'Y'),
('CUS0004', 'NEGIYA', 'Jl. Pangeran Jayakarta 40', 'Jakarta', '(021) 6214 5137', 'Purch@negiya.co.id', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_kategori_barang`
--

CREATE TABLE `ma_kategori_barang` (
  `kd_kategori` varchar(6) NOT NULL,
  `nm_kategori` varchar(25) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_kategori_barang`
--

INSERT INTO `ma_kategori_barang` (`kd_kategori`, `nm_kategori`, `active`) VALUES
('K00001', 'BUAH', 'Y'),
('K00002', 'SAYUR', 'Y'),
('K00003', 'SAUS', 'Y'),
('K00004', 'IKAN', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_satuan_barang`
--

CREATE TABLE `ma_satuan_barang` (
  `kd_satuan` varchar(6) NOT NULL,
  `nm_satuan` varchar(25) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_satuan_barang`
--

INSERT INTO `ma_satuan_barang` (`kd_satuan`, `nm_satuan`, `active`) VALUES
('S00001', 'KG', 'Y'),
('S00002', 'GRAM', 'Y'),
('S00003', 'PCS', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_supplier`
--

CREATE TABLE `ma_supplier` (
  `kd_supplier` varchar(7) NOT NULL,
  `nm_supplier` varchar(25) NOT NULL,
  `almt_supplier` varchar(150) NOT NULL,
  `tlp_supplier` varchar(15) NOT NULL,
  `fax_supplier` varchar(15) NOT NULL,
  `atas_nama` varchar(25) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_supplier`
--

INSERT INTO `ma_supplier` (`kd_supplier`, `nm_supplier`, `almt_supplier`, `tlp_supplier`, `fax_supplier`, `atas_nama`, `active`) VALUES
('SUP0001', 'CV ALAM PERMAI', 'Jl. Residen Abdul Rozak No. 90 Palembang', '0711-123456', '0711-654321', 'Saka', 'Y'),
('SUP0002', 'UD DWI MAKMUR', 'Jl. Utan Kayu 11', '(021) 52761876', '81251653', 'Yudi', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_toko`
--

CREATE TABLE `ma_toko` (
  `kd_toko` varchar(15) NOT NULL,
  `nm_toko` varchar(30) NOT NULL,
  `almt_toko` varchar(150) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `tlp_toko` varchar(15) NOT NULL,
  `fax_toko` varchar(15) NOT NULL,
  `logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_toko`
--

INSERT INTO `ma_toko` (`kd_toko`, `nm_toko`, `almt_toko`, `kota`, `tlp_toko`, `fax_toko`, `logo`) VALUES
('TK001', 'CV DWI ABADI PRATAMA', 'Jl. Raya Penggilingan', 'Jakarta Timur', '021 800123', '021 800321', 'logo_sarolangun.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ma_user`
--

CREATE TABLE `ma_user` (
  `id_user` varchar(6) NOT NULL,
  `nm_lengkap` varchar(30) NOT NULL,
  `nm_user` varchar(25) NOT NULL,
  `password` varchar(35) NOT NULL,
  `akses` varchar(15) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ma_user`
--

INSERT INTO `ma_user` (`id_user`, `nm_lengkap`, `nm_user`, `password`, `akses`, `active`) VALUES
('UID005', 'Mega', 'mega1234', '15b80e47cb7b993d71cc36062f965043', 'Kasir', 'Y'),
('UID007', 'Superadmin', 'super', '1b3231655cebb7a1f783eddf27d254ca', 'Super', 'Y'),
('UID008', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id` double NOT NULL,
  `no_transaksi` double NOT NULL,
  `no_faktur` varchar(16) NOT NULL,
  `kd_supplier` varchar(15) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `id_user` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id`, `no_transaksi`, `no_faktur`, `kd_supplier`, `tgl_pembelian`, `total_pembelian`, `id_user`) VALUES
(1, 56, 'INV0001', 'SUP0002', '2018-12-22', 456000, 'UID007');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id` double NOT NULL,
  `no_transaksi` double NOT NULL,
  `kd_barang` varchar(15) NOT NULL,
  `kd_satuan` varchar(25) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id`, `no_transaksi`, `kd_barang`, `kd_satuan`, `jumlah`, `harga`, `sub_total`) VALUES
(1, 56, '00001', 'S00002', 8, 57000, 456000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_tmp`
--

CREATE TABLE `pembelian_tmp` (
  `row_id` int(11) NOT NULL,
  `kd_barang` varchar(15) NOT NULL,
  `kd_satuan` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` double NOT NULL,
  `no_transaksi` double NOT NULL,
  `no_faktur` varchar(15) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `total_penjualan` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `voucher` char(1) DEFAULT 't'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id`, `no_transaksi`, `no_faktur`, `tgl_penjualan`, `total_penjualan`, `user`, `voucher`) VALUES
(11, 67, '18122500001', '2018-12-25', 41600, 'UID007', 'y'),
(12, 68, '18122500002', '2018-12-25', 96000, 'UID007', 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` double NOT NULL,
  `no_transaksi` double NOT NULL,
  `kd_barang` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `hrg_pokok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `no_transaksi`, `kd_barang`, `jumlah`, `harga`, `sub_total`, `hrg_pokok`) VALUES
(25, 67, '00003', 1, 22000, 22000, 0),
(26, 67, '00002', 1, 30000, 30000, 0),
(27, 68, '00001', 1, 68000, 68000, 57000),
(28, 68, '00003', 1, 22000, 22000, 0),
(29, 68, '00002', 1, 30000, 30000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_tmp`
--

CREATE TABLE `penjualan_tmp` (
  `id` double NOT NULL,
  `no_faktur` double NOT NULL,
  `kd_barang` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `hrg_pokok` int(11) NOT NULL,
  `user` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_barang`
--

CREATE TABLE `stock_barang` (
  `id` int(11) NOT NULL,
  `kd_barang` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `hrg_beli_rata2` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stock_barang`
--

INSERT INTO `stock_barang` (`id`, `kd_barang`, `jumlah`, `hrg_beli_rata2`) VALUES
(1, '00001', -3, 57000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_ctr`
--

CREATE TABLE `trans_ctr` (
  `id` double NOT NULL,
  `counter` double NOT NULL,
  `stat` varchar(3) NOT NULL,
  `user` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trans_ctr`
--

INSERT INTO `trans_ctr` (`id`, `counter`, `stat`, `user`) VALUES
(1, 68, 'O', 'hhalat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voucher`
--

CREATE TABLE `voucher` (
  `id_voucher` int(11) NOT NULL,
  `customer_id` varchar(7) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` date NOT NULL,
  `expires_at` date NOT NULL,
  `status_voucher` char(1) DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `voucher`
--

INSERT INTO `voucher` (`id_voucher`, `customer_id`, `code`, `created_at`, `expires_at`, `status_voucher`) VALUES
(1, 'CUS0001', 'X278TDG3', '2018-12-25', '2019-01-25', 'a'),
(2, 'CUS0002', '1A5JKLB3', '2018-12-25', '2019-01-25', 'a');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ma_barang`
--
ALTER TABLE `ma_barang`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indeks untuk tabel `ma_customer`
--
ALTER TABLE `ma_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `ma_kategori_barang`
--
ALTER TABLE `ma_kategori_barang`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indeks untuk tabel `ma_satuan_barang`
--
ALTER TABLE `ma_satuan_barang`
  ADD PRIMARY KEY (`kd_satuan`);

--
-- Indeks untuk tabel `ma_supplier`
--
ALTER TABLE `ma_supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indeks untuk tabel `ma_toko`
--
ALTER TABLE `ma_toko`
  ADD PRIMARY KEY (`kd_toko`);

--
-- Indeks untuk tabel `ma_user`
--
ALTER TABLE `ma_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `kd_barang` (`kd_barang`);

--
-- Indeks untuk tabel `pembelian_tmp`
--
ALTER TABLE `pembelian_tmp`
  ADD PRIMARY KEY (`row_id`),
  ADD KEY `row_id` (`row_id`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_faktur` (`no_faktur`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penjualan_tmp`
--
ALTER TABLE `penjualan_tmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_faktur` (`no_faktur`);

--
-- Indeks untuk tabel `stock_barang`
--
ALTER TABLE `stock_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_barang` (`kd_barang`);

--
-- Indeks untuk tabel `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id_voucher`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
