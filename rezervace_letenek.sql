-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Sob 28. lis 2015, 10:36
-- Verze serveru: 5.5.46-0ubuntu0.14.04.2
-- Verze PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `rezervace_letenek`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `letenka`
--

CREATE TABLE IF NOT EXISTS `letenka` (
  `id_letenky` int(11) NOT NULL AUTO_INCREMENT,
  `odkud` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `destinace` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `pocet_mist` int(11) NOT NULL,
  `trida` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `datum_odletu` date NOT NULL,
  `cas_odletu` time NOT NULL,
  `cas_priletu` time NOT NULL,
  `spolecnost` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  PRIMARY KEY (`id_letenky`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `letenka`
--

INSERT INTO `letenka` (`id_letenky`, `odkud`, `destinace`, `pocet_mist`, `trida`, `datum_odletu`, `cas_odletu`, `cas_priletu`, `spolecnost`, `cena`) VALUES
(1, 'Praha', 'Barcelona', 150, 'economy', '2015-12-13', '19:00:00', '21:00:00', 'Lufthansa', 3600),
(2, 'Praha', 'Barcelona', 50, 'first', '2015-12-13', '19:00:00', '21:00:00', 'Lufthansa', 19241),
(3, 'Praha', 'London', 50, 'first', '2016-01-14', '16:00:00', '20:00:00', 'Lufthansa', 17515),
(4, 'Praha', 'London', 200, 'economy', '2016-01-14', '16:00:00', '20:00:00', 'Lufthansa', 3200),
(5, 'Praha', 'Tokyo', 200, 'economy', '2016-01-02', '08:00:00', '21:00:00', 'japair', 15000),
(6, 'Praha', 'Tokyo', 50, 'first', '2016-01-02', '08:00:00', '21:00:00', 'japair', 30000),
(7, 'Praha', 'NY', 200, 'economy', '2015-12-20', '12:00:00', '01:00:00', 'NYair', 13000),
(8, 'Praha', 'NY', 100, 'business', '2015-12-20', '12:00:00', '01:00:00', 'NYair', 19000),
(9, 'Praha', 'NY', 50, 'first', '2015-12-20', '12:00:00', '01:00:00', 'NYair', 26000);

-- --------------------------------------------------------

--
-- Struktura tabulky `rezervace`
--

CREATE TABLE IF NOT EXISTS `rezervace` (
  `id_rezervace` int(11) NOT NULL AUTO_INCREMENT,
  `id_cestujici` int(11) NOT NULL,
  `id_letenky` int(11) NOT NULL,
  `zaplaceno` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_rezervace`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=25 ;

--
-- Vypisuji data pro tabulku `rezervace`
--

INSERT INTO `rezervace` (`id_rezervace`, `id_cestujici`, `id_letenky`, `zaplaceno`) VALUES
(1, 16, 1, 0),
(2, 16, 4, 0),
(3, 25, 2, 0),
(4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id_cestujici` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `jmeno` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_cestujici`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=26 ;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id_cestujici`, `login`, `heslo`, `jmeno`, `prijmeni`, `adresa`, `email`, `telefon`, `is_admin`) VALUES
(1, 'filija', 'admin', 'Jakub', 'Filipek', 'Stary Poddvorov 318', 'filija.jakub@gmail.com', '775214063', 1),
(16, 'deka', 'tajneheslo', 'Jaroslav', 'Dekar', 'nekde 512', 'deka', '721 854 369', 0),
(24, 'nekdo', 'nejakeheslo', 'Nekdo', 'Nejaky', 'Nekdakov 842', 'nekdo', '723 333 156', 1),
(25, 'petrik', 'petrikovoheslo', 'Petr', 'Svoboda', 'Praha', 'petrikk', '721 854 361', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
