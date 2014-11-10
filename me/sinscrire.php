<?php
require_once("../inc/centrale.php") ;

clyo::head("exterieur") ;

?>
<h2>S'enregistrer sur Clyo</h2>
		
<form method="POST" action="./sinscrire2.php">
	<table>
		<tr>
			<th> Pr&eacute;nom</th>
			<td><input type="text" name="prenom" /></td>
		</tr>
		<tr>
			<th> Nom </th>
			<td><input type="text" name="nom" /></td>
		</tr>
		<tr>
			<th> Adresse &eacute;l&eacute;ctronique</th>
			<td><input type="text" name="email" /></td>
		</tr>
		<tr>
			<th> Sexe </td>
			<td>
				<select name="sexe">
		        	<option value="f">Femme</option>
		        	<option value="m">Homme</option>
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
	echo "					<option value=\"".$cte->num."\">".$cte->nomc."</option>\n";
}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th> Mot de passe</th>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<th> R&eacute;p&eacute;tez </th>
			<td><input type="password" name="password2" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="Soumettre" class='button' /></td>
		</tr>
	</table>	
</form>

<p>Votre adresse email doit &ecirc;tre valide, des informations importantes y seront envoy&eacute;es et elle servira &agrave; votre identificatyon.<br />
Nous vous recommandons de <a href="http://mail.yahoo.fr/">cr&eacute;er une nouvelle adresse email</a> pour votre personnage.<br />
Attentyon ! Sy vous &ecirc;tes d&eacute;j&agrave; inscrit &agrave; Clyo sous une autre identit&eacute; utilisez le formulaire de cr&eacute;atyon de proches afin de ne pas &ecirc;tre accus&eacute; de tentative de fraude.</p>

<p><a href="../index.php">Retour</a></p>
	
<?php
clyo::foot() ;
?>