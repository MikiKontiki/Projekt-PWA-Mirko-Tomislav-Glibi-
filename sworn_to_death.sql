-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 05:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sworn_to_death`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Admin', 'Administrator', 'admin', '$2y$10$eJ..IDbFuCdlzf3DnDM7Q.KXtONjR93a.trz4RJO5IBjph6gXqZy2', 1),
(2, 'Korisnik', 'User', 'user', '$2y$10$OqO5KSE2ud3utVz95SS3pO5GwYDkULmzURfTOziQbzRMOlzOu0Aki', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(64) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '28.11.2025.', 'Pillars of Morality / Ruins of a Mind je izašao!', 'Najnoviji album možete slušati na svim platformama za muziku.', 'Zagrebački groove metal bend Sworn to Death objavio je drugi album \"Pillars of Morality / Ruins of a Mind\". Album je priča o mentalnoj dekadenciji u šest poglavlja.', 'slika1.jpg', 'Novosti / Album', 0),
(2, '15.11.2025.', 'Abaddon - drugi single je live!', 'Drugi single s sljedećeg albuma je sada dostupan na svim platformama.', 'Praise the doom that He will bring. Ashes scattered when no angels sing. A seal of God on one\'s chest. Protected the ones who wore it.', 'slika2.jpg', 'Novosti / Singl', 0),
(3, '01.11.2025.', 'Live by the Sword - prvi singl', 'Prvi singl s albuma je sada dostupan na svim platformama.', 'We don\'t give a fuck. STD will fuck you up. I have become idiosyncratic, flegmatic, completely lost in the static.', 'slika3.jpg', 'Novosti / Singl', 0),
(4, '20.10.2025.', 'Koncert u Zagrebu', 'Sworn to Death nastupa u Močvari 15.12.2025.', 'Dođite na koncert Sworn to Death u Močvari 15.12.2025. Ulaznice su u prodaji.', 'koncert.jpg', 'Koncerti / Koncert', 0),
(12, '21.06.2026.', 'Vijest', 'Kratak sažetak', 'Duži tekstualni dio', 'IMG_7430.JPG', 'Novosti / Album', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
