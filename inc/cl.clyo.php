<?php

class clyo {


	public static function head($style='defaut') {
		
		$p = new personne ;
		$connecte = $p->secure() ;

header("Content-type:text/html; charset=ISO-8859-1",true) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Clyo, Administratyon du S&eacute;r&eacute;nyssime Empire d'Ys</title>
	<link rel="shortcut icon" href="/favicon.ico" />
	<?php
	$p = new personne ;
	if (($style <> "exterieur") && $p->secure()) echo "<link rel='stylesheet' type='text/css' href='../skin/style.css' />\n" ;
	else echo "<link rel='stylesheet' type='text/css' href='../skin/exterieur.css' />\n"
	?>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
</head>
<body>

<h1>Clyo, Administratyon du S&eacute;r&eacute;nyssime Empire d'Ys</h1>

<div id='page'>
<?php
		if ($connecte) {	
		?>

	<div id="menu">
		<dl>
			<dt id='menugeneral'>G&eacute;n&eacute;ral</dt>
			<dd><a href="../main/index.php">Accueil</a></dd>
			<dd><a href="../main/logout.php">Se d&eacute;connecter</a></dd>

			<dt id='menuvous'>Vous</dt>
			<dd><a href="../me/index.php">Fiche d'identyt&eacute;</a> [<a href="../me/modifprofil.php">Modifier</a>]</dd>
			<dd><a href="../me/clones.php">Lyste de vos proches</a></dd>
			<dd><a href="../me/makeaclone.php">Cr&eacute;er un proche</a></dd>

			<dt id='menupolitique'>Vie publique</dt>
			<dd><a href="../politics/registre.php?t=0">Annuayre yssois</a></dd>
			<dd><a href="../politics/registre.php?t=1">Regystre du commerce</a></dd>
			<dd><a href="../politics/registre.php?t=2">Services publics</a></dd>
			<dd><a href="../work/travail.php">Offyce des revenus</a></dd>

			<dt id='menubanque'>Banque</dt>
			<dd><a href="../bank/index.php">Vos comptes</a></dd>
			<dd><a href="../bank/transaction.php">Passer une transaction</a></dd>

			<dt id='menuimmobilier'>Immobilier</dt>
			<dd><a href="../realestate/index.php">Petites Annonces</a></dd>
			<dd><a href="../realestate/cadastre.php">Cadastre Administratif</a></dd>
			<dd><a href="../realestate/biens.php">Vos biens</a></dd>

			<?php
			if(droit::hasgot($p,"doge", "revenus", "maire")){
				echo "			<dt id='menuadministration'>Administratyon</dt>\n" ;
   			if (droit::hasgot($p,'doge')) echo "			<dd><a href='../politics/conseiladmin.php'>Dystributyon des Postes</a></dd>\n" ;
   			if (droit::hasgot($p,'revenus')) echo "			<dd><a href='../work/travailadmin.php'>Allocatyon des Revenus</a></dd>\n" ;
    			if (droit::hasgot($p,'maire')) echo "			<dd><a href='../realestate/admincadastre.php'>Modifier le Cadastre</a></dd>\n" ;
			}

			if(droit::hasgot($p,'root')){
				?>

			<dt id='menuclyo'>Clyo</dt>
			<dd><a href="../admin/newtour.php">Nouveau tour</a></dd>
			<dd><a href="../admin/supprperso.php">Supprimer quelqu'un</a></dd>
			<dd><a href="../admin/admindroit.php">G&eacute;rer les droits</a></dd>
			<dd><a href="../admin/listeip.php">Liste des IP</a></dd>
			<dd><a href="../admin/univconnect.php">Connexyon Universelle</a></dd>
				<?php
			}
			?>
		</dl>
	</div>

	<div id='content'>


<!-- FIN INSERTION CLYO::HEAD -->


		<?php	
		}
		else  {
			?>
	<div id="menu">
		<ul>
			<li class='first'><a href="../main/toconnect.php?t=0">Se connecter</a></li>
			<li><a href="../politics/registre.php?t=0">Annuayre yssois</a></li>
			<li><a href="../politics/registre.php?t=1">Regystre du commerce</a></li>
			<li class='last'><a href="../politics/registre.php?t=2">Services publics</a></li>
		</ul>
	</div>

	<div id='content'>


<!-- FIN INSERTION CLYO::HEAD -->	


			<?php
		}
	}


	public static function foot() {
?>


<!-- DEBUT INSERTION CLYO::FOOT -->

	</div>
</div>
</body>
</html>
<?php
	}

}


?>
