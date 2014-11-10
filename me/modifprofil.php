<?php

require_once("../inc/centrale.php");


$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;

?>

<h2>Modifier mon profil</h2>

<div>
	<form action="modifprofil2.php" method="post">
		<table class="form_table">
			<tr>
				<th> Nom</th>
				<td><?echo $p->nom;?></td>
			</tr>
			<tr>
				<th> Pr&eacute;nom</th>
				<td><?echo $p->prenom;?></td>
			</tr>
			<tr>
				<th> Adresse</th>
				<td><?echo $p->adresse() ;?> [<a href="../realestate/biens.php">Changer</a>]</td>
			</tr>
			<tr>
				<th> Photo</th>
				<td><input type="text" name="photo" value="<?echo $p->photo;?>" /></td>
			</tr>
			<tr>
				<th> Syte internet</th>
				<td><input type="text" name="url" value="<?echo $p->url;?>" /></td>
			</tr>
  			<tr>
				<th> Adresse &eacute;l&eacute;ctronique</th>
 				<td><input type="text" name="email" value="<?echo $p->email;?>" /></td>
			</tr>
			<tr>
				<th> Adresse MSN</th>
  				<td><input type="text" name="msn" value="<?echo $p->msn;?>" /></td>
			</tr>
			<tr>
				<th> Biographie</th>
				<td><textarea name="bio"><?echo $p->bio;?></textarea></td>
 			</tr>
 			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" value="Modifier" class='button' /></td>
			</tr>
		</table>         
	</form>
</div>

<?php
clyo::foot() ;
?>
