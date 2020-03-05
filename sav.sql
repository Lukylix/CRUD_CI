-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 26 fév. 2020 à 13:05
-- Version du serveur :  10.4.12-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sav`
--
CREATE DATABASE `sav`;
USE `sav`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nomClient` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numClient` int(11) NOT NULL,
  `emailClient` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseClient` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telClient` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `idCommande` int(11) NOT NULL,
  `numeroCommande` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCommande` datetime NOT NULL,
  `isDelivered` tinyint(1) DEFAULT NULL,
  `fk_idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandeProduit`
--

CREATE TABLE `commandeProduit` (
  `idCommandeProduit` int(11) NOT NULL,
  `fk_commandeId` int(11) DEFAULT NULL,
  `fk_produitId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `nomProduit` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptProduit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qttProduit` int(11) NOT NULL,
  `isAvailable` tinyint(1) DEFAULT NULL,
  `prixProduit` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCommande`),
  ADD KEY `command_client_fk` (`fk_idClient`);

--
-- Index pour la table `commandeProduit`
--
ALTER TABLE `commandeProduit`
  ADD PRIMARY KEY (`idCommandeProduit`),
  ADD KEY `FK_CommandeProduit` (`fk_commandeId`),
  ADD KEY `FK_ProduitCommande` (`fk_produitId`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandeProduit`
--
ALTER TABLE `commandeProduit`
  MODIFY `idCommandeProduit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `command_client_fk` FOREIGN KEY (`fk_idClient`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `commandeProduit`
--
ALTER TABLE `commandeProduit`
  ADD CONSTRAINT `FK_CommandeProduit` FOREIGN KEY (`fk_commandeId`) REFERENCES `commande` (`idCommande`),
  ADD CONSTRAINT `FK_ProduitCommande` FOREIGN KEY (`fk_produitId`) REFERENCES `produit` (`idProduit`);
COMMIT;

DROP TABLE `user` ;
CREATE TABLE `user`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(15) NOT NULL,
  `email` VARCHAR(320) NOT NULL,
  `password` varchar(72) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
