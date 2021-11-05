-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 nov. 2021 à 08:21
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `facturation_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_categories`
--

DROP TABLE IF EXISTS `t_categories`;
CREATE TABLE IF NOT EXISTS `t_categories` (
  `r_i` int(10) NOT NULL AUTO_INCREMENT,
  `r_libelle` varchar(45) NOT NULL,
  `r_description` text NOT NULL,
  `r_status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_i`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_categories`
--

INSERT INTO `t_categories` (`r_i`, `r_libelle`, `r_description`, `r_status`, `created_at`, `updated_at`) VALUES
(1, 'Informatiques', 'Informatiques', 1, '2021-11-04 22:22:18', '2021-11-04 22:22:18'),
(2, 'Electronique', 'Electronique', 1, '2021-11-04 22:26:00', '2021-11-04 22:26:00');

-- --------------------------------------------------------

--
-- Structure de la table `t_clients`
--

DROP TABLE IF EXISTS `t_clients`;
CREATE TABLE IF NOT EXISTS `t_clients` (
  `r_i` int(10) NOT NULL,
  `r_type_person` int(1) NOT NULL,
  `r_nom` varchar(45) NOT NULL,
  `r_prenoms` varchar(45) NOT NULL,
  `r_phone` varchar(15) NOT NULL,
  `r_email` varchar(255) NOT NULL,
  `r_description` text NOT NULL,
  `r_partenaire` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_details_ventes`
--

DROP TABLE IF EXISTS `t_details_ventes`;
CREATE TABLE IF NOT EXISTS `t_details_ventes` (
  `r_i` int(11) NOT NULL AUTO_INCREMENT,
  `r_facture` int(11) NOT NULL,
  `r_produit` int(10) NOT NULL,
  `r_quantite` int(11) NOT NULL,
  `r_total` int(10) NOT NULL,
  `r_description` text NOT NULL,
  `r_partenaire` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_i`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_ventes`
--

DROP TABLE IF EXISTS `t_ventes`;
CREATE TABLE IF NOT EXISTS `t_ventes` (
  `r_i` int(11) NOT NULL AUTO_INCREMENT,
  `r_num` int(11) NOT NULL,
  `r_client` int(11) NOT NULL,
  `r_mnt` int(11) NOT NULL,
  `r_status` int(11) NOT NULL,
  `r_iscmd` int(11) NOT NULL,
  `r_partenaire` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_i`),
  UNIQUE KEY `r_num` (`r_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_partenaires`
--

DROP TABLE IF EXISTS `t_partenaires`;
CREATE TABLE IF NOT EXISTS `t_partenaires` (
  `r_i` int(11) NOT NULL AUTO_INCREMENT,
  `r_code` varchar(10) NOT NULL,
  `r_nom` varchar(45) NOT NULL,
  `r_ville` int(1) NOT NULL,
  `r_quartier` varchar(45) NOT NULL,
  `r_situation_geo` text NOT NULL,
  `r_status` int(1) NOT NULL DEFAULT '0',
  `r_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `r_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`r_i`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_partenaires`
--

INSERT INTO `t_partenaires` (`r_i`, `r_code`, `r_nom`, `r_ville`, `r_quartier`, `r_situation_geo`, `r_status`, `r_description`, `created_at`, `updated_at`, `r_utilisateur`) VALUES
(1, 'part-1', 'test', 1, 'test', 'test', 0, 'test', '2021-11-04 21:45:36', '2021-11-04 21:45:36', 1),
(2, 'part-2', 'soro', 1, 'soro', 'soro', 0, 'soro', '2021-11-04 21:54:31', '2021-11-04 21:54:31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_produits`
--

DROP TABLE IF EXISTS `t_produits`;
CREATE TABLE IF NOT EXISTS `t_produits` (
  `r_i` int(11) NOT NULL,
  `r_categorie` int(10) NOT NULL,
  `r_libelle` varchar(45) NOT NULL,
  `r_stock` int(10) NOT NULL,
  `r_prix_vente` int(11) NOT NULL,
  `r_description` text NOT NULL,
  `r_status` int(1) NOT NULL,
  `r_partenaire` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_profil`
--

DROP TABLE IF EXISTS `t_profil`;
CREATE TABLE IF NOT EXISTS `t_profil` (
  `r_i` int(10) NOT NULL AUTO_INCREMENT,
  `r_libelle` varchar(45) DEFAULT NULL,
  `r_description` text,
  `r_status` int(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_i`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_profil`
--

INSERT INTO `t_profil` (`r_i`, `r_libelle`, `r_description`, `r_status`, `created_at`, `updated_at`) VALUES
(1, 'Exploitant', NULL, 1, '2021-11-02 16:40:28', '2021-11-02 17:05:39'),
(2, 'Electroniques', NULL, 1, '2021-11-02 17:56:35', '2021-11-02 17:56:35'),
(3, 'Bureautique', 'Bureautique', 1, '2021-11-04 18:26:02', '2021-11-04 18:26:02');

-- --------------------------------------------------------

--
-- Structure de la table `t_reglement_partiele`
--

DROP TABLE IF EXISTS `t_reglement_partiele`;
CREATE TABLE IF NOT EXISTS `t_reglement_partiele` (
  `r_i` int(10) NOT NULL AUTO_INCREMENT,
  `r_facture` int(10) NOT NULL,
  `r_montant` int(15) NOT NULL,
  `r_date_eng` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `r_date_modif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `r_partenaire` int(11) NOT NULL,
  PRIMARY KEY (`r_i`),
  KEY `r_partenaire` (`r_partenaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_utilisateurs`
--

DROP TABLE IF EXISTS `t_utilisateurs`;
CREATE TABLE IF NOT EXISTS `t_utilisateurs` (
  `r_i` int(11) NOT NULL AUTO_INCREMENT,
  `r_partenaire` int(15) NOT NULL,
  `r_profil` int(15) NOT NULL DEFAULT '0',
  `r_nom` varchar(25) DEFAULT NULL,
  `r_prenoms` varchar(45) DEFAULT NULL,
  `r_phone` varchar(15) DEFAULT NULL,
  `r_email` varchar(255) DEFAULT NULL,
  `r_login` varchar(10) NOT NULL,
  `r_mdp` text,
  `r_status` int(1) NOT NULL DEFAULT '0',
  `r_img` varchar(255) DEFAULT NULL,
  `r_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_i`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_utilisateurs`
--

INSERT INTO `t_utilisateurs` (`r_i`, `r_partenaire`, `r_profil`, `r_nom`, `r_prenoms`, `r_phone`, `r_email`, `r_login`, `r_mdp`, `r_status`, `r_img`, `r_description`, `created_at`, `updated_at`) VALUES
(1, 0, 4, 'DEKI', 'Momo', '+225', NULL, 'admin', 'admin', 1, NULL, NULL, '2021-11-02 16:54:17', '2021-11-03 12:23:44'),
(2, 0, 4, 'kone', 'Momo', '+225', NULL, 'kone', 'kone', 0, NULL, NULL, '2021-11-04 15:09:24', '2021-11-04 15:09:24'),
(3, 0, 4, 'issa', 'issa', '+225', NULL, 'issa', 'issa', 0, NULL, NULL, '2021-11-04 15:09:48', '2021-11-04 15:09:48'),
(4, 0, 4, 'coul', 'issa', '+225', NULL, 'coul', 'coul', 0, NULL, NULL, '2021-11-04 15:09:58', '2021-11-04 15:09:58'),
(5, 0, 4, 'sidibe', 'issa', '+225', NULL, 'sidibe', 'sidibe', 0, NULL, NULL, '2021-11-04 15:10:11', '2021-11-04 15:10:11'),
(6, 0, 4, 'ken', 'issa', '+225', NULL, 'ken', 'kenken', 0, NULL, NULL, '2021-11-04 15:10:43', '2021-11-04 15:10:43');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
