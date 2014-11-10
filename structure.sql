-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: www.clyo.sql.free.fr
-- Generation Time: Nov 10, 2014 at 05:17 PM
-- Server version: 5.0.83
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `www_clyo`
--

-- --------------------------------------------------------

--
-- Table structure for table `cl_activite`
--

CREATE TABLE IF NOT EXISTS `cl_activite` (
  `num` int(11) NOT NULL auto_increment,
  `personne` int(11) NOT NULL,
  `activite` varchar(255) NOT NULL,
  `revenu` int(11) NOT NULL,
  `objectif` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `etat` int(3) NOT NULL,
  `augmentation` int(11) NOT NULL,
  `prime` int(11) NOT NULL,
  `argument` text NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_compte`
--

CREATE TABLE IF NOT EXISTS `cl_compte` (
  `num` int(11) NOT NULL auto_increment,
  `libelle` text NOT NULL,
  `titulaire` int(11) NOT NULL,
  `solde` int(11) NOT NULL,
  `banque` int(11) NOT NULL,
  `principal` int(1) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_cte`
--

CREATE TABLE IF NOT EXISTS `cl_cte` (
  `num` int(11) NOT NULL auto_increment,
  `nomc` text NOT NULL,
  `cdomicile` text NOT NULL,
  `ctravail` text NOT NULL,
  `impotlocal` int(11) NOT NULL,
  `email` mediumtext NOT NULL,
  `mj` int(11) NOT NULL,
  `mere` int(11) NOT NULL,
  `monnaie` text NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_droit`
--

CREATE TABLE IF NOT EXISTS `cl_droit` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_personne`
--

CREATE TABLE IF NOT EXISTS `cl_personne` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `type` smallint(6) NOT NULL,
  `password` mediumtext NOT NULL,
  `prenom` text NOT NULL,
  `email` mediumtext NOT NULL,
  `url` text NOT NULL,
  `photo` text NOT NULL,
  `proprietaire` int(11) NOT NULL,
  `cte` int(11) NOT NULL,
  `domicile` int(11) NOT NULL,
  `naturalisation` date NOT NULL,
  `bio` longtext NOT NULL,
  `lastc` date NOT NULL,
  `ip` mediumtext NOT NULL,
  `msn` mediumtext NOT NULL,
  `sexe` tinytext NOT NULL,
  `pere` int(11) NOT NULL,
  `nompere` text NOT NULL,
  `mere` int(11) NOT NULL,
  `nommere` text NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_petite_annonce`
--

CREATE TABLE IF NOT EXISTS `cl_petite_annonce` (
  `num` int(11) NOT NULL auto_increment,
  `terrain` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_poss_droit`
--

CREATE TABLE IF NOT EXISTS `cl_poss_droit` (
  `num` int(11) NOT NULL auto_increment,
  `personne` int(11) NOT NULL,
  `droit` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_quartier`
--

CREATE TABLE IF NOT EXISTS `cl_quartier` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `cte` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `plan` mediumtext NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_rue`
--

CREATE TABLE IF NOT EXISTS `cl_rue` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `quartier` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_terrain`
--

CREATE TABLE IF NOT EXISTS `cl_terrain` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `rue` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `proprietaire` int(11) NOT NULL,
  `photo` mediumtext NOT NULL,
  `description` text NOT NULL,
  `loyer` int(11) NOT NULL,
  `locataire` int(11) NOT NULL,
  `compteloc` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `cl_transaction`
--

CREATE TABLE IF NOT EXISTS `cl_transaction` (
  `num` int(11) NOT NULL auto_increment,
  `libelle` text collate latin1_general_ci NOT NULL,
  `comptefrom` int(11) NOT NULL,
  `compteto` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
