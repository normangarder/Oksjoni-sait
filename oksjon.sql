-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Aprill 12, 2020 kell 10:33 PL
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
  `startingbid` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Kärbi tabelit enne lisamist `auction`
--

TRUNCATE TABLE `auction`;
--
-- Andmete tõmmistamine tabelile `auction`
--

INSERT INTO `auction` (`id`, `user_id`, `title`, `description`, `startingbid`) VALUES
(1, NULL, 'Wooden hut', 'In Tallinn City center', '1000'),
(2, 1, 'it kolledz', 'mustamje', '10'),
(3, NULL, 'patarei vangla', 'ajalooline kompleks', '100000'),
(4, NULL, 'patarei vangla', 'ajalooline kompleks', '100000'),
(5, 1, 'kaks raadiot', 'tegelt on kolm raadiot', '2'),
(6, 1, 'kaks raadiot', 'tegelt on kolm raadiot', '3'),
(7, 1, 'kaks raadiot', 'tegelt on kolm raadiot', '3'),
(8, 1, 'asdf', 'asdf', '123'),
(9, 1, 'asdf', 'asdf', '123'),
(10, 1, 'asdf', 'asdf', '123'),
(11, 1, 'asdf', 'asdf', '123'),
(12, 1, 'm6mm', '1234', '9999');

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

--
-- Kärbi tabelit enne lisamist `bid`
--

TRUNCATE TABLE `bid`;
--
-- Andmete tõmmistamine tabelile `bid`
--

INSERT INTO `bid` (`id`, `auction_id`, `user_id`, `bid`) VALUES
(1, 1, 1, '1000');

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
-- Kärbi tabelit enne lisamist `users`
--

TRUNCATE TABLE `users`;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT tabelile `bid`
--
ALTER TABLE `bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
