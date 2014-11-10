<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
$a = new activite ;
$a->charge($p) ;

clyo::head() ;
?>
    
			<h2>Offyce des Revenus</h2>    
    		
			<div>  		
    		
    		<?php
    		if ($a->etat > 0) echo "<p>Vous avez d&eacute;j&agrave; un objectif !</p>" ;
    		else if (extraction("objectif","details")) {
    			$a->objectif = $objectif ;
    			$a->details = $details ;
    			$a->etat = '1' ;
    			$a->save() ;
    			if ($objectif == "") echo "<p>Vous avez demand&eacute; &agrave; ce qu'un objectif 
    			vous soyt donn&eacute;. L'administratyon va maintenant &eacute;tudier votre dossyer. Allez 
    			r&eacute;guli&egrave;ment voyr l'Offyce des Revenus pour savoyr sy vous en avez re&ccedil;u un.</p>" ;
    			else {
    				echo "<p>Vous vous &ecirc;tes donn&eacute; l'objectif suivant :</p>" ;  
    				echo "<dl>" ;
					echo "<dt>".$a->objectif."</dt>" ;
					echo "<dd>".$a->details."</dd>" ;
					echo "</dl>" ;	
					echo "<p>L'administratyon doyt mayntenant valider cet objectif.  Allez 
    				r&eacute;guli&egrave;ment voyr l'Offyce des Revenus pour savoyr o&ugrave; 
    				en est votre dossyer.</p>" ;
    			}
    		}
    		else {
    			echo "<p>Un probl&egrave;me est survenu. Veuillez r&eacute;essayer plus tard.</p>" ;
    		}
    		?>
			
			</div>

</div>
</body>
</html>
