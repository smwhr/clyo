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
    		if ($a->etat == 0) echo "<div>Vous n'avez pas d&eacute;clar&ecute; d'objectif !</div>" ;
    		else if ($a->etat == 0) echo "<div>Vous avez d&eacute;clar&ecute; un objectif quy est en attente de validatyon. Vous ne pouvez pas le d&eacute;clarer termin&eacute; !</div>" ;
    		else if ($a->etat == 3) echo "<div>Vous avez d&eacute;j&agrave; d&eacute;clar&eacute; avoir termin&eacute; votre objectif !</div>" ;
    		else if (extraction("argument")) {
    			$a->argument = $argument ;
    			$a->etat = '3' ;
    			$a->save() ;
    			echo "<div>Votre d&eacute;claratyon a &eacute;t&eacute; enregistr&eacute;e, et va &ecirc;tre examin&eacute;e par l'administratyon.</div>" ;
    		}
    		else {
    			echo "<div>Un probl&egrave;me est survenu. Veuillez r&eacute;essayer plus tard.</div>" ;
    		}
    		?>
		

<?php
clyo::foot() ;
?>
