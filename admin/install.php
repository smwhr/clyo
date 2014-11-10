<?php

require_once("../inc/centrale.php");

clyo::head() ;

?>

<h2>Installation de Clyo</h2>
<div>
	<h3>Mettre &agrave; jour Clyo</h3>
	<form action="install.php" method="post">
		<table class="form_table">
			<tr>
				<th>Utilisateur</th>
				<td>root</td>
			</tr>
			<tr>
				<th>Mot de passe</th>
				<td><input type="text" name="password" /></td>
			</tr>
			<tr>
				<th>Confirmer</th>
				<td><input type="checkbox" name="confirm" class='checkbox' /></td>
			</tr>
        		<td>&nbsp;</td>
        		<td><input type="submit" value="Go !" class='button' /></td>
			</tr>
		</table>
	</form>
</div>
<?if(extraction("confirm")):?>
<div>
    <h3>Process :</h3>
    <pre>
<?
//on verifie qu'on a bien un fichier inc/config.php
$conf_exists = file_exists('../inc/config.php');
if(!$conf_exists)
    die ("Le fichier inc/config.php n'existe pas. Veuillez le cr&eacute;er. Un fichier d'exemple (inc/config-sample.php) est disponible.");

//on verifie que la base n'existe pas déjà.
$prefixe = mysqldb::$prefixe;
$line = mysqldb::getline($prefixe."personne",1) ;

if($line)
    die ("La base de donn&eacute;e existe d&eacute;j&agrave;. Videz la si vous voulez recommencer une installation.");

(extraction("password") and $password != '') or die("Veuillez sp&eacute;cifier un mot de passe pour root.");

$password = md5($password);

$create_query = <<<EOT
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_activite`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_activite` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_compte`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_compte` (
  `num` int(11) NOT NULL auto_increment,
  `libelle` text NOT NULL,
  `titulaire` int(11) NOT NULL,
  `solde` int(11) NOT NULL,
  `banque` int(11) NOT NULL,
  `principal` int(1) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `{$prefixe}_compte` (`num`, `libelle`, `titulaire`, `solde`, `banque`, `principal`) VALUES
(1, 'Compte Root', 1, 1000, 1, 1);


-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_cte`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_cte` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `{$prefixe}_cte` (`num`, `nomc`, `cdomicile`, `ctravail`, `impotlocal`, `email`, `mj`, `mere`, `monnaie`) VALUES
(1, 'Venys', 'Hotel Ibys', 'Docker au port', 5, 'serenyssime@yahoogroupes.fr', 1, 0, 'Y$');


-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_droit`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_droit` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


INSERT INTO `{$prefixe}_droit` (`num`, `nom`) VALUES
(1, 'root'),
(2, 'maire'),
(4, 'doge'),
(5, 'revenus'),
(6, 'fysc');

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_personne`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_personne` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `{$prefixe}_personne` (`num`, `nom`, `type`, `password`, `prenom`, `email`, `url`, `photo`, `proprietaire`, `cte`, `domicile`, `naturalisation`, `bio`, `lastc`, `ip`, `msn`, `sexe`, `pere`, `nompere`, `mere`, `nommere`) VALUES
(1, 'Root', 0, '$password', 'Root', 'root@clyo', '', '', 0, 1, 0, NOW(), '', NOW(), '', '', 'm', 0, '', 0, '');


-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_petite_annonce`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_petite_annonce` (
  `num` int(11) NOT NULL auto_increment,
  `terrain` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_poss_droit`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_poss_droit` (
  `num` int(11) NOT NULL auto_increment,
  `personne` int(11) NOT NULL,
  `droit` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `{$prefixe}_poss_droit` (`num`, `personne`, `droit`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_quartier`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_quartier` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `cte` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `plan` mediumtext NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_rue`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_rue` (
  `num` int(11) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `quartier` int(11) NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_terrain`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_terrain` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefixe}_transaction`
--

CREATE TABLE IF NOT EXISTS `{$prefixe}_transaction` (
  `num` int(11) NOT NULL auto_increment,
  `libelle` text collate latin1_general_ci NOT NULL,
  `comptefrom` int(11) NOT NULL,
  `compteto` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `num` (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


EOT;

mysqldb::send($create_query);

?>

    </pre>
    
</div>

<?endif;?>



<?
clyo::foot() ;

