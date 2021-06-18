-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2021 pada 13.00
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wadesktop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `create`
--

CREATE TABLE `create` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `quotes` text NOT NULL,
  `description` text NOT NULL,
  `isi` text NOT NULL,
  `creator` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `create`
--

INSERT INTO `create` (`id`, `name`, `slug`, `kategori`, `quotes`, `description`, `isi`, `creator`, `date`, `status`) VALUES
(28, 'I Am a Programmer', 'i-am-a-programmer.html', 'About me', '<strong>REMEMBER:</strong>&nbsp;Code teaches you how to face really big problems.', 'Hi, My name is Carollous Dachi. Im a programmer since 2015 ago. Since childhood I was raised from a well-off family and an educated family. So, since I was 10 years old I already had a computer that was connected to the internet.', 'Since childhood I was raised from a well-off family and an educated family. So, since I was 10 years old I already had a computer that was connected to the internet. I learned a lot of things, but theSince childhood I was raised from a well-off family and an educated family. So, since I\r\n\r\nYes, of course there are many victims I have hacked. Yes, increasing age. Begin building a sense of fondness with computers and technology to the point of choosing lectures. Long story short, now I have worked as a programmer at Bina Bakti. Hopefully in the future, I can become a better programmer.', 'carollousdc', '2020-08-02 21:53:12', 0),
(30, 'Ngoding Capek Gak Sih ?', 'ngoding-capek-gak-sih.html', 'Story', 'Kalau seseorang tidak merasakan capek, berarti dia sedang tidak memperjuangkan apapun di hidupnya.', 'Kalau seseorang tidak merasakan capek, berarti dia sedang tidak memperjuangkan apapun di hidupnya.', '<div class=\"content-wrap content-660 center-relative \">\r\n                    <p class=\"wrap-blockquote\">Halo teman-teman, senang sekali bisa bercerita dengan kalian semua. Pembahasan kali ini,&nbsp;ngoding capek gak sih ?&nbsp;Ngapain sih milih kerja yang ribet-ribet. Toh digaji sebatas karyawan.&nbsp;Ya, memang betul. Makanya gak sedikit orang yang awalnya memilih pekerjaan.&nbsp;</p>\r\n                    <br>\r\n                    <blockquote class=\"inline-blockquote\">\r\n                        <p>Kalau seseorang tidak merasakan capek, berarti dia sedang tidak memperjuangkan apapun di hidupnya.</p>\r\n                    </blockquote>\r\n<p class=\"wrap-blockquote\">IT pindah menjadi seorang pembisnis atau pekerjaan lainnya yang tidak berhubungan dengan IT. Sebenarnya, ngoding itu sangat menyenangkan. Karena, disitulah kita menuangkan semua karya dan imajinasi kita ke dalam suatu program. Tidak cukup sampai disitu, Anda dapat membangun sebuah sistem seperti apa yang Anda mau. Teknologi itu luas, emang bisa mengejarnya? Tentu saja jawabannya tidak. Tapi, Anda bisa mengikutinya. Jika, Anda komitmen belajar dalam waktu satu tahun. Bayangkan Anda sudah berada di level mana ? Jika 5 tahun atau bahkan 10 tahun kemudian ? Bisa jadi Anda telah mengubah dunia dan berdampak positif bagi dunia.</p>\r\n                </div>', 'carollousdc', '2020-08-11 00:01:36', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dashboard`
--

CREATE TABLE `dashboard` (
  `id` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `apikey` varchar(100) NOT NULL,
  `whatsapp` varchar(30) NOT NULL,
  `location` text NOT NULL,
  `instagram` varchar(150) NOT NULL,
  `facebook` varchar(150) NOT NULL,
  `youtube` varchar(150) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dashboard`
--

INSERT INTO `dashboard` (`id`, `name`, `short_name`, `email`, `apikey`, `whatsapp`, `location`, `instagram`, `facebook`, `youtube`, `logo`, `status`, `create_date`, `creator`) VALUES
('BB1', 'Whatsapp API', 'Engine', '-', 'JISXZU0Y1GTTMIMMLMR0', '6282166230778', 'Jl. Karo No. 20 Belawan', '', '', '', 'whatsapp_api.png', 0, '2021-06-14 10:08:21', 'carollousdc');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kirim`
--

CREATE TABLE `kirim` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `kontak` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kirim`
--

INSERT INTO `kirim` (`id`, `name`, `kontak`, `create_date`, `creator`, `status`) VALUES
(36, 'tes', '7', '2021-04-16 20:24:46', '', 0),
(37, 'hgfffjfv gfhg hg rt rufyt jfvgj s vhgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj shgfffjfv gfhg hg rt rufyt jfvgj s', '12', '2021-04-17 18:44:02', '', 0),
(38, 'Gik Beli rokok napa genk ? Kalau bisa minuman dingin.', '12', '2021-04-17 19:09:13', '', 0),
(39, 'Brenk tolong belikan dlu wanita satu yang sexy.', '12', '2021-04-17 19:33:56', '', 0),
(40, 'Sak gimana cerita, aku tadi keluar.', '7', '2021-04-17 19:34:15', '', 0),
(43, 'CB5x7. CBx4.9. 5544.9.544.2.51.10.451.5', '16', '2021-04-24 23:39:32', '', 0),
(44, 'Tes', '18', '2021-04-25 04:14:13', '', 0),
(45, 'Lagi apa cs ?', '17', '2021-04-26 18:46:57', '', 0),
(46, 'sdasd', '18', '2021-05-03 01:17:03', '', 0),
(47, 'http://34cc9704288a.ngrok.io/', '18', '2021-05-03 01:17:59', '', 0),
(48, 'http://34cc9704288a.ngrok.io/', '3', '2021-05-03 01:18:33', '', 0),
(49, 'Coba kirim pesan togel genk.', '20', '2021-05-15 08:58:07', '', 0),
(50, 'tesss', '15', '2021-05-27 01:46:02', '', 0),
(51, 'oke pi :)', '8', '2021-06-05 17:15:03', '', 0),
(52, 'Pi, coba kirimkan pesan whatsapp apapun disini.', '8', '2021-06-06 12:13:54', '', 0),
(53, 'Oke pi, sebelum berangkat ya pi. Tolong digantiin ya pi. Aku gak ada uang pi. Baru beli hp. Taulah, hp aku gak murah harganya pi. ', '8', '2021-06-07 12:58:09', '', 0),
(54, 'Pi, coba kirimkan foto papi lagi di tempat tidur pasien. Ntar aku kirim ke bang ijal fotonya, cuma ntar sakitnya aku bilang yng lain.', '8', '2021-06-10 11:58:27', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `persen2a` int(11) NOT NULL,
  `persen3a` int(11) NOT NULL,
  `persen4a` int(11) NOT NULL,
  `hd2a` int(11) NOT NULL,
  `hd3a` int(11) NOT NULL,
  `hd4a` int(11) NOT NULL,
  `hd_a2` varchar(10) NOT NULL,
  `hd_a3` varchar(10) NOT NULL,
  `hd_a4` varchar(10) NOT NULL,
  `h2_s2` varchar(10) NOT NULL,
  `h2_s3` varchar(10) NOT NULL,
  `persencb` varchar(10) NOT NULL,
  `hdcb1` varchar(10) NOT NULL,
  `hdcb2` varchar(10) NOT NULL,
  `hdcb3` varchar(10) NOT NULL,
  `hdcb4` varchar(10) NOT NULL,
  `persencp` varchar(10) NOT NULL,
  `hdcp1` varchar(10) NOT NULL,
  `hdcp2` varchar(10) NOT NULL,
  `hdcp3` varchar(10) NOT NULL,
  `persencn` varchar(10) NOT NULL,
  `hdcn1` varchar(10) NOT NULL,
  `hdcn2` varchar(10) NOT NULL,
  `persenck` varchar(10) NOT NULL,
  `hdck` varchar(10) NOT NULL,
  `persence` varchar(10) NOT NULL,
  `hdce` varchar(10) NOT NULL,
  `persensh` varchar(10) NOT NULL,
  `hdsh` varchar(10) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id`, `name`, `phone`, `persen2a`, `persen3a`, `persen4a`, `hd2a`, `hd3a`, `hd4a`, `hd_a2`, `hd_a3`, `hd_a4`, `h2_s2`, `h2_s3`, `persencb`, `hdcb1`, `hdcb2`, `hdcb3`, `hdcb4`, `persencp`, `hdcp1`, `hdcp2`, `hdcp3`, `persencn`, `hdcn1`, `hdcn2`, `persenck`, `hdck`, `persence`, `hdce`, `persensh`, `hdsh`, `create_date`, `creator`, `status`) VALUES
(1, 'M Yoggi', '6288262881388', 12, 55, 0, 67, 45, 94, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-13 01:10:32', 'carollousdc', 0),
(2, 'Carollous Dachi', '6281377457800', 28, 28, 28, 70, 500, 5000, '213213', '123213', '32', '123', '23', '28', '2.5', '4', '5.5', '7', '0', '7', '10', '13', '0', '19', '19', '0', '8', '0', '8', '0', '0', '2021-04-25 18:38:58', 'carollousdc', 0),
(3, 'Yoga Pratama', '6289607864737', 64, 44, 0, 46, 76, 66, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-09 15:10:10', '', 0),
(7, 'Isak', '6281258642409', 2, 2, 2, 2, 2, 2, '2', '2', '232', '52', '56', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-16 20:24:21', 'carollousdc', 0),
(8, 'Dirga Putra Dachi', '6282161155300', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-16 22:31:21', 'carollousdc', 0),
(10, 'Heru Hardiansyah', '6288807728607', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-16 23:40:26', 'carollousdc', 0),
(13, 'Ibu Sri', '6289653739490', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-19 13:28:33', 'carollousdc', 0),
(14, 'Richan Hutabarat', '6281284097989', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '0', '2.5', '4', '5.5', '7', '0', '7', '10', '13', '', '', '', '', '', '', '', '', '', '2021-04-19 18:55:03', 'carollousdc', 0),
(15, 'Yoggi Simpati', '6282274376128', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '22', '22', '22', '22', '2', '0', '2', '2', '2', '0', '2', '22', '0', '8', '0', '5', '0', '0', '2021-04-19 19:04:57', 'carollousdc', 0),
(17, 'Roda Hafiz', '6281398172301', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-25 02:53:57', 'carollousdc', 0),
(18, 'Raditya', '6285156297323', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-04-25 06:54:34', 'carollousdc', 0),
(19, 'adas', 'd2312321321321', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-03 23:20:09', 'carollousdc', 0),
(20, 'Yoggi XL', '6282274376128', 28, 0, 28, 500, 0, 3000, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-15 08:57:40', 'carollousdc', 0),
(21, 'Olus', '6282297943451', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '0', '2.5', '4', '5.5', '7', '0', '7', '10', '13', '0', '20', '20', '9', '9', '9', '9', '0', '0', '2021-05-23 00:20:52', 'carollousdc', 0),
(22, 'Agus AM', '6282166230778', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-07 12:49:48', 'carollousdc', 0),
(23, 'MGS 2', '6282110919767', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-09 17:21:21', 'carollousdc', 0),
(24, 'Bang Fikri', '6282210576594', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-10 15:42:38', 'carollousdc', 0),
(25, 'Ressa AM', '6282267049828', 28, 28, 28, 70, 500, 3000, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-14 11:37:44', 'carollousdc', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `second_id` varchar(30) NOT NULL,
  `tipe` varchar(30) NOT NULL,
  `root` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `creator` varchar(30) NOT NULL,
  `create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `navigation`
--

INSERT INTO `navigation` (`id`, `name`, `link`, `second_id`, `tipe`, `root`, `urutan`, `icon`, `creator`, `create`, `status`) VALUES
(1, 'Master Menu', '', 'mastermenu', '0', 0, 1, 'nav-icon fas fa-tachometer-alt', 'carollousdc', '2021-01-28 06:21:34', 0),
(3, 'User', 'user', 'user', '1', 29, 3, 'far fa-circle nav-icon', 'carollousdc', '2021-01-28 06:21:34', 0),
(6, 'Settings', '', 'settings', '0', 0, 6, 'fas fa-cog nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(7, 'Menu Navigation', 'navigation', 'navigation', '1', 6, 7, 'far fa-circle nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(11, 'Laporan', 'laporan', 'documentation', '2', 0, 9, 'nav-icon fas fa-file', 'carollousdc', '2021-05-30 17:18:06', 0),
(12, 'Logout', 'logout', 'logout', '2', 0, 12, 'nav-icon fas fa-sign-out-alt', 'carollousdc', '2021-01-28 06:21:34', 0),
(29, 'Master SDM', '', 'mastersdm', '0', 0, 0, 'fas fa-users nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(43, 'Role', 'role', 'role', '1', 29, 0, 'far fa-circle nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(44, 'Permission', 'permission', 'permission', '1', 6, 0, 'far fa-circle nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(49, 'Pesan Masuk', 'pesan', 'pesan', '1', 1, 1, 'fas fa-envelope nav-icon', 'carollousdc', '2021-05-07 00:48:57', 0),
(50, 'Kirim', 'kirim', 'kirim', '1', 1, 4, 'nav-icon fas fa-share', 'carollousdc', '2021-05-06 12:08:16', 0),
(51, 'Kontak', 'kontak', 'kontak', '1', 29, 0, 'far fa-circle nav-icon', 'carollousdc', '2021-05-06 10:14:03', 0),
(52, 'Omset', 'omset', 'omset', '1', 1, 5, 'nav-icon fas fa-tag', 'carollousdc', '2021-05-06 12:11:58', 0),
(54, 'Kesimpulan', 'kesimpulan', 'kesimpulan', '1', 1, 7, 'nav-icon fas fa-star', 'carollousdc', '2021-05-30 17:30:31', 0),
(55, 'Result', 'result', 'result', '1', 1, 6, 'nav-icon fas fa-search', 'carollousdc', '2021-05-06 12:12:42', 0),
(56, 'Pesan Asli', 'pesan_asli', 'pesan_asli', '1', 1, 2, 'fas fa-envelope nav-icon', 'carollousdc', '2021-05-06 12:07:39', 0),
(57, 'Input', 'input', 'input', '1', 1, 3, 'nav-icon fas fa-share', 'carollousdc', '2021-05-06 12:08:08', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `omset`
--

CREATE TABLE `omset` (
  `id` varchar(30) NOT NULL,
  `keypesan` varchar(30) NOT NULL,
  `name` text NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `id_whatsapp` varchar(30) NOT NULL,
  `omset4d` varchar(10) NOT NULL,
  `omsetformat` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `omset`
--

INSERT INTO `omset` (`id`, `keypesan`, `name`, `kontak`, `id_whatsapp`, `omset4d`, `omsetformat`, `date`, `create_date`, `status`, `creator`) VALUES
('OM2021061400001', '628826288138800001', '1234BBSETx5x4x3 1234.233.412.343.1323.1234.234.34.15.234.34x7', '6288262881388', '6285765633475', '469', '0', '2021-06-14', '2021-06-14 11:05:03', 0, 'carollousdc');

-- --------------------------------------------------------

--
-- Struktur dari tabel `omset_detail`
--

CREATE TABLE `omset_detail` (
  `id` varchar(30) NOT NULL,
  `keypesan` varchar(30) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `angka` varchar(10) NOT NULL,
  `hasil` varchar(10) NOT NULL,
  `format` varchar(10) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `omset_detail`
--

INSERT INTO `omset_detail` (`id`, `keypesan`, `kontak`, `angka`, `hasil`, `format`, `status`, `create_date`, `creator`) VALUES
('OM2021061400001', '628826288138800001', '6288262881388', '1234', '7', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1323', '7', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1234', '7', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '233', '7', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '412', '7', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '343', '7', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '234', '7', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '234', '7', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '34', '7', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '15', '7', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '34', '7', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1234', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1243', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1324', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1342', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1423', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '1432', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2134', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2143', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2314', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2341', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2413', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '2431', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3124', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3142', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3214', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3241', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3412', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '3421', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4123', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4132', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4213', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4231', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4312', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '4321', '5', '4D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '123', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '124', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '132', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '134', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '142', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '143', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '213', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '214', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '231', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '234', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '241', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '243', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '312', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '314', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '321', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '324', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '341', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '342', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '412', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '413', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '421', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '423', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '431', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '432', '4', '3D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '12', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '13', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '14', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '21', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '23', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '24', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '31', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '32', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '34', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '41', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '42', '3', '2D', 0, '2021-06-14 11:05:03', 0),
('OM2021061400001', '628826288138800001', '6288262881388', '43', '3', '2D', 0, '2021-06-14 11:05:03', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permission`
--

INSERT INTO `permission` (`id`, `role`, `menu`, `action`, `status`, `create_date`, `creator`) VALUES
(1, 3, 16, 0, 0, '2021-02-03 14:02:57', ''),
(2, 3, 24, 0, 0, '2021-02-04 06:39:38', ''),
(3, 4, 40, 0, 0, '2021-02-04 06:40:42', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id` varchar(30) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `id_whatsapp` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `process_date` date NOT NULL,
  `m_status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id`, `kontak`, `id_whatsapp`, `name`, `process_date`, `m_status`, `create_date`, `creator`, `status`) VALUES
('628216623077800001', '6282166230778', '6285762206349', 'Emang iya bg', '2021-06-14', 0, '2021-06-14 11:36:18', 'carollousdc', 0),
('628226704982800001', '6282267049828', '6285762206349', 'Klo naek ojek kurang uang nya bng', '2021-06-14', 0, '2021-06-14 11:32:00', 'carollousdc', 0),
('628579441833300001', '6285794418333', '6285762206349', 'aku lagi sakit .. dari kemaren demam, batuk, pilek ..', '2021-06-14', 0, '2021-06-14 12:08:36', 'carollousdc', 0),
('628826288138800001', '6288262881388', '6285765633475', '1234BBSETx5x4x3 1234.233.412.343.1323.1234.234.34.15.234.34x7', '2021-06-14', 1, '2021-06-14 11:05:03', 'carollousdc', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_detail`
--

CREATE TABLE `pesan_detail` (
  `id` varchar(30) NOT NULL,
  `name` text NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `m_status` int(11) NOT NULL,
  `creator` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesan_detail`
--

INSERT INTO `pesan_detail` (`id`, `name`, `kontak`, `create_date`, `m_status`, `creator`, `status`) VALUES
('628826288138800001', '1234BBSETx5x4x3 1234.233.412.343.1323.1234.234.34.15.234.34x7', '6288262881388', '2021-06-14 11:05:03', 1, '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `result`
--

CREATE TABLE `result` (
  `id` varchar(30) NOT NULL,
  `name` varchar(10) NOT NULL,
  `id_whatsapp` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `result_detail`
--

CREATE TABLE `result_detail` (
  `id` varchar(30) NOT NULL,
  `keypesan` varchar(30) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `angka` varchar(10) NOT NULL,
  `hasil` varchar(10) NOT NULL,
  `format` varchar(10) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `name`, `keterangan`, `status`, `create_date`, `creator`) VALUES
(1, 'Admin', 'Full access control dashboard.', 0, '2021-02-03 14:02:42', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe`
--

CREATE TABLE `tipe` (
  `id` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fieldname` varchar(50) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tipe`
--

INSERT INTO `tipe` (`id`, `name`, `fieldname`, `role`, `status`, `create_date`, `creator`) VALUES
('Tip00001', 'Fixed Cost', 'tipe', 'pengeluaran', 0, '2021-01-28 05:26:00', ''),
('Tip00002', 'Cooker', 'jabatan', 'karyawan', 0, '2021-01-28 05:27:02', ''),
('Tip00003', 'Cashier', 'jabatan', 'karyawan', 0, '2021-01-28 05:27:11', ''),
('Tip00004', 'Cleaning Service', 'jabatan', 'karyawan', 0, '2021-01-28 05:27:31', ''),
('Tip00005', 'Master Menu', 'tipe', 'navigation', 0, '2021-01-28 06:16:26', ''),
('Tip00006', 'Root', 'tipe', 'navigation', 0, '2021-01-28 06:16:33', ''),
('Tip00007', 'Single', 'tipe', 'navigation', 0, '2021-01-28 06:16:38', ''),
('Tip00008', 'Operational Cost', 'tipe', 'pengeluaran', 0, '2021-01-28 13:30:42', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` varchar(25) NOT NULL,
  `id_whatsapp` varchar(30) NOT NULL,
  `email` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `gender` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `creator` varchar(30) NOT NULL,
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `id_whatsapp`, `email`, `firstname`, `lastname`, `gender`, `password`, `role`, `notification`, `picture`, `creator`, `last_login`, `is_active`, `status`) VALUES
('carollousdc', '6285765633475', 'carollousdc@gmail.com', 'Carollous', 'Dachi', 0, '$2y$09$TZoHGO4c3WjjtQbYGGolM.CcgAfQJCkFHDQ556GCF0IwOpx5U8206', 1, 0, 'download.png', 'carollousdc', '2021-05-30 16:26:06', 1, 0),
('opyoga', '6281377457800', 'opyogga@wa.app', 'OP', 'Yogga', 0, '$2y$09$1nn85PZRz.Yj5rQp.3pDuOYyKDXrfYXOwEG/iQ/CogoGnB3dQ53Ri', 1, 0, 'download.png', 'carollousdc', '2021-05-15 08:37:51', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `create`
--
ALTER TABLE `create`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kirim`
--
ALTER TABLE `kirim`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `omset`
--
ALTER TABLE `omset`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `create`
--
ALTER TABLE `create`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `kirim`
--
ALTER TABLE `kirim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
