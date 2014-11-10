<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;

extraction("bien") or redirect("./biens.php");
$terrain = new terrain;
$terrain->get($bien);
if($terrain->proprietaire <> $p->num) redirect("./biens.php");
?>
<h2>Modifier un bien</h2>

<div>
	<h3>Caract&ecute;rystiques</h3>
	En entrant un loyer sup&eacute;rieur &agrave; 0, vous mettez implicitement 
	votre logement en locatyon. Il appara&icirc;tra donc dans la lyste des 
	petites annonces. De m&ecirc;me en entrant 0, vous expulsez implicytement 
	votre locatayre actuel.        	   
	<form action="modifbien2.php" method="POST">
		<table class="form_table">
  			<tr>
				<th> Nom </th>
 				<td><input type="text" name="nom" value="<?echo $terrain->nom;?>" /></td>
 			</tr>
			<tr>
				<th> Adresse </th>                		
				<td><?echo $terrain->adresse() ;?></td>
			</tr>
			<tr>
				<th> Photo </th>
				<td><input type="text" name="photo" value="<?echo $terrain->photo;?>" /></td>
			</tr>
			<tr>
				<th> Descriptyon </th>
				<td><textarea name="description"><?echo $terrain->description;?></textarea></td>
			</tr>
			<tr>
				<th> Loyer </th>
    			<td><input type="text" name="loyer" value="<?echo $terrain->loyer;?>" /><?echo $ville->monnaie;?></td>
 			</tr>
			<tr>
				<td><input type="hidden" name="bien" value="<?echo $terrain->num;?>"  /></td>
				<td><input type="submit" value="Modifier" class='button' /></td>
			</tr>
		</table>         
	</form>
</div>

<div>
	<h3>C&eacute;der ce bien</h3>
	<form action="cederbien.php" method="post">
		<table class="form_table">
  			<tr>
				<th> Heureux b&eacute;n&eacute;ficiayre </th>
				<td>
					<select name="dest">
						<?php
						personne::list_options("WHERE num<>$p->num") ;
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="bien" value="<?php echo $terrain->num; ?>" /></td>
				<td><input type="submit" value="C&eacute;der" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<div>
	<h3>Mettre en vente ce bien</h3>
<?php
$annonce = new petite_annonce;
$annonce->select("WHERE terrain=$terrain->num");
if($annonce->lenen()==0){
	?>
	<form action="annoncerbien.php" method="post">
		<table class="form_table">
  			<tr>
				<th> Prix de vente </th>
				<td><input type="text" name="prix" value="1000" />&nbsp;<?php $cte = new cte ; $cte->get($p->cte);echo $cte->monnaie ; ?></td>
			</tr>
			<tr>
				<td><input type="hidden" name="bien" value="<?php echo $terrain->num; ?>" /></td>
				<td><input type="submit" value="Mettre en vente" class='button' /></td>
			</tr>
		</table>
	</form>
	<?php
}
else{
	echo "<form action=\"annoncerbien.php\" method=\"POST\">";
	echo "<em>Ce bien est actuellement &agrave; la vente.</em>";
	echo "<input type=\"hidden\" name=\"bien\" value=\"".$terrain->num."\" />";
	echo "<input type=\"submit\" value=\"Le retirer\">";
	echo "</form>";
}
?>
</div>

<?php
clyo::foot() ;
?>