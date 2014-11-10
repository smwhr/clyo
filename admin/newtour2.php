<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,"root") ;

extraction("confirm") or die("Vous avez oubli&eacute; de confirmer !") ;

clyo::head() ;
?>

<h2>Compte-rendu de tour</h2>

<?php
$deficit = 0;
$test = true ;

if ($test) echo "<div>Cecy est un test !</div>" ;

?>
<div>Timestamp : <?echo time() ?></div>
	
<div>
	<h3>Versement des salayres</h3>
<?php
$travail = new activite;
$travail->select();
while($travail->next()){
	$compte = new compte;
	$compte->getprincipal($travail->personne);
	$compte->solde = $compte->solde + $travail->revenu;
	if(!$test) $compte->save();

	$deficit+=$travail->revenu;
    
	$transac = new transaction;
	if(!$test) $transac->save_transaction("Salayre",0,$compte->num,$travail->revenu);
    
	$personne = new personne;
	$personne->get($travail->personne);
	echo "Salaire vers&eacute; &agrave; ".$personne->nom." (".$travail->revenu."Y&euro;)<br />\n";
}
?>

	<h3>Versement des loyers</h3>
<?php
$location = new terrain;
$location->select("WHERE locataire<>0");
while($location->next()){
	$comptefrom = new compte;
	$comptefrom->get($location->compteloc);
	if($comptefrom->solde>=1){
		$comptefrom->solde = $compte->solde - $location->loyer;
	}
	else{
		$personne = new personne;
		$personne->get($location->locataire);
		$location->expulser();
		echo "$personne->nom a &eacute;t&eacute; expuls&eacute; de la locatyon #$location->num<br />\n";
		continue;
	}
	if(!$test) $comptefrom->save();

	$compteto = new compte;
	$compteto->getprincipal($location->proprietaire);
	$compteto->solde = $compte->solde + $location->loyer;
	if(!$test) $compteto->save();

 	$transac = new transaction;
	if(!$test) $transac->save_transaction("Loyer",$comptefrom->num,$compteto->num,$location->loyer);
    
	$personne = new personne;
	$personne->get($location->proprietaire);
	echo "Loyer vers&eacute; &agrave; $personne->nom.<br />\n";

}
?>
	<h3>Imp&ocirc;t sur le revenu</h3>
	<h3>Imp&ocirc;t foncier</h3>
	<h3>R&eacute;capitulatif</h3>
</div>

<?php
clyo::foot() ;
?>
