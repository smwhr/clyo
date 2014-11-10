<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$cte = new cte ;
$cte->get($p->cte) ;

clyo::head() ;

?>

<h2>Soci&eacute;t&eacute; Yssoise de Banque</h2>

<div id="transaction">
	<h3>Passer une transaction</h3>
	<form action="transaction2.php" method="POST">
		<table class="form_table">
			<tr>
				<th>De</td>
				<td>
					<select name="from">
<?php
$compte = new compte;
$compte->select("WHERE titulaire=$p->num");
while($compte->next()){
	echo "						<option value='".$compte->num."'>".$compte->num." - ".$compte->libelle." (".$compte->solde." ".$cte->monnaie.")</option>\n";
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<th> Vers </th>
				<td>
					<select name="dest">
						<optgroup label='Mes comptes'>
<?php
$compte = new compte;
$compte->select("WHERE titulaire=$p->num ORDER BY num");
while($compte->next()){
	echo "<option value='".$compte->num."'>".$compte->num." - ".$compte->libelle." (".$compte->solde." ".$cte->monnaie.")</option>";
}
?>
						</optgroup>
						<optgroup label='Autres comptes'>
<?php
$compte = new compte;
$compte->select("WHERE titulaire<>$p->num ORDER BY num");
while($compte->next()){
	echo "<option value='".$compte->num."'>".$compte->num." - ".$compte->libelle."</option>";
}
?>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<th> Montant </th>
				<td><input type="text" name="montant" /></td>
			</tr>
			<tr>
				<th> Libell&eacute; </th>
 				<td><input type="text" name="libelle" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Ex&eacute;cuter" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<?php
clyo::foot() ;
?>
