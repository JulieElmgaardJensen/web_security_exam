-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 03. 06 2024 kl. 11:46:32
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company`
--

DELIMITER $$
--
-- Procedurer
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users` ()   SELECT * FROM users ORDER BY user_name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_by_user_id` (IN `the_user_id` BIGINT(20))   SELECT user_id, user_name FROM users WHERE user_id = the_user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login` (IN `the_users_email` VARCHAR(100) CHARSET utf8mb4)   SELECT user_password, user_id, user_name, user_email FROM users WHERE user_email = the_users_email$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_user_fk` bigint(20) UNSIGNED NOT NULL,
  `order_product_fk` bigint(20) UNSIGNED NOT NULL,
  `order_amount_paid` int(10) UNSIGNED NOT NULL,
  `order_ordered_at` char(10) NOT NULL,
  `order_delivered_at` char(10) NOT NULL,
  `order_delivered_by_fk` bigint(20) UNSIGNED NOT NULL,
  `order_comment` varchar(255) DEFAULT NULL,
  `order_is_private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `orders`
--

INSERT INTO `orders` (`order_id`, `order_user_fk`, `order_product_fk`, `order_amount_paid`, `order_ordered_at`, `order_delivered_at`, `order_delivered_by_fk`, `order_comment`, `order_is_private`) VALUES
(7, 48, 5, 150, '1704828940', '1704898217', 32, NULL, 0),
(14, 48, 2, 200, '1707238193', '', 32, NULL, 0),
(15, 45, 3, 150, '1707301588', '', 36, NULL, 0),
(16, 92, 5, 200, '1707321617', '1707321663', 36, NULL, 0),
(17, 92, 4, 150, '1707321617', '', 32, NULL, 0),
(18, 44, 2, 2000, '1707321969', '1707321969', 93, NULL, 0),
(19, 31, 3, 129, '1707321969', '', 93, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `partners`
--

CREATE TABLE `partners` (
  `user_partner_fk` bigint(20) UNSIGNED NOT NULL,
  `partner_geo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `partners`
--

INSERT INTO `partners` (`user_partner_fk`, `partner_geo`) VALUES
(32, '8.580253,107.938541'),
(36, ''),
(93, '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`) VALUES
(1, 'Pizza', 1000),
(2, 'Sushi', 2000),
(3, 'Burger', 500),
(4, 'Butter chicken', 1500),
(5, 'Lasagna', 3000),
(6, 'Fried rice', 750);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'partner'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Stand-in-struktur for visning `roles_partner_view`
-- (Se nedenfor for det aktuelle view)
--
CREATE TABLE `roles_partner_view` (
`user_id` bigint(20) unsigned
,`user_role` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in-struktur for visning `roles_user_view`
-- (Se nedenfor for det aktuelle view)
--
CREATE TABLE `roles_user_view` (
`user_id` bigint(20) unsigned
,`user_role` varchar(20)
);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_last_name` varchar(20) NOT NULL,
  `user_username` varchar(30) NOT NULL,
  `user_address` varchar(60) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_created_at` char(11) NOT NULL,
  `user_updated_at` char(11) NOT NULL,
  `user_deleted_at` char(11) NOT NULL,
  `user_is_blocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_last_name`, `user_username`, `user_address`, `user_email`, `user_password`, `user_role`, `user_created_at`, `user_updated_at`, `user_deleted_at`, `user_is_blocked`) VALUES
(31, 'Rahsaan', 'Greenfelder', 'everett.ullrich', '7128 Nicole Springs\nFerryport, NM 95808', 'ktorp@yahoo.com', '$2y$10$Su8vmOqIq3ajUCjDc2uBcu4xPxeSeesHg6RJ1751NtscOmGg726X6', 'user', '', '1701435188', '0', '0', 0),
(32, 'Gwen', 'Deckow', 'deon.daniel', '1265 Ferne Grove Apt. 222\nWatersside, GA 24049', 'kacie90@bailey.com', '$2y$10$6RaAOPC.vxv/rq94B51hRunmmt21AxEfMsGyi.iBuj6ARYlZP3B72', 'partner', '', '1701435188', '0', '0', 0),
(36, 'Enid', 'Feeney', 'lorine.nikolaus', '724 Hane Square\nZoeyfort, NY 22897', 'dion96@jacobi.net', '$2y$10$jv.3R3sCXgGw90nfRV0QCesKCGU5Q0qGHCBWV8kcI9dv3DA2e5vue', 'partner', '', '1701435189', '0', '0', 1),
(40, 'Reanna', 'Bauch', 'nigel.doyle', '6235 Brad Loaf Apt. 528\nNorth Sylvia, OR 63050-0088', 'wyatt.beier@gmail.com', '$2y$10$B.SU4JKmZTwsGqsfNYY40.q66uvkLXKTfsUSVyaHhLrzPmxWiGUp2', 'user', '', '1704379254', '0', '0', 1),
(41, 'Evie', 'Harvey', 'roger.nikolaus', '756 Streich Loop Suite 989\nWest Vern, WI 97509-0561', 'jan.dare@powlowski.org', '$2y$10$ye1vj2kYfGCUNuDRQgAYjO1z4QfmtUQfmuYv3OPaHONvDJGyQd9le', 'user', '', '1704379254', '0', '0', 1),
(42, 'Marcelina', 'Bartell', 'vebert', '68923 Bartoletti Mall Suite 488\nNew Lynn, VT 23261', 'cpacocha@gmail.com', '$2y$10$a4dSUUJ6vqiUBykwAuSQnuocJUrjLtyW09mvafRw69vkH8FWv4rLu', 'user', '', '1704379254', '0', '0', 0),
(44, 'Aisha', 'Sipes', 'gorczany.jazmyn', '2211 Marks Crescent\nSouth Aurelia, KS 08366-6279', 'zoie.brakus@hills.com', '$2y$10$0CwB/aoptiYdH3HCFLUK0.e1mzXMBD7BXFIomdwiybCDv.2.KTlqe', 'user', '', '1704379254', '0', '0', 0),
(45, 'Selmer', 'Waelchi', 'sblock', '717 Samir Street\nKovacekland, LA 42925-9977', 'mozelle11@altenwerth.net', '$2y$10$mm/MRgDvNfW/FJ8ayBsRb.6PQh/WhHCb/cv2BR89jflMOCBkDiMbS', 'user', '', '1704379255', '0', '0', 0),
(46, 'Phoebe', 'Schulist', 'tiana.sporer', '82287 Thiel Grove Suite 906\nEast Sunnytown, WY 22875', 'fiona75@hane.com', '$2y$10$5IQrwyR8mjpMo.7v4Pnb3OadU5l/NMXJBi.jBzlByKK1SYUIt1GQ2', 'user', '', '1704379255', '0', '0', 1),
(47, 'Kimberly', 'Hoppe', '', '421 Mittie Mountain Apt. 867\nPearlburgh, VA 92849', 'hellen.gusikowski@hotmail.com', '$2y$10$N.6/fNUlCwtXAba3XyuikOTyVoUeDhO/mgIT/nCxEMYQkWI2KcIJu', 'user', '', '1704379255', '0', '0', 0),
(48, 'Anabel', 'Rogahn', 'orie05', '3992 Welch Forks Apt. 694\nAbigayleport, WY 38784', 'dora.gutmann@gmail.com', '$2y$10$taDH3snUGFEczcB0c6HS1ORBnaLdFt11nr58.iRamqDEK/xmXV7eG', 'user', '', '1704379255', '0', '0', 0),
(61, 'Tobias', 'Lundberg', 'TT', 'hejvej 23', 'tobias@gmail.com', '$2y$10$aC55ax85Hrb7ANqt0880VO9lzutgLDmJ4TUW3Uf.dRvhLtyid8xNe', 'user', '', '1704988249', '0', '1704990029', 1),
(62, 'Julie', 'Andersen', 'julieandersen', 'vej 234', 'julieandersen@julie.com', '$2y$10$hh3W8s2E3N7oLuzLlTskGu9Bf6VDH0P5It/8gxy46Sn0uYkzu1Ry.', 'user', '', '1706545572', '0', '1706613660', 1),
(63, 'Berta', 'Jensen', 'bertajensen', 'vej 333', 'berta@email.com', '$2y$10$gx3Y0gsOlAcF9hii6VCjte7EPijdyN/lNMxiHmCeaIuwDH/xxCJhu', '', 'user', '1706562958', '0', '1706606236', 0),
(85, 'ffff', 'ffffffff', 'ff', 'dffff 23, 8', 'f@f.com', '$2y$10$HZNA1EogQ.jQnREEeAQAFuq2/uta6YhTmc0E2DEu5frluMEbuF7I.', 'user', '', '1707127073', '1707127159', '0', 1),
(87, 'user', 'userusere', 'useruseruser123', 'user 123', 'user@user.com', '$2y$10$mZXE/h7/6LFstPIKBiDIceOoSI33BsBzqCsJAKteKVavIg6zUyCP2', 'user', '', '1707158287', '1707159452', '0', 0),
(88, 'xx', 'XX', 'xxxxx', 'x 123', 'x@x.com', '$2y$10$IhrRXslanlwAm4W0n/AyBuToxuS4RARyU/cdnamBUH6XQTV9UCX4a', 'admin', '', '1707159931', '1707160165', '0', 0),
(89, 'Julie', 'Jensen', 'julie.jensen', 'jj 123', 'j@j.com', '$2y$10$NxYJ5KcMbHK5OX0lg3dzPu6saXyxCDOryxGuf3c2eWMZomeJyzjXK', 'user', '', '1707215405', '0', '0', 0),
(90, 'user', 'user', 'username', 'user 12', 'u@u.com', '$2y$10$hXiusZqYog5WNiLc1SwyJOnGu9YIFzdxZnppKAOfUwxKGsKFrevhy', 'user', '', '1707301764', '1707314396', '1707314516', 0),
(91, 'admin', 'admin', 'admin', 'a 123', 'a@a.com', '$2y$10$LZB05VTvKZFxUMbpcI39auLjeVRy7VvtU88WAMdb194W1fOeLSMXW', 'admin', '', '1707314619', '1707321201', '0', 0),
(92, 'user', 'useruser', 'useruser', 'u 123', 'user@u.com', '$2y$10$kf1SDQjekeI.u./QKbkP7..NB3kQU1zz.BH4.HRC02fAXmecDdYqW', 'user', '', '1707321494', '1707321692', '0', 0),
(93, 'partner', 'partner', 'partner', 'part 123', 'p@p.com', '$2y$10$SpVYzPMvKKedHKfHp2Fw6uASNCg2sgWK9D7aJJVn3NSDOjztl/Z56', 'partner', '', '1707321861', '1707323088', '0', 0);

-- --------------------------------------------------------

--
-- Struktur for visning `roles_partner_view`
--
DROP TABLE IF EXISTS `roles_partner_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `roles_partner_view`  AS SELECT `users`.`user_id` AS `user_id`, `users`.`user_role` AS `user_role` FROM `users` WHERE `users`.`user_role` = 'partner' ;

-- --------------------------------------------------------

--
-- Struktur for visning `roles_user_view`
--
DROP TABLE IF EXISTS `roles_user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `roles_user_view`  AS SELECT `users`.`user_id` AS `user_id`, `users`.`user_role` AS `user_role` FROM `users` WHERE `users`.`user_role` = 'user' ;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `orders_ibfk_2` (`order_product_fk`),
  ADD KEY `orders_ibfk_3` (`order_delivered_by_fk`),
  ADD KEY `orders_ibfk_4` (`order_user_fk`);

--
-- Indeks for tabel `partners`
--
ALTER TABLE `partners`
  ADD UNIQUE KEY `user_partner_fk` (`user_partner_fk`);

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_last_name` (`user_last_name`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`order_product_fk`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`order_delivered_by_fk`) REFERENCES `partners` (`user_partner_fk`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`user_partner_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
