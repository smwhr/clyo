<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
$a = new activite ;
$a->charge($p) ;

clyo::head() ;
?>
<h2>Offyce des Revenus</h2>    

<?php
if (extraction("activite")) {
	if ($activite == "") $activite = "aucune" ;
	if ($activite != $a->activite) {
		$a->activite = $activite ;
		$a->revenu = 0 ;
		$a->objectif = "" ;
		$a->details = "" ;
		$a->etat = '0' ;
		$a->save() ;
		echo "<p>Votre nouvelle activit&eacute; est donc d&eacute;sormays :</p>" ;
		echo "<p>".$a->activite."</p>" ;
	}
	else echo "<p>Vous exercez d&eacute;j&agrave; cette activit&eacute; !</p>" ;
}
else {
	echo "<p>Un probl&egrave;me est survenu. Veuillez r&eacute;essayer plus tard.</p>" ;
	print_r($_POST) ;
}

clyo::foot() ;
?>