<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;

if (extraction("compte") && extraction("confirmer")) {
	$c = new compte ;
	$c->get($compte) ;
	if (($confirmer == "on") && ($c->titulaire == $p->num) && ($c->principal == 0)) { 
		$c->delete() ;
		echo "<div>Compte supprim&eacute;</div>" ;
	}
	else {
		echo "<div>La suppression a &eacute;chou&eacute;e.</div>" ;
	}
	
}

?>
<h2>Soci&eacute;t&eacute; Yssoise de Banque</h2>

<div id="comptes">
	<h3>Lyste de vos comptes</h3>
<?php
$p->list_accounts() ;
?>
</div>

<div id="creer_un_compte">
	<h3>Cr&eacute;er un nouveau compte</h3>
	<form action="creercompte.php" method="POST">
		<table class="form_table">
			<tr>
				<th> Libell&eacute;</th>
				<td><input type="text" name="libelle" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Cr&eacute;er" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<div id='suppr_compte'>
	<h3>Supprimer un compte</h3>
	<p class='aide'>Vous ne pouvez pas supprimer le premier de vos comptes (compte principal). Le solde d'un compte doit &ecirc;tre nul pour pouvoir le supprimer.</p>
	<?php
	$c = new compte ;
	$c->select("WHERE titulaire='".$p->num."' AND solde='0' AND principal='0'") ;
	if ($c->lenen() > 0) {
	?>
	<form action="index.php" method="POST">
		<table class="form_table">
			<tr>
				<th>Compte </th>
				<td>
					<select name="compte">
						<?php
						while ($c->next()) {
							echo "					<option value='".$c->num."'>".$c->num." - ".$c->libelle."</option>\n" ;
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Confirmer</th>
				<td><input type='checkbox' name='confirmer' class='checkbox' /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Supprimer" class='button' /></td>
			</tr>
		</table>
	</form>
	<?php
	}
	else echo "	<p>Vous ne pouvez supprimer aucun compte.</p>\n" ;
	?>
</div>
<?php
clyo::foot() ;
?>
