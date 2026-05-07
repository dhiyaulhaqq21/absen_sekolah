-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Bulan Mei 2026 pada 00.05
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `sesi_id` int(11) NOT NULL,
  `waktu_absen` datetime DEFAULT current_timestamp(),
  `status` enum('hadir','telat') DEFAULT 'hadir',
  `keterlambatan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `siswa_id`, `sesi_id`, `waktu_absen`, `status`, `keterlambatan`) VALUES
(21, 1, 8, '2026-05-08 04:02:21', 'hadir', 0),
(22, 4, 8, '2026-05-08 04:03:51', 'hadir', 0),
(23, 3, 8, '2026-05-08 04:04:13', 'hadir', 0),
(24, 2, 8, '2026-05-08 04:15:12', '', 0),
(25, 6, 8, '2026-05-08 04:15:12', '', 0),
(26, 1, 9, '2026-05-08 04:23:51', 'hadir', 0),
(27, 4, 9, '2026-05-08 04:24:55', 'hadir', 0),
(28, 3, 9, '2026-05-08 04:25:37', 'hadir', 0),
(29, 6, 7, '2026-05-08 04:26:29', 'telat', 89),
(30, 1, 10, '2026-05-08 04:40:00', 'hadir', 0),
(31, 2, 9, '2026-05-08 04:41:02', 'telat', 19),
(32, 6, 9, '2026-05-08 04:42:03', 'telat', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_sesi`
--

CREATE TABLE `absensi_sesi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `token` varchar(50) NOT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mapel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_sesi`
--

INSERT INTO `absensi_sesi` (`id`, `tanggal`, `jam_mulai`, `jam_selesai`, `token`, `dibuat_oleh`, `created_at`, `mapel_id`) VALUES
(7, '2026-05-08', '02:57:00', '04:57:00', '05BCC7', 1, '2026-05-07 19:57:59', NULL),
(8, '2026-05-08', '04:01:00', '04:07:00', '29F9CE', 1, '2026-05-07 21:01:48', NULL),
(9, '2026-05-08', '04:22:00', '05:22:00', 'EA4EA7', 1, '2026-05-07 21:22:44', NULL),
(10, '2026-05-08', '04:38:00', '05:38:00', 'CCF2CB', 1, '2026-05-07 21:38:46', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `username`, `password`, `created_at`, `kelas_id`) VALUES
(1, '1001', 'Ahmad', 'X RPL', 'ahmad', '$2y$10$BpZdqfly0xe55SLzR92bPeCCqGvtXsxugJdeLRipwa/g0lzFSVR8C', '2026-04-06 19:55:22', NULL),
(2, '1002', 'Budi', 'X RPL', 'budi', '$2y$10$BpZdqfly0xe55SLzR92bPeCCqGvtXsxugJdeLRipwa/g0lzFSVR8C', '2026-04-06 19:55:22', NULL),
(3, '1003', 'Ali Ma\'sum Gondrong', 'X IPS 3', 'gondrong', '$2y$10$tc5zW5kmoejGVAeD6KaIEOXuFlpJRK0DCQ9PWuvNh2Z56325Gc9a6', '2026-05-07 19:07:42', NULL),
(4, '1004', 'Si Broo', 'X IPS 2', 'bro', '$2y$10$0tqYN/Zf4pwZ5F11Bxn6teYznbT2NWx7c0BgD.j53sPsFVsFILWyu', '2026-05-07 19:39:32', NULL),
(6, '1005', 'Kamiluddin', 'X IPA 1', 'kamil', '$2y$10$9q4NglvpSKC.TXLyaE.h8u7N.VDMbWnDhi9YBDRXKyK4o3/Y6q97y', '2026-05-07 20:06:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staf`
--

CREATE TABLE `staf` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `level` enum('admin','staf') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `staf`
--

INSERT INTO `staf` (`id`, `username`, `password`, `nama`, `level`, `created_at`) VALUES
(1, 'admin', '$2y$10$.AhlWWXLF.4d2sFRq15I9.klB5bu/cXbWZgrefEqJsVnwFI5lQ2t6', 'Administrator', 'admin', '2026-04-06 19:55:08');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`sesi_id`),
  ADD KEY `sesi_id` (`sesi_id`);

--
-- Indeks untuk tabel `absensi_sesi`
--
ALTER TABLE `absensi_sesi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `staf`
--
ALTER TABLE `staf`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `absensi_sesi`
--
ALTER TABLE `absensi_sesi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `staf`
--
ALTER TABLE `staf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`sesi_id`) REFERENCES `absensi_sesi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `absensi_sesi`
--
ALTER TABLE `absensi_sesi`
  ADD CONSTRAINT `absensi_sesi_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `staf` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_sesi_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
