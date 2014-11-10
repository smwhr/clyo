<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,"revenus");

function affiche($requete) {
	$a = new activite ;
 	$a->select($requete) ;
 	if ($a->lenen() == 0) echo "	<p>Aucun.</p>\n" ;
 	else {
 		echo "	<table class='actifs'>\n" ;
 		echo "		<tr>\n" ;
 		echo "			<th>Nom</th>\n" ;
 		//echo "			<th>Qualit&eacute;</th>\n";
 		echo "			<th>Activit&eacute;</th>\n" ;
 		echo "			<th>Objectif</th>\n" ;
 		echo "			<th>Actyon</th>\n" ;
 		echo "		</tr>\n" ;
 		$i = 0 ;
 		while ($a->next()) {
 			if (bcmod($i, '2') == '0') $typ = "class='pair'" ;
    	  	else $typ = "class='impair'" ;
 			$i++ ;
 			$demandeur = new personne ;
			$demandeur->get($a->personne) ;
 			/*if ($demandeur->type == 0) $type = "Citoyen" ;
 			else if ($demandeur->type == 1) $type = "Entrepryse" ;
			else $type = "Service Public" ;*/
 			echo "		<tr $typ>\n" ;
 			if ($demandeur->type == 0) echo "			<td class='nom'>".$demandeur->nom."</td>\n" ;
 			else echo "			<td>".$demandeur->nom."</td>\n" ;
 			//echo "			<td>".$type."</td>\n" ;
			echo "			<td>".$a->activite."</td><td>".$a->objectif."</td>
 			<td><a href='examentravail.php?a=".$a->num."'>Examiner</a></td>\n" ;
 			echo "		</tr>\n" ;
 		}
 		echo "	</table>\n" ;
 	}
}

clyo::head() ;

?>
    
<h2>Administratyon des Revenus</h2>    

<div id='objectif_attente'>
	<h3>Objectifs en attente de validatyon</h3>
<?php
affiche("WHERE etat = '1'") ;
?>
</div>

<div id='objectif_atteint'>
	<h3>Objectifs d&eacute;clar&eacute; atteynts</h3>
<?php
affiche("WHERE etat = '3'") ;
?>
</div>

<div id='liste_actifs'>
	<h3>Lyste des actifs</h3>
<?php
affiche("") ;
?>
</div>


<?php
clyo::foot() ;
?>
