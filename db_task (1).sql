-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Sep 2021 pada 18.14
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_task`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_grup`
--

CREATE TABLE `t_grup` (
  `kode` varchar(6) NOT NULL,
  `c_namagrup` varchar(50) NOT NULL,
  `c_deskripsigrup` text NOT NULL,
  `c_member` text NOT NULL,
  `c_authorgrup` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_grup`
--

INSERT INTO `t_grup` (`kode`, `c_namagrup`, `c_deskripsigrup`, `c_member`, `c_authorgrup`) VALUES
('BEF009', 'Bahasa Inggris Niaga', 'Mari bersama kita tingkatkan produktifitas dalam pengerjaan tugas.', 'selly', 'selly');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_task`
--

CREATE TABLE `t_task` (
  `id` int(11) NOT NULL,
  `c_namatugas` varchar(50) NOT NULL,
  `c_mulaitugas` date NOT NULL,
  `c_selesaitugas` date NOT NULL,
  `c_deadline` time NOT NULL,
  `c_deskripsi` text NOT NULL,
  `c_reff` text NOT NULL,
  `c_type` varchar(10) NOT NULL,
  `c_author` varchar(50) NOT NULL,
  `c_grup` varchar(6) NOT NULL,
  `c_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_task`
--

INSERT INTO `t_task` (`id`, `c_namatugas`, `c_mulaitugas`, `c_selesaitugas`, `c_deadline`, `c_deskripsi`, `c_reff`, `c_type`, `c_author`, `c_grup`, `c_stat`) VALUES
(11, 'Bahasa Inggrizzz', '2021-05-21', '2021-05-23', '17:30:00', 'Sdd\r\nD\r\nDdd\r\nDdddd', '', 'self', 'mnmahmud', '', 1),
(12, 'Kalkulus', '2021-05-19', '2021-05-24', '18:50:00', 'Yoiiii', '', 'self', 'mnmahmud', '', 1),
(13, 'Matematika Diskrit', '2021-05-18', '2021-05-20', '06:29:00', 'Tes aja broo', '', 'self', 'mnmahmud', '', 0),
(15, 'Apaaaa', '2021-09-08', '2021-09-14', '04:30:00', 'Aaaaa\r\nDdf\r\nTyg\r\nHhh', '', 'self', 'mnmahmud', '', 1),
(16, 'Keren', '2021-09-18', '2021-09-23', '20:20:00', 'Hh\r\nUjj\r\nUjj\r\nHhh\r\n', '', 'self', 'mnmahmud', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `c_nama` varchar(50) NOT NULL,
  `c_telp` varchar(13) NOT NULL,
  `c_status` varchar(20) NOT NULL,
  `c_deskripsi` text NOT NULL,
  `c_foto` varchar(50) NOT NULL,
  `c_user` varchar(30) NOT NULL,
  `c_pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id`, `c_nama`, `c_telp`, `c_status`, `c_deskripsi`, `c_foto`, `c_user`, `c_pass`) VALUES
(1, 'M Nurhasan Mahmudi', '0895344463727', 'Mahasiswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'mnmahmud', '$2y$10$v2J8wkJAAm.qBy2b2d.lUuj3dq2nMC7m9klo01NcArGYhCApVpXta'),
(2, 'Arya Pandu Pradana', '', 'Siswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'pandu', '$2y$10$ziAd6njbxApLIS4ryYE7kewHzt2u5xysH4Qq6KyBdMHeBNhc4Xh/u'),
(3, 'Muhammad Rais Aufydin Maraya', '', 'Siswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'rais', '$2y$10$ziAd6njbxApLIS4ryYE7kewHzt2u5xysH4Qq6KyBdMHeBNhc4Xh/u'),
(4, 'Selly Diah Ayunengtyas', '0895344463727', 'Mahasiswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'Selly', '$2y$10$ziAd6njbxApLIS4ryYE7kewHzt2u5xysH4Qq6KyBdMHeBNhc4Xh/u'),
(5, 'Maulana Yusuf Syawalludin', '', 'Siswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'ecep', '$2y$10$ziAd6njbxApLIS4ryYE7kewHzt2u5xysH4Qq6KyBdMHeBNhc4Xh/u'),
(6, 'Admin', '880', 'Mahasiswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '', 'admin', '$2y$10$Y5gBxyAlC5xEn5Ux8wl9B.vKUtvLeyx91ykC89a27tTyAKlK64pgi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_grup`
--
ALTER TABLE `t_grup`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `t_task`
--
ALTER TABLE `t_task`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_task`
--
ALTER TABLE `t_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
