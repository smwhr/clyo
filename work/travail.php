<?php
require_once "../inc/centrale.php" ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
$a = new activite ;
$a->charge($p) ;
$cte = new cte ;
$cte->get($p->cte) ;

clyo::head() ;
?>
    
<h2>Offyce des revenus</h2>    
    		
<div class='aide'>
	L'Offyce des revenus est l'administratyon charg&eacute;e d'&eacute;tablir le dossyer fyscal de chaque 
	citoyen, entrepryse ou service public. Ne sont reconnues par l'&Eacute;tat et n'ont de valeur
	que les activit&eacute;s et entr&eacute;es d'argent d&eacute;clar&eacute;es aupr&egrave;s de 
	l'Offyce. Celuy-cy peut aussy vous donner des conseyls pour augmenter vos revenus.<br/>
	Comme pour toutes les administratyons, vous pouvez contester une d&eacute;cisyon de l'Offyce
	aupr&egrave;s du Tribunal d'Ys.
</div>		
    		
<div id='activite'>
	<h3>R&eacute;capitulatif de votre dossyer</h3>
	<dl>
		<?php /*
    	<dt>Nom</dt>
		<dd><?=$p->prenom." ".$p->nom ?></dd>
    	
    	<dt>Qualit&eacute;</dt>
		<dd><?echo $p->statut();?></dd>
		*/ ?>
    	<dt>Activit&eacute; </dt>
		<dd><?=$a->activite; ?></dd>

		<dt>Revenus</dt>
		<dd><?=$a->revenu." ".$cte->monnaie ?> par tour</dd>

    	<dt>Objectif</dt>
		<dd><?php if ($a->objectif == "") echo "aucun" ; else { echo $a->objectif ; 
			if ($a->accepte == '0') echo "(en attente de validatyon)" ; } ?></dd>    	
	</dl>
</div>
    		
<div id='travailler'>
	<?php
	if ($a->etat == '0') {
		?>
	<h3>Objectif</h3>
	<p class='aide'>
		Afin de justifyer une future augmentatyon de vos revenus, ponctuelle ou 
		permanente, vous devez au pr&eacute;alable d&eacute;clarer un &laquo; objectif &raquo;. 
		Il s'agit simplement d'indiquer la many&egrave;re dont vous comptez proc&eacute;der pour augmenter vos 
		entr&eacute;es d'argent. L'Offyce calculera de combyen votre revenu par tour devrayt 
		augmenter ainsy que la somme que vous devryez toucher directement sy vous remplyssez votre 
		objectif, et ce en fonctyon, entre autres, de la coh&eacute;rence de votre objectif avec 
		votre activit&eacute; actuelle.
	</p>
	<h4>Se fixer soi-m&ecirc;me un objectif&hellip;</h4>
	<form action="fixerobjectif.php" method="POST">
		<table class="form_table">
			<tr>
				<th> Objectif </th>
            <td><input type="text" name="objectif" /></td>
         </tr>
         <tr>
    	     <th> D&eacute;tails </th>
           <td><textarea name="details"></textarea></td>  
         </tr>
         <tr>
    	    	<td>&nbsp;</td>
            <td><input type="submit" value="Envoyer" /></td>
         </tr>		
      </table>
	</form>        				
	<h4>&hellip; ou en demander un.</h4>
		<form action='fixerobjectif.php' method='POST'>
        	<input type="hidden" name="objectif" value="" />
			<input type="hidden" name="details" value="" />
        	<input type="submit" value="Demander &agrave; recevoir un objectif" class='button' />
		</form>
		<?php
	}
	else if ($a->etat == '1') {
		if ($a->objectif != "") {
		?>
	<h3>Objectif&nbsp; <?= $a->objectif ?></h3>
	<cite>
		<?=$a->details ?>
	</cite>
	<p>
		Cet objectif est actuellement en cours 
		d'examen par l'Administratyon. 
	</p>		
		<?php
		}
		else {
		?>	
	<p>
		Vous avez demand&eacute; &agrave; recevoyr un objectif. L'Administratyon &eacute;tudye votre dossyer.
	</p>
		<?php
		}
	}
	else {
		?>
	<h3>Objectif&nbsp;: <?= $a->objectif ?></h3>
	<cite>
		<?=$a->details ?>
	</cite>
	<p>
		Sy vous r&eacute;ussyssez &agrave; atteindre cet objectif, votre revenu devrayt augmenter de 
		<?=($a->augmentation." ".$cte->monnaie) ?> par tour et vous devryez toucher en plus la somme de 
		<?=($a->prime." ".$cte->monnaie) ?> (pr&eacute;visyons de l'Offyce).
	</p>
		<?php
		if ($a->etat == '3') {
			echo "	<p>
		Vous avez d&eacute;clar&eacute; avoyr atteynt votre objectif. L'administratyon est en trayn d'&eacute;tudier votre dossyer.
	</p>\n" ;
		}
		else {
		?>
	<form action="objectifaccompli.php" method="POST">
		<table class="form_table">
			<tr>
				<th> Pourquoy consyd&eacute;rez-vous votre objectif comme atteynt&nbsp;?</th>
				<td><textarea name='argument'></textarea></td>
			</tr>			                	
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Soumettre" class='button' /></td>
			</tr>			
		</table>         
	</form>
		<?php
		}
	}
	?>
</div>    	
    		
<div id='evoluer'>
	
	<h3>Changer d'activit&eacute;</h3>

	<p class='attention'>
		D&eacute;clarer une nouvelle activit&eacute; aura pour cons&eacute;quence 
		d'annuler votre objectif actuel, sy vous en avez d&eacute;clar&eacute; un. De plus, l'Offyce 
		cessera de reconnaytre la source de vos revenus pr&eacute;c&eacute;dents : leur montant 
		d&eacute;clar&eacute; passera automatiquement &agrave; 0 <?=$cte->monnaie ?>. 
	</p>

	<p class='aide'>
		L'Offyce ne pratique aucune discriminatyon : toutes les activit&eacute;s sont
		susceptibles d'&ecirc;tre reconnues. L'essentiel est que votre d&eacute;claratyon refl&egrave;te vos
		pratiques r&eacute;elles. Libre &agrave; vous de d&eacute;clarer &ecirc;tre un riche 
		arystocrate, tant que vous vous comportez comme tel.
	</p>
	
	<div id="changer_activite">
		<form action="changeractivite.php" method="POST">
			<table class="form_table">
				<tr>
              	<th> Nouvelle activit&eacute; </th>
              	<td><input type="text" name="activite" /></td>
				</tr>
				<tr>
             	<td>&nbsp;</td>
              	<td><input type="submit" value="Envoyer" class='button' /></td>
				</tr>
			</table>
		</form>
	</div>
	
</div>

<?php
clyo::foot() ;
?>
