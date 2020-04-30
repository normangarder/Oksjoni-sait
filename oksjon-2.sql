-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Aprill 30, 2020 kell 08:48 PL
-- Serveri versioon: 10.4.11-MariaDB
-- PHP versioon: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `oksjon`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `auction`
--

CREATE TABLE `auction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `startingbid` decimal(10,0) NOT NULL,
  `inserted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Andmete tõmmistamine tabelile `auction`
--

INSERT INTO `auction` (`id`, `user_id`, `title`, `description`, `startingbid`, `inserted`) VALUES
(35, 1, 'Monster', 'tegelt on kolm raadiot', '2000', '2020-04-27 22:37:28'),
(36, 1, 'kaks raadiot', 'tegelt on kolm raadiot', '300', '2020-04-29 03:49:28'),
(37, 1, 'kass', 'raisk', '1', '2020-04-30 01:37:28'),
(38, 1, 'asdf', 'ererere', '3', '2020-04-30 01:37:28'),
(41, 1, 'tere', 'asdf', '1111', '2020-04-30 01:37:28'),
(42, 1, 'tere', 'ererere', '111', '2020-04-30 01:37:28'),
(43, 1, 'kaks raadiot', 'asdf', '6666', '2020-04-30 01:37:28'),
(44, 1, 'lempsi v6im', 'perses', '5', '2020-04-30 03:24:41');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `bid`
--

CREATE TABLE `bid` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `img_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Andmete tõmmistamine tabelile `image`
--

INSERT INTO `image` (`id`, `auction_id`, `filename`, `img_order`) VALUES
(12, 35, 'uploads/1633098869983712NgU9cRML._AC_SL1080_.jpg', 0),
(13, 36, 'uploads/4871690022596180823-nasa-intern-loses-job-embed-1.jpg', 0),
(14, 37, 'uploads/773140075801Thinking-of-getting-a-cat.png', 0),
(15, 38, 'uploads/2258989258838sportland.png', 0),
(17, 41, 'uploads/3002641275758712NgU9cRML._AC_SL1080_.jpg', 0),
(18, 42, 'uploads/8524352237768712NgU9cRML._AC_SL1080_.jpg', 0),
(19, 43, 'uploads/3125947102979Thinking-of-getting-a-cat.png', 0),
(20, 44, 'uploads/4745004561925üheksa.png', 0);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Andmete tõmmistamine tabelile `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`) VALUES
(1, 'aaaaaa', 'nogard@ttu.ee', '59074971', '$2y$10$tarapacaAnsipMerkelKaeN/qOK/8OBuljoi/u2hyFqatDwy1Xsnq'),
(2, 'abc', 'abc@example.com', '56666666', '$2y$10$tarapacaAnsipMerkelKaepKzzNxInrcnLPK2XERqx8MiBpj67rGy'),
(3, 'juuser', 'juuser', '', '$2y$10$AQH3gTnzzq47aP4wvz8f7OzF.x/GpayB5PgLG0BLqMNj4LuRpKvse'),
(4, 'juuser2', 'juuser2', 'juuser', '$2y$10$ktl7yvDtj3ka181qJzsITOfSBbk2pW52K5JmZKrUfzK/7PZG7tgPK'),
(5, 'kolmas', 'ratas', '', '$2y$10$tarapacaAnsipMerkelKaeG1RU4Oxxk04OUiBnhD.vR11Igv/xE26'),
(6, 'a', 'a', '', '$2y$10$tarapacaAnsipMerkelKaeUqUB6OZnBg4Tse7te0/SbXmP0Ba3kmS');

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `user` (`user_id`);

--
-- Indeksid tabelile `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_id` (`auction_id`),
  ADD KEY `bid_ibfk_2` (`user_id`);

--
-- Indeksid tabelile `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_id` (`auction_id`);

--
-- Indeksid tabelile `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `auction`
--
ALTER TABLE `auction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT tabelile `bid`
--
ALTER TABLE `bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT tabelile `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT tabelile `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tõmmistatud tabelite piirangud
--

--
-- Piirangud tabelile `auction`
--
ALTER TABLE `auction`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Piirangud tabelile `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`auction_id`) REFERENCES `auction` (`id`),
  ADD CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Piirangud tabelile `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `auction_id` FOREIGN KEY (`auction_id`) REFERENCES `auction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
