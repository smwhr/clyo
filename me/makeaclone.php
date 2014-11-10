<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;

?>
<h2>Cr&eacute;er un proche</h2>

<div>
	<form action="makeaclone2.php" method="POST">
		<table class="form_table">
			<tr>
				<th> Nom </th>
				<td><input type="text" name="nom" /></td>
			</tr>	
			<tr>
				<th> Pr&eacute;nom* </th>
				<td><input type="text" name="prenom" /></td>
			</tr>
			<tr>
				<th> Adresse &eacute;l&eacute;ctronique** </th>
				<td><input type="text" name="email" /></td>
			</tr>
			<tr>
				<th> Sexe* </th>
				<td>
		 			<select name="sexe">
						<option value="" >&nbsp;</option>
						<option value="f">Femme</option>
						<option value="m">Homme</option>
		    		</select>
				</td>
			</tr>
			<tr>
				<th> Statut </th>
				<td>
		    		<select name="statut">
						<option value="0">Citoyen</option>
						<option value="1">Entrepryse</option>
<?php
if(droit::hasgot($p,"doge")){
	echo "						<option value=\"2\">Servyce public</option>\n";
}
?>
			   	</select>
				</td>
			</tr>
			<tr>
				<th> Ville </th>
				<td>
					<select name="cte">
<?php
$cte = new cte;
$cte->select("WHERE mere=0");
while($cte->next()){
	echo "						<option value=\"".$cte->num."\">".$cte->nomc."</option>\n";
}
?>
		    		</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Cr&eacute;er" class='button' /></td>
			</tr>
		</table>	 
	</form>
	
	<p>* champ inutile pour les non-citoyens<br />
	** champ facultatif</p>
</div>

<?php
clyo::foot() ;
?>
