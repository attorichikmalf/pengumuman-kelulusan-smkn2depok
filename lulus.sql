-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2025 pada 19.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lulus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `nama`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin123@gmail.com', 'fajar', '$2y$10$umpNY4JYABYXDKuPaESmBOz6AyNrU4v.6ZY5oMuD.R5BZgBDC72c.', '2025-03-22 16:05:59', '2025-03-25 18:16:04'),
(12, 'fajar', 'fajar@gmail.com', 'Attoric H', '$2y$10$.2bmLTCU5ndu18rjCGWoJuOnQB2brMej.ewr2WdC8bi0Pkta3bPyC', '2025-03-26 03:40:30', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `countdown_time`
--

CREATE TABLE `countdown_time` (
  `id` int(11) NOT NULL,
  `target_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `countdown_time`
--

INSERT INTO `countdown_time` (`id`, `target_time`) VALUES
(1, '2025-07-29 06:44:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_pengumuman_gagal`
--

CREATE TABLE `log_pengumuman_gagal` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `nisn_hash` char(64) DEFAULT NULL,
  `nis_hash` char(64) DEFAULT NULL,
  `tanggal_lahir_input` date DEFAULT NULL,
  `status_cocok` varchar(100) DEFAULT NULL,
  `nama_diduga` varchar(100) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman_log`
--

CREATE TABLE `pengumuman_log` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `waktu_lihat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `npsn` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `background` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama_sekolah`, `npsn`, `alamat`, `kota`, `provinsi`, `logo`, `created_at`, `updated_at`, `background`) VALUES
(1, 'SMK NEGERI 2 DEPOK', '20229220', 'Pintu 2 Telaga Golf Sawangan', 'Kota Depok', 'Jawa Barat', 'logo_1748697888.png', '2025-03-24 16:33:12', '2025-05-31 18:10:49', 'background_1748715049.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `pesan` text DEFAULT NULL,
  `link_google_drive` varchar(255) DEFAULT NULL,
  `status` enum('Lulus','Tidak Lulus') NOT NULL DEFAULT 'Tidak Lulus',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sudah_melihat` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `countdown_time`
--
ALTER TABLE `countdown_time`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_pengumuman_gagal`
--
ALTER TABLE `log_pengumuman_gagal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_log_fail_ip` (`ip_address`),
  ADD KEY `idx_log_fail_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `pengumuman_log`
--
ALTER TABLE `pengumuman_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_siswa` (`id_siswa`),
  ADD KEY `idx_pengumuman_log_siswa_id` (`id_siswa`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `npsn` (`npsn`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `idx_nisn` (`nisn`),
  ADD KEY `idx_nis` (`nis`),
  ADD KEY `idx_tanggal_lahir` (`tanggal_lahir`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `countdown_time`
--
ALTER TABLE `countdown_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `log_pengumuman_gagal`
--
ALTER TABLE `log_pengumuman_gagal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman_log`
--
ALTER TABLE `pengumuman_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_pengumuman_gagal`
--
ALTER TABLE `log_pengumuman_gagal`
  ADD CONSTRAINT `log_pengumuman_gagal_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengumuman_log`
--
ALTER TABLE `pengumuman_log`
  ADD CONSTRAINT `pengumuman_log_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
