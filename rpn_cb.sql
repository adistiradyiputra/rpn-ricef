-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 20, 2025 at 08:04 AM
-- Server version: 8.0.41
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpn_cb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_soal`
--

CREATE TABLE `bank_soal` (
  `id` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id`, `pertanyaan`, `aktif`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Apa itu Sawit', 1, '2025-03-24 11:50:16', '2025-03-24 11:50:16', NULL, NULL),
(2, '1 + 1 =', 1, '2025-03-24 11:50:16', '2025-03-24 11:50:16', NULL, NULL),
(3, 'Test ', 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26', NULL, NULL),
(4, '1 + 1', 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26', NULL, NULL),
(5, '3+1*0', 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26', NULL, NULL),
(6, 'Test ', 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26', NULL, NULL),
(7, '1 + 1', 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26', NULL, NULL),
(8, '3+1*0', 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26', NULL, NULL),
(9, 'Test ', 1, '2025-03-24 12:59:55', '2025-03-24 13:09:48', NULL, NULL),
(10, '1 + 1', 1, '2025-03-24 12:59:55', '2025-03-24 13:09:48', NULL, NULL),
(11, '3+1*0', 1, '2025-03-24 12:59:55', '2025-03-24 13:09:48', NULL, NULL),
(12, '1', 1, '2025-03-24 13:09:25', '2025-03-24 13:09:48', NULL, NULL),
(13, '1 + 1', 1, '2025-03-24 13:35:03', '2025-03-24 13:35:28', NULL, NULL),
(14, '0 + 1', 1, '2025-03-24 13:35:03', '2025-03-24 13:35:28', NULL, NULL),
(15, '1+1', 1, '2025-03-24 13:36:31', '2025-03-24 13:48:16', NULL, NULL),
(16, '3', 1, '2025-03-24 13:36:31', '2025-03-24 13:48:16', NULL, NULL),
(17, '2', 1, '2025-03-24 13:39:58', '2025-03-24 13:39:58', NULL, NULL),
(18, 'Test', 1, '2025-03-25 11:52:30', '2025-03-25 11:52:30', NULL, NULL),
(19, '1+1', 1, '2025-03-25 11:52:30', '2025-03-25 11:52:30', NULL, NULL),
(20, 'Apa itu ?', 1, '2025-04-28 08:25:06', '2025-04-28 08:25:06', NULL, NULL),
(21, 'Siapa itu A ?', 1, '2025-04-28 08:25:06', '2025-04-28 08:25:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pelatihan`
--

CREATE TABLE `detail_pelatihan` (
  `id` int NOT NULL,
  `id_pelatihan` int NOT NULL,
  `periode_mulai_daftar` date NOT NULL,
  `periode_selesai_daftar` date NOT NULL,
  `jadwal_pelatihan` date NOT NULL,
  `pemateri` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pelatihan`
--

INSERT INTO `detail_pelatihan` (`id`, `id_pelatihan`, `periode_mulai_daftar`, `periode_selesai_daftar`, `jadwal_pelatihan`, `pemateri`, `status`, `image_url`, `created_at`, `updated_at`) VALUES
(5, 6, '2025-03-17', '2025-03-19', '2025-03-17', '6', 1, 'http://localhost:8080/uploads/pelatihan/1742187419_a0b036d1f3655b5f6310.jpg', '2025-03-17 11:28:19', '2025-03-19 09:54:01'),
(6, 40, '2025-03-17', '2025-03-17', '2025-03-19', '7', 1, 'http://localhost:8080/uploads/pelatihan/1742187377_22973f14122da4bbbaad.jpg', '2025-03-17 11:56:17', '2025-03-19 09:51:03'),
(7, 41, '2025-03-26', '2025-03-25', '2025-03-25', '7', 1, 'http://localhost:8080/uploads/pelatihan/1742354428_60e590e07353f9f3c448.png', '2025-03-19 10:20:28', '2025-03-25 11:54:49'),
(8, 10, '2025-03-23', '2025-03-24', '2025-03-24', '6', 1, 'http://localhost:8080/uploads/pelatihan/1742436127_4c556fbfe637484d9888.png', '2025-03-20 09:02:07', '2025-05-11 13:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int NOT NULL,
  `id_detail_pelatihan` int NOT NULL,
  `nama_dokumen` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lampiran` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id`, `id_detail_pelatihan`, `nama_dokumen`, `lampiran`, `created_at`, `updated_at`) VALUES
(5, 1, 'Dokumen 1', 'http://localhost:8080/uploads/dokumen/1741850332_65c6426b117f4e6571ff.jpg', '2025-03-13 03:00:09', '2025-03-13 07:18:52'),
(11, 1, 'Dokumen 2', 'http://localhost:8080/uploads/dokumen/1741850713_ba9f68dffa610cb71fa6.jpg', '2025-03-13 07:25:13', '2025-03-13 07:25:34'),
(12, 5, 'PPKS', 'http://localhost:8080/uploads/dokumen/1741851408_1ea1221466f40270bf2b.png', '2025-03-13 07:36:35', '2025-03-13 07:36:48'),
(14, 6, 'test', 'http://localhost:8080/uploads/dokumen/1741921102_64c480af336cb23fc48a.png', '2025-03-14 02:58:22', '2025-03-17 12:01:08'),
(15, 7, 'Dokumen 1', 'http://localhost:8080/uploads/dokumen/1741924646_d4945f655dfa4ab2e280.docx', '2025-03-14 03:57:07', '2025-03-14 03:57:26'),
(17, 5, 'Kopi', 'http://localhost:8080/uploads/dokumen/1742187705_f2d91a508fffb378feed.docx', '2025-03-17 12:01:29', '2025-03-17 12:01:45'),
(18, 8, 'test', 'http://localhost:8080/uploads/dokumen/1742436182_8c77819eb470f761996b.pdf', '2025-03-20 09:03:02', '2025-03-20 09:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_test`
--

CREATE TABLE `hasil_test` (
  `id` int NOT NULL,
  `id_peserta` int NOT NULL,
  `id_set_soal` int NOT NULL,
  `nilai_mentah` decimal(5,2) DEFAULT '0.00',
  `nilai_akhir` decimal(5,2) DEFAULT '0.00',
  `status_lulus` tinyint(1) DEFAULT '0',
  `status_verifikasi` enum('belum','proses','terverifikasi') DEFAULT 'belum',
  `catatan` text,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `diverifikasi_oleh` int DEFAULT NULL,
  `waktu_verifikasi` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hasil_test`
--

INSERT INTO `hasil_test` (`id`, `id_peserta`, `id_set_soal`, `nilai_mentah`, `nilai_akhir`, `status_lulus`, `status_verifikasi`, `catatan`, `waktu_mulai`, `waktu_selesai`, `diverifikasi_oleh`, `waktu_verifikasi`, `created_at`, `updated_at`) VALUES
(3, 11, 5, 100.00, 100.00, 1, 'terverifikasi', 'test', NULL, '2025-03-24 13:48:56', NULL, NULL, '2025-03-24 13:37:03', '2025-03-24 14:24:37'),
(4, 16, 7, 100.00, 100.00, 1, 'terverifikasi', '', NULL, '2025-03-25 11:57:02', NULL, NULL, '2025-03-25 11:53:32', '2025-03-25 12:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `instruktur`
--

CREATE TABLE `instruktur` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instruktur`
--

INSERT INTO `instruktur` (`id`, `nama`, `username`, `password`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(6, 'Prof. Dr. Ir. Irhan Febijanto, M.Eng', 'irhan', '$2y$10$BaYC7MP0KVHnPYYL/lMf9uxGNDaAy9W3gUq6RYY2pTlCsY63Dx4bK', '2025-03-17 10:52:09', 6, '2025-03-17 11:50:42', 6),
(7, 'Ir. Fhandy Pandey, S.Si., M.T., M.Han', 'fhandy', '$2y$10$knIkmB/X21eqHR2ykiJ2WeVO.nAbcreO.Jo3rLjFARGzv3FjJYY/W', '2025-03-17 11:00:09', 6, '2025-03-17 11:50:33', 6);

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_peserta`
--

CREATE TABLE `jawaban_peserta` (
  `id` int NOT NULL,
  `id_peserta` int NOT NULL,
  `id_set_soal` int NOT NULL,
  `id_soal` int NOT NULL,
  `id_pilihan_jawaban` int DEFAULT NULL,
  `jawaban_text` text,
  `is_benar` tinyint(1) DEFAULT '0',
  `nilai_soal` decimal(5,2) DEFAULT '0.00',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jawaban_peserta`
--

INSERT INTO `jawaban_peserta` (`id`, `id_peserta`, `id_set_soal`, `id_soal`, `id_pilihan_jawaban`, `jawaban_text`, `is_benar`, `nilai_soal`, `waktu_mulai`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(5, 11, 5, 15, 121, NULL, 1, 0.00, NULL, NULL, '2025-03-24 13:48:32', '2025-03-24 13:48:53'),
(6, 11, 5, 16, 124, NULL, 1, 0.00, NULL, NULL, '2025-03-24 13:48:39', '2025-03-24 13:48:51'),
(7, 16, 7, 18, 128, NULL, 1, 0.00, NULL, NULL, '2025-03-25 11:56:49', '2025-03-25 11:56:57'),
(8, 16, 7, 19, 130, NULL, 1, 0.00, NULL, NULL, '2025-03-25 11:56:56', '2025-03-25 11:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `pelatihan`
--

CREATE TABLE `pelatihan` (
  `id` int NOT NULL,
  `puslit` varchar(255) NOT NULL,
  `nama_pelatihan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pelatihan`
--

INSERT INTO `pelatihan` (`id`, `puslit`, `nama_pelatihan`) VALUES
(6, 'PPKKI', 'Uji Cita Rasa Kopi'),
(7, 'PPKKI', 'Uji Cita Rasa Kakao'),
(8, 'PPKKI', 'Teknik Budidaya dan Pengolahan Kopi'),
(9, 'PPKKI', 'Teknik Budidaya dan Pengolahan Kakao'),
(10, 'PPKKI', 'Pengelolaan Organisme Penganggu Tanaman (OTP) Kopi dan kakao'),
(11, 'PPKKI', 'Pembuatan Makanan Cokelat'),
(12, 'PPKKI', 'Manajemen Kafe Barista dan Coffee Brewing'),
(13, 'PPKKI', 'Coffee Roasting and Blanding'),
(14, 'PPKKI', 'Pengolahan Limbah Kopi dan Kakao menjadi Pupuk dan Sumber Energi Alternatif.'),
(17, 'P3GI', 'Budidaya Tanaman Tebu'),
(18, 'P3GI', 'Taksasi Produksi'),
(24, 'P3GI', 'Penyelenggaraan Kebun Bibit'),
(25, 'P3GI', 'Pengenalan dan Identifikasi Varietas tebu'),
(26, 'P3GI', 'Proteksi Tanaman Tebu'),
(27, 'P3GI', 'Ilmu Tanah dan Kesuburan Tanah Untuk Tebu'),
(28, 'P3GI', 'Penetapan Rendemen Tebu'),
(30, 'P3GI', 'Operasional   Serta   Pengujian   Gilingan   dan Ketel Pembangkit Uap di Pabrik Gula'),
(31, 'P3GI', 'Proses Masak Gula'),
(38, 'PPKS', 'Hama Sawit'),
(40, 'PPKS', 'Sawit Indonesia Jaya'),
(41, 'PPKS', 'test 123');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int NOT NULL,
  `id_detail_pelatihan` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `level` int NOT NULL DEFAULT '3',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `id_detail_pelatihan`, `username`, `email`, `password`, `nama`, `alamat`, `instansi`, `telp`, `level`, `created_at`, `updated_at`) VALUES
(11, 5, 'andi', NULL, '$2y$10$wxLDTEerYoLx6f3ZjABQUOoORjU/KuWcpnvPRASAeCUREGP96X2Na', 'andi', 'Kp. Sirnagalih , RT 004 / RW 003', 'RPN', '087750013334', 3, '2025-03-14 02:59:57', '2025-03-19 09:46:51'),
(14, 6, 'angel', NULL, '$2y$10$51H2bFS8tBgbENzhbxGRTunPcQsguEmnfJrzjCslf70xL9cK/XUcy', 'angel', 'Kp. Sirnagalih , RT 004 / RW 003', 'RPN', '087750013334', 3, '2025-03-17 11:57:40', '2025-03-19 09:46:32'),
(15, 8, 'test', NULL, '$2y$10$PpWGVdUyRRuSdMCTnLvoz.vcgyrO9F8BWijUxBkQN/rsjGsW6WaeK', 'test', 'Kp. Sirnagalih , RT 004 / RW 003', 'RPN', '087750013334', 3, '2025-03-20 09:03:42', '2025-03-24 12:03:03'),
(16, 7, 'john', NULL, '$2y$10$oEMNN7D3Y5X90Zvl3.1ffeB9cPvvI23Z1JjFLB82h71WVaC8RQC82', 'john', 'Kp. Sirnagalih , RT 004 / RW 003', 'RPN', '087750013334', 3, '2025-03-25 11:50:55', '2025-05-11 12:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_jawaban`
--

CREATE TABLE `pilihan_jawaban` (
  `id` int NOT NULL,
  `id_soal` int NOT NULL,
  `teks_pilihan` text NOT NULL,
  `is_benar` tinyint(1) DEFAULT '0',
  `urutan` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pilihan_jawaban`
--

INSERT INTO `pilihan_jawaban` (`id`, `id_soal`, `teks_pilihan`, `is_benar`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 3, '1', 1, 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(2, 3, '2', 0, 2, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(3, 3, '23', 0, 3, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(4, 3, '2', 0, 4, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(5, 4, '11', 0, 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(6, 4, '2', 1, 2, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(7, 5, '3', 1, 1, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(8, 5, '20', 0, 2, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(9, 5, '1', 0, 3, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(10, 5, '2', 0, 4, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(11, 5, '3', 0, 5, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(12, 5, 'f', 0, 6, '2025-03-24 12:58:26', '2025-03-24 12:58:26'),
(13, 6, '1', 1, 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(14, 6, '2', 0, 2, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(15, 6, '23', 0, 3, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(16, 6, '2', 0, 4, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(17, 7, '11', 0, 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(18, 7, '2', 1, 2, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(19, 8, '3', 1, 1, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(20, 8, '20', 0, 2, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(21, 8, '1', 0, 3, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(22, 8, '2', 0, 4, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(23, 8, '3', 0, 5, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(24, 8, 'f', 0, 6, '2025-03-24 12:59:26', '2025-03-24 12:59:26'),
(49, 9, '1', 1, 1, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(50, 9, '2', 0, 2, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(51, 9, '23', 0, 3, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(52, 9, '2', 0, 4, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(53, 10, '11', 0, 1, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(54, 10, '2', 1, 2, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(55, 11, '3', 1, 1, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(56, 11, '20', 0, 2, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(57, 11, '1', 0, 3, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(58, 11, '2', 0, 4, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(59, 11, '3', 0, 5, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(60, 11, 'f', 0, 6, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(61, 12, '1', 0, 1, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(62, 12, 'satu', 1, 2, '2025-03-24 13:09:48', '2025-03-24 13:09:48'),
(75, 13, '2', 1, 1, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(76, 14, '1', 1, 1, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(77, 14, 'e', 0, 2, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(78, 14, 'f', 0, 3, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(79, 14, 'g', 0, 4, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(80, 14, 'h', 0, 5, '2025-03-24 13:35:28', '2025-03-24 13:35:28'),
(89, 17, '22', 1, 1, '2025-03-24 13:39:58', '2025-03-24 13:39:58'),
(90, 17, '2', 0, 2, '2025-03-24 13:39:58', '2025-03-24 13:39:58'),
(121, 15, 'dua', 1, 1, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(122, 15, '1', 0, 2, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(123, 15, '4', 0, 3, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(124, 16, '1+2', 1, 1, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(125, 16, '1', 0, 2, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(126, 16, '9', 0, 3, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(127, 16, '10', 0, 4, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(128, 18, '123', 1, 1, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(129, 18, 'test', 0, 2, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(130, 19, '2', 1, 1, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(131, 19, '3', 0, 2, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(132, 19, '4', 0, 3, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(133, 19, '5', 0, 4, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(134, 20, '1', 1, 1, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(135, 20, '2', 0, 2, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(136, 20, '3', 0, 3, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(137, 20, '4', 0, 4, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(138, 21, 'A', 1, 1, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(139, 21, 'B', 0, 2, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(140, 21, 'C', 0, 3, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(141, 21, 'D', 0, 4, '2025-04-28 08:25:06', '2025-04-28 08:25:06');

-- --------------------------------------------------------

--
-- Table structure for table `set_soal`
--

CREATE TABLE `set_soal` (
  `id` int NOT NULL,
  `nama_set` varchar(100) NOT NULL,
  `jenis` enum('pretest','posttest') NOT NULL,
  `id_detail_pelatihan` int NOT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `set_soal`
--

INSERT INTO `set_soal` (`id`, `nama_set`, `jenis`, `id_detail_pelatihan`, `aktif`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(5, 'Set pretest 2025-03-24 13:36:31', 'pretest', 5, 1, '2025-03-24 13:36:31', '2025-03-24 13:48:16', NULL, NULL),
(7, 'Set pretest 2025-03-25 11:52:30', 'pretest', 7, 1, '2025-03-25 11:52:30', '2025-03-25 11:52:30', NULL, NULL),
(8, 'Set pretest 2025-04-28 08:25:06', 'pretest', 7, 1, '2025-04-28 08:25:06', '2025-04-28 08:25:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `set_soal_items`
--

CREATE TABLE `set_soal_items` (
  `id` int NOT NULL,
  `id_set_soal` int NOT NULL,
  `id_soal` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `set_soal_items`
--

INSERT INTO `set_soal_items` (`id`, `id_set_soal`, `id_soal`, `created_at`, `updated_at`) VALUES
(29, 5, 15, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(30, 5, 16, '2025-03-24 13:48:16', '2025-03-24 13:48:16'),
(31, 7, 18, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(32, 7, 19, '2025-03-25 11:52:30', '2025-03-25 11:52:30'),
(33, 8, 20, '2025-04-28 08:25:06', '2025-04-28 08:25:06'),
(34, 8, 21, '2025-04-28 08:25:06', '2025-04-28 08:25:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int DEFAULT NULL,
  `puslit` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `level`, `puslit`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(6, 'Super Admin', 'superadmin', '$2y$10$yxg2LzGjKJCNTq.R4JRh5eSMQxi/SJWCUVdsLfT93IgAfYBBsJ3Pi', 1, NULL, '2025-02-26 03:24:53', 1, '2025-04-22 09:10:44', 1),
(9, 'Admin PPKS', 'ppks', '$2y$10$J6ouqJvNLWfrulM69CfTJu2T1SunrzANwpuA.vQhqiNv5cA./OdNW', 2, 'PPKS', '2025-03-04 03:50:04', 1, '2025-03-13 11:36:00', 1),
(17, 'Admin PPK', 'ppk', '$2y$10$1NsBsr4wdT.Xf87LEEbX2OMTDdN2ZWxrelmfq./wLrTM.foo2/qGC', 2, 'PPK', '2025-03-04 03:52:31', 1, '2025-03-13 11:53:33', 1),
(18, 'Admin PPKKI', 'ppkki', '$2y$10$9PnNuzUzBgtouZHF0Itk8.E3aMV500b8Fnu41v/EurAxvZdaqxD8m', 2, 'PPKKI', '2025-03-04 03:53:05', 1, '2025-03-13 06:08:18', 1),
(19, 'Admin P3GI', 'p3gi', '$2y$10$/bHlVY2pFSq0YP/YRWl/k.0kAGx8FF5TN/foEx3hiRlJMHEo89vA6', 2, 'P3GI', '2025-03-04 03:58:59', 1, '2025-03-13 11:54:04', 1),
(21, 'Admin PPTK', 'pptk', '$2y$10$4TQsuRZHfnO95g1USrbUzeIfeKt6iPY6WVG8yzhcjpxyCE7g0jypG', 2, 'PPTK', '2025-03-04 03:50:04', 1, '2025-03-13 11:54:22', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `detail_pelatihan`
--
ALTER TABLE `detail_pelatihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelatihan` (`id_pelatihan`),
  ADD KEY `pemateri` (`pemateri`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detail_pelatihan` (`id_detail_pelatihan`);

--
-- Indexes for table `hasil_test`
--
ALTER TABLE `hasil_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_set_soal` (`id_set_soal`),
  ADD KEY `diverifikasi_oleh` (`diverifikasi_oleh`);

--
-- Indexes for table `instruktur`
--
ALTER TABLE `instruktur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_set_soal` (`id_set_soal`),
  ADD KEY `id_soal` (`id_soal`),
  ADD KEY `id_pilihan_jawaban` (`id_pilihan_jawaban`);

--
-- Indexes for table `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detail_pelatihan` (`id_detail_pelatihan`);

--
-- Indexes for table `pilihan_jawaban`
--
ALTER TABLE `pilihan_jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indexes for table `set_soal`
--
ALTER TABLE `set_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detail_pelatihan` (`id_detail_pelatihan`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `set_soal_items`
--
ALTER TABLE `set_soal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_set_soal` (`id_set_soal`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_soal`
--
ALTER TABLE `bank_soal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detail_pelatihan`
--
ALTER TABLE `detail_pelatihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hasil_test`
--
ALTER TABLE `hasil_test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instruktur`
--
ALTER TABLE `instruktur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pilihan_jawaban`
--
ALTER TABLE `pilihan_jawaban`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `set_soal`
--
ALTER TABLE `set_soal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `set_soal_items`
--
ALTER TABLE `set_soal_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD CONSTRAINT `bank_soal_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bank_soal_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hasil_test`
--
ALTER TABLE `hasil_test`
  ADD CONSTRAINT `hasil_test_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_test_ibfk_2` FOREIGN KEY (`id_set_soal`) REFERENCES `set_soal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_test_ibfk_3` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  ADD CONSTRAINT `jawaban_peserta_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_peserta_ibfk_2` FOREIGN KEY (`id_set_soal`) REFERENCES `set_soal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_peserta_ibfk_3` FOREIGN KEY (`id_soal`) REFERENCES `bank_soal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_peserta_ibfk_4` FOREIGN KEY (`id_pilihan_jawaban`) REFERENCES `pilihan_jawaban` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `id_pelatihan_detail` FOREIGN KEY (`id_detail_pelatihan`) REFERENCES `detail_pelatihan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pilihan_jawaban`
--
ALTER TABLE `pilihan_jawaban`
  ADD CONSTRAINT `pilihan_jawaban_ibfk_1` FOREIGN KEY (`id_soal`) REFERENCES `bank_soal` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `set_soal`
--
ALTER TABLE `set_soal`
  ADD CONSTRAINT `set_soal_ibfk_1` FOREIGN KEY (`id_detail_pelatihan`) REFERENCES `detail_pelatihan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `set_soal_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `set_soal_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `set_soal_items`
--
ALTER TABLE `set_soal_items`
  ADD CONSTRAINT `set_soal_items_ibfk_1` FOREIGN KEY (`id_set_soal`) REFERENCES `set_soal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `set_soal_items_ibfk_2` FOREIGN KEY (`id_soal`) REFERENCES `bank_soal` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
