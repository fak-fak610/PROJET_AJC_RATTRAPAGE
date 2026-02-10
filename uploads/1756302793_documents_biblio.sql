-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 août 2025 à 13:45
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `documents_biblio`
--

-- --------------------------------------------------------

--
-- Structure de la table `documents_user`
--

DROP TABLE IF EXISTS `documents_user`;
CREATE TABLE IF NOT EXISTS `documents_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `upload_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `documents_user`
--

INSERT INTO `documents_user` (`id`, `nom`, `chemin`, `upload_time`) VALUES
(1, 'test.txt', 'documents_biblio/test.txt', '2025-08-27 15:38:35');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
