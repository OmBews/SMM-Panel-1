-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2021 pada 10.27
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smmpanel_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `balance_history`
--

CREATE TABLE `balance_history` (
  `username` varchar(50) NOT NULL,
  `action` enum('Add Balance','Cut Balance') NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `msg` text NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `balance_history`
--

INSERT INTO `balance_history` (`username`, `action`, `quantity`, `price`, `msg`, `date`, `time`) VALUES
('demo', 'Add Balance', 2222, 2222, 'Telah menerima Saldo senilai 2222 dari pengguna Daeng_nass', '2019-01-20', '02:21:04'),
('demo', 'Add Balance', 22, 22, 'Telah menerima Saldo senilai 22 dari pengguna Daeng_nass', '2019-01-20', '02:22:53'),
('demo', 'Add Balance', 22222, 22222, 'Telah menerima Saldo senilai 22222 dari pengguna Daeng_nass', '2019-01-20', '02:43:14'),
('Daeng_nass', 'Cut Balance', 1111, 1111.1, 'Telah Melakukan Pembelian LIKES ASING Senilai Rp.1111.1-,', '2019-01-20', '02:56:00'),
('ruby', 'Cut Balance', 1111, 1111.1, 'Telah Melakukan Pembelian LIKES ASING Senilai Rp.1111.1-,', '2019-01-20', '23:21:56'),
('ruby', 'Cut Balance', 1133, 1133.322, 'Telah Melakukan Pembelian LIKES ASING Senilai Rp.1133.322-,', '2019-01-20', '23:29:45'),
('ruby', 'Cut Balance', 1133, 1133.322, 'Telah Melakukan Pembelian LIKES ASING Senilai Rp.1133.322-,', '2019-01-20', '23:34:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposits_history`
--

CREATE TABLE `deposits_history` (
  `id` int(10) NOT NULL,
  `user` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `quantity` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `pengirim` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `get_balance` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `link_confirm` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `method` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `time` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `status` enum('Pending','Processing','Error','Success') COLLATE utf8_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposits_method`
--

CREATE TABLE `deposits_method` (
  `id` int(10) NOT NULL,
  `tipe` enum('Bank','Pulsa') COLLATE utf8_swedish_ci NOT NULL,
  `method` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `rate` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `note` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `deposits_method`
--

INSERT INTO `deposits_method` (`id`, `tipe`, `method`, `rate`, `note`) VALUES
(3, 'Pulsa', 'Tsel-1', '0.80', '085264520165'),
(542, 'Bank', 'BRI', '1.0', '754201004833531'),
(2, 'Pulsa', 'BANK BRI', '1.0', 'BRI 551001005723534');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_topup`
--

CREATE TABLE `history_topup` (
  `id` int(11) NOT NULL,
  `provider` enum('XL','TSEL') CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `jumlah_transfer` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `no_pengirim` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('NO','YES','CANCEL') CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `type` enum('WEB','API','REG') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `history_topup`
--

INSERT INTO `history_topup` (`id`, `provider`, `amount`, `jumlah_transfer`, `username`, `no_pengirim`, `date`, `time`, `status`, `type`) VALUES
(320, 'TSEL', '10000', '10000', 'andinas', '6282198473982', '2018-10-05', '11:50:41', 'YES', 'WEB'),
(314, 'TSEL', '5000', '5000', 'DEVELOVER', '62884848888', '2018-10-04', '21:38:37', 'NO', 'WEB'),
(324, 'TSEL', '40000', '40000', 'Crew1', '6282113994217', '2018-10-06', '22:41:21', 'YES', 'WEB'),
(322, 'TSEL', '8643894', '8643894', 'demo', '6282938283929293', '2018-10-06', '20:48:00', 'NO', 'WEB'),
(323, 'TSEL', '10000', '10000', 'Crew1', '6282113994217', '2018-10-06', '21:32:59', 'YES', 'WEB'),
(326, 'TSEL', '30000', '30000', 'Crew1', '6282113994217', '2018-10-07', '08:36:51', 'YES', 'WEB'),
(331, 'TSEL', '30000', '30000', 'Diditagen', '6282120017213', '2018-10-27', '20:31:12', 'NO', 'WEB');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invitecode`
--

CREATE TABLE `invitecode` (
  `id` int(100) DEFAULT NULL,
  `code` int(50) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invitecode`
--

INSERT INTO `invitecode` (`id`, `code`, `jumlah`, `status`) VALUES
(3189863, 0, 1, 0),
(2264115, 0, 1, 0),
(938879, 0, 1, 0),
(9252505, 0, 1, 0),
(780426, 0, 1, 0),
(2045987, 0, 1, 0),
(2489680, 0, 1, 0),
(8298200, 0, 1, 0),
(6863188, 0, 1, 0),
(7393783, 0, 1, 0),
(2431933, 0, 1, 0),
(3246523, 0, 1, 0),
(9865610, 0, 1, 0),
(8830498, 0, 1, 0),
(2974043, 0, 1, 0),
(3145734, 0, 1, 0),
(4638706, 0, 1, 0),
(2859884, 0, 1, 0),
(8501189, 0, 1, 0),
(2597552, 0, 1, 0),
(5566307, 0, 1, 0),
(8946122, 0, 1, 0),
(6157300, 0, 1, 0),
(9721169, 0, 1, 0),
(8025106, 0, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `content` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `date`, `content`) VALUES
(10, '2021-11-21', 'Followers fast hari ini ; instagram followers-27\r\nTop up via pulsa no rate !'),
(11, '2021-11-21', 'Founder & ceo hanya \r\n1. Dimas Arya Pamungkas\r\nTop up manual bisa hubungi kami lewat ticket suport atau facebook :D'),
(12, '2021-11-21', 'FITUR PULSA AKAN SEGERA AKTIF GUYS ðŸ˜‹ Rajin top up akan dapat bonus mingguan mulai 50k sampai 300k loh'),
(13, '2021-11-21', 'Fitur pulsa sudah fix 100% dan harga sangat murah :D dan sudah bisa transaksi\r\nVia api ya guys \r\nTop up via pulsa no rate\r\nTop up via bank bonus 5%');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `oid` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `poid` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `service` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `link` text COLLATE utf8_swedish_ci NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `status` enum('Pending','Processing','Error','Partial','Success','Completed','Canceled') COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `provider` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `place_from` enum('WEB','API') COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_history`
--

CREATE TABLE `order_history` (
  `id` int(10) NOT NULL,
  `order_id` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `poid` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `provider` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `buyer` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `service` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `link` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `quantity` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `price` int(10) NOT NULL,
  `startcount` int(10) NOT NULL,
  `remains` int(10) NOT NULL,
  `status` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `status_refund` enum('NO','YES') COLLATE utf8_swedish_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `time` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `provider`
--

CREATE TABLE `provider` (
  `id` int(10) NOT NULL,
  `code` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `link` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `api_key` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `api_id` varchar(100) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `provider`
--

INSERT INTO `provider` (`id`, `code`, `link`, `api_key`, `api_id`) VALUES
(1, 'IRVAN', 'https://irvankede-smm.co.id/api/', '00c4b2-0976e9-20d1e4-1181f2-f1c642', '6811'),
(2, 'JAP', 'https://www.vip-sosmed.com/api/api.php', 'dou5a7WIENGnTFBSYZgLyiHeMzh9c8', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provider_pulsa`
--

CREATE TABLE `provider_pulsa` (
  `id` int(11) NOT NULL,
  `code` varchar(225) NOT NULL,
  `link` varchar(225) NOT NULL,
  `api_key` varchar(225) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `provider_pulsa`
--

INSERT INTO `provider_pulsa` (`id`, `code`, `link`, `api_key`) VALUES
(1, 'ATL', 'https://api.atlantic-pedia.co.id/order/pulsa', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `refferal`
--

CREATE TABLE `refferal` (
  `id` int(10) NOT NULL,
  `username` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `kode` varchar(100) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `refferal`
--

INSERT INTO `refferal` (`id`, `username`, `kode`) VALUES
(1, 'admin', 'Q4P4sru2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `category` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `service` text COLLATE utf8_swedish_ci NOT NULL,
  `note` text COLLATE utf8_swedish_ci NOT NULL,
  `min` int(10) NOT NULL,
  `max` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `status` enum('Active','Not active') COLLATE utf8_swedish_ci NOT NULL,
  `pid` int(10) NOT NULL,
  `provider` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `refund` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `sid`, `category`, `service`, `note`, `min`, `max`, `price`, `status`, `pid`, `provider`, `refund`) VALUES
(2, 2, 'Instagram Likes IRV', 'Instagram Likes - [ NEW ] [ Superfast ] [ Real ] [ Max -5k ] INSTANT', 'Best & Cheapest Service!\r\nReal\r\nSuper Instant Delivery!\r\nMinimum 50', 5, 2000, 42150, 'Not active', 1425, 'IRVAN', 1),
(560, 3, 'Instagram Likes IRV', 'TEST', 'TEST', 5, 2000, 42150, 'Not active', 1425, 'IRVAN', 1),
(1309, 1, 'Instagram Followers Indonesia IRV', 'Instagram Followers Indonesia NEW 1 [9K] [ORDER VIA API RP 35K]', 'REAL INDO , INPUT USERNAME ONLY JANGAN PAKE LINK , PROSES 0-10 JAM', 5, 2000, 42150, 'Not active', 1313, 'IRVAN', 1),
(2224, 5, 'Instagram Likes IRV', 'LIKES ASING', 'LINK AJA', 50, 100, 100, 'Active', 1426, 'IRVAN', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_cat`
--

CREATE TABLE `service_cat` (
  `id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `service_cat`
--

INSERT INTO `service_cat` (`id`, `name`, `code`) VALUES
(1, 'Instagram Followers Indonesia IRV', 'Instagram Followers Indonesia IRV'),
(2, 'Instagram Likes', 'Instagram Likes IRV');

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `level` enum('Admin','Reseller') COLLATE utf8_swedish_ci NOT NULL,
  `pict` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) NOT NULL,
  `user` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `message` text COLLATE utf8_swedish_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `status` enum('Pending','Responded','Closed','Waiting') COLLATE utf8_swedish_ci NOT NULL,
  `seen_user` int(1) NOT NULL DEFAULT 1,
  `seen_admin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tickets_message`
--

CREATE TABLE `tickets_message` (
  `id` int(10) NOT NULL,
  `ticket_id` int(10) NOT NULL,
  `sender` enum('Member','Admin') COLLATE utf8_swedish_ci NOT NULL,
  `user` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `message` text COLLATE utf8_swedish_ci NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `topup`
--

CREATE TABLE `topup` (
  `id` int(11) NOT NULL,
  `method` enum('Telkomsel','BCA') NOT NULL,
  `username` varchar(200) NOT NULL,
  `pengirim` varchar(200) NOT NULL,
  `jumlah` varchar(200) NOT NULL,
  `status` enum('Waiting','Completed','Canceled') NOT NULL,
  `time` varchar(200) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transfer_balance`
--

CREATE TABLE `transfer_balance` (
  `id` int(10) NOT NULL,
  `sender` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `receiver` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `quantity` double NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `balance` double NOT NULL,
  `level` enum('Member','Agen','Reseller','Admin','Developers') COLLATE utf8_swedish_ci NOT NULL,
  `registered` date NOT NULL,
  `status` enum('Active','Suspended') COLLATE utf8_swedish_ci NOT NULL,
  `api_key` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `uplink` varchar(100) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `balance`, `level`, `registered`, `status`, `api_key`, `uplink`) VALUES
(3, 'jca', 'jca', 20000, 'Member', '0000-00-00', 'Active', '', ''),
(2234, 'dimas', 'admin123', 29389.100000000006, 'Admin', '2021-11-21', 'Active', 'khjktNWmp742qAK3EqoY', 'free_register'),
(2235, 'andinas', 'merdeka17', 305.5, 'Member', '2021-11-21', 'Active', '16EgkwuTDNKm2LKUqcCt', 'free_register'),
(2236, 'Viloid', 'haha1234', 0, 'Member', '2021-11-21', 'Active', '0EtP7BYwlPe4Jpe5I7gs', 'free_register'),
(2237, 'demoo', 'demoo', 0, 'Member', '2021-11-21', 'Active', '2HZ3kLhjAsZqjVx8Ngr7', 'free_register');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `deposits_history`
--
ALTER TABLE `deposits_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deposits_method`
--
ALTER TABLE `deposits_method`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `history_topup`
--
ALTER TABLE `history_topup`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeks untuk tabel `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `provider_pulsa`
--
ALTER TABLE `provider_pulsa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `refferal`
--
ALTER TABLE `refferal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_cat`
--
ALTER TABLE `service_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tickets_message`
--
ALTER TABLE `tickets_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indeks untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transfer_balance`
--
ALTER TABLE `transfer_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `deposits_history`
--
ALTER TABLE `deposits_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=660;

--
-- AUTO_INCREMENT untuk tabel `deposits_method`
--
ALTER TABLE `deposits_method`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=543;

--
-- AUTO_INCREMENT untuk tabel `history_topup`
--
ALTER TABLE `history_topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT untuk tabel `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `provider_pulsa`
--
ALTER TABLE `provider_pulsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `refferal`
--
ALTER TABLE `refferal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2225;

--
-- AUTO_INCREMENT untuk tabel `service_cat`
--
ALTER TABLE `service_cat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tickets_message`
--
ALTER TABLE `tickets_message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `topup`
--
ALTER TABLE `topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transfer_balance`
--
ALTER TABLE `transfer_balance`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2291;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
