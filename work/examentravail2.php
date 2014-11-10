<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,"revenus");

clyo::head() ;
?>
    
			<h2>&Eacute;tude d'un dossyer</h2>    
    		
			<?php
			if (extraction("action")) {
				if ($action == "revenu" && extraction("num", "activite", "revenu")) {
					$act = new activite ;
					$act->get($num) ;
					$act->activite = $activite ;
					$act->revenu = $revenu ;
					$act->save() ;
					echo "<div>Modificatyons enregistr&eacute;es</div>" ;
				}
				else if ($action=="objectif" && extraction("num", "objectif", "details", "prime", "augmentation")) {
					$act = new activite ;
					$act->get($num) ;
					$act->etat = '2' ;
					$act->objectif = $objectif ;
					$act->details = $details ;
					$act->prime = $prime ;
					$act->augmentation = $augmentation ;
					$act->save() ;
					echo "<div>Modificatyons enregistr&eacute;es</div>" ;
				}
				else if ($action == "finrefusee" && extraction("num")) {
					$act = new activite ;
					$act->get($num) ;
					$act->etat = '2' ;
					$act->save() ;
					echo "<div>Modificatyons enregistr&eacute;es</div>" ;
				}
				else if ($action == "finvalide" && extraction("num")) {
					$act = new activite ;
					$act->get($num) ;
					//ICI : CRÉDITER LE COMPTE PRINCIPAL DE $act->personne DE $act->prime Y€
					    $compte = new compte;
					    $compte->getprincipal($act->personne);
					    $compte->solde += $act->prime;
					    $compte->save();
					    $transaction = new transaction;
					    $transaction->save_transaction("Prime de Revenu",0,$compte->num,$act->prime);
					$act->revenu = $act->revenu + $act->augmentation ;
					$act->etat = '0' ;
					$act->objectif = "" ;
					$act->details = "" ;
					$act->prime = 0 ;
					$act->augmentation = 0 ;
					$act->argument = "" ;
					$act->save() ;
					echo "<div>Modificatyons enregistr&eacute;es</div>" ;
				}
				else echo "<div>Aucun dossyer n'a &eacute;t&eacute; re&ccedil;u !</div>" ; 
			}
			else echo "<div>Aucun dossyer n'a &eacute;t&eacute; transmys !</div>" ;    		
    		?>


<?php
clyo::foot() ;
?>