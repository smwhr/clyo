<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,"revenus");

clyo::head() ;
?>
    
	<h2>&Eacute;tude d'un dossyer</h2>    
    		
<?php
if (extraction("a",$_GET)) {    		
	?>
	<div id='activite'>
	<?php    		
   $act = new activite ;
	$act->get($a) ;
	
	if ($act->etat == '1') echo "		<p class='important'>Objectif en attente de validatyon !</p>\n" ;
	if ($act->etat == '3') echo "		<p class='important'>Objectif d&eacute;clar&eacute; atteynt !</p>\n" ;
	
	$dem = new personne ;
	$dem->get($act->personne) ;
	$cte = new cte ;
	$cte->get($dem->cte) ;
	echo "		<dl>\n" ;
	echo "			<dt>Identit&eacute;</dt>\n" ;
	if ($dem->type == 0) echo "			<dd>".$dem->prenom." <span class='nom'>".$dem->nom."</span></dd>\n\n" ;
	else echo "			<dd>".$dem->nom."</dd>\n\n" ;
	echo "			<dt>Statut</dt>\n" ;
	if ($dem->type == 0) echo "			<dd>Citoyen</dd>\n\n" ;
	else if ($dem->type == 1) echo "			<dd>Entrepryse</dd>\n\n" ;
	else echo "			<dd>Service public</dd>\n\n" ;
	echo "			<dt>Activit&eacute; d&eacute;clar&eacute;e</dt>\n" ;
	echo "			<dd>".$act->activite."</dd>\n\n" ;
	echo "			<dt>Revenus actuels</dt>\n" ;
	echo "			<dd>".$act->revenu." ".$cte->monnaie."</dd>\n\n" ;
	echo "			<dt>Objectif</dt>\n" ;
	if ($act->objectif <> "") {
		echo "			<dd>".$act->objectif."</dd>\n\n" ;
		if ($act->details <> "") {
			echo "			<dt>D&eacute;tayls</dt>\n" ;
			echo "			<dd>".$act->details."</dd>\n" ;
		}
	}	
	else echo "			<dd>Aucun</dd>\n\n" ;
	echo "		</dl>\n" ;
	?>
	</div>
	<div id="modifier_activite">
	<h3>Modifier l'activit&eacute; ou le revenu</h3>
		<form action="examentravail2.php" method="POST">
			<table class="form_table">
				<tr>
 					<th> Activit&eacute; </th>
               <td>
    					<input type="text" name="activite" value="<?=$act->activite ?>" />
    					<input type='hidden' name='action' value='revenu'/>
						<input type='hidden' name='num' value='<?=$act->num ?>'/>
					</td>
    			</tr>    			
    			<tr>
                <th> Revenu </th>
                <td><input type="text" name="revenu" value="<?=$act->revenu ?>" /></td>
                <td><?=$cte->monnaie ?></td>
    			</tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Envoyer" class='button' /></td>
    			</tr>
			</table>
		</form>
	</div>
	<div id="modifier_objectif">
	<h3>Modifier ou valider un objectif</h3>
	<?php
	if ($act->etat == '1') echo "		<p>Cet objectif est en attente de validatyon !</p>\n" ;	
	?>
		<form action="examentravail2.php" method="POST">
			<table class="form_table">
				<tr>
 					<th> Objectif </th>
               <td>
    					<input type="text" name="objectif" value="<?=$act->objectif ?>" />
    					<input type='hidden' name='action' value='objectif'/>
						<input type='hidden' name='num' value='<?=$act->num ?>'/>
					</td>
    			</tr>
    			<tr>
                <th> D&eacute;tails </th>
                <td><textarea name="details"><?=$act->details ?></textarea></td>
    			</tr>
    			<tr>
                <th> Prime </th>
                <td><input type="text" name="prime" value='<?=$act->prime ?>'/></td>
                <td><?=$cte->monnaie ?></td>
    			</tr>
    			<tr>
               <th> Augmentatyon</th>
           		<td><input type="text" name="augmentation" value='<?=$act->augmentation ?>'/></td>
           		<td><?=$cte->monnaie ?></td>
    			</tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Envoyer" class='button'/></td>
    			</tr>
			</table>
		</form>
	</div>
	<?php	
	if ($act->objectif <> "") {
		?>

	<div id='objectif'>
	   <h3>Consyd&eacute;rer l'objectif comme atteynt</h3>
		<?php
		if ($act->etat == '3') echo "		<p class='important'>Cet objectif a &eacute;t&eacute; d&eacute;clar&eacute; atteynt !</p>" ;
		echo "		<dl>\n" ;
		echo "			<dt>Objectif</dt>\n" ;
		echo "			<dd>".$act->objectif."</dd>\n\n" ;
		if ($act->details <> "") {
			echo "			<dt>D&eacute;tayls</dt>\n" ;
			echo "			<dd>".$act->details."</dd>\n" ;
		}
		echo "			<dt>Prime &agrave; la clef</dt>\n";
		echo "			<dd>".$act->prime." ".$cte->monnaie."</dd>\n\n";
		echo "			<dt>Augmentatyon du revenu touch&eacute; par tour</dt>\n" ;
		echo "			<dd>".$act->augmentation." ".$cte->monnaie."</dd>\n\n" ;
		if ($act->etat == '3') {
			echo "			<dt>Justificatyon</dt>\n" ;
			echo "			<dd>".$act->argument."</dd>\n\n" ;
		}
		echo "		</dl>\n" ;
		?>
		<form action='examentravail2.php' method='POST'>
      	<input type="hidden" name="action" value="finvalide" />
			<input type='hidden' name='num' value='<?=$act->num ?>'/>
        	<input type="submit" value="Valider et clore le dossyer" class='button' />
       </form>
		<?php
		if ($act->etat == '3') {
		?>
       <form action='examentravail2.php' method='POST'>
       	<input type="hidden" name="action" value="finrefusee" />
			<input type='hidden' name='num' value='<?=$act->num ?>'/>
			<input type="submit" value="Refuser de valider" class='button'/>
		</form>
	</div>
		<?php
		}
	}
}
else echo "<div>Aucun dossyer n'a &eacute;t&eacute; transmys !</div>" ;

clyo::foot() ;
?>
