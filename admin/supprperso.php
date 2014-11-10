<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,"root");

clyo::head() ;

?>

<h2>Supprimer quelqu'un</h2>

<div>
	<form action="supprperso2.php" method="post">
		<table class="form_table">
			<tr>
				<th>Personne &agrave; supprimer</th>
				<td>
 					<select name="personne">
<?php
personne::list_options() ;
?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Confirmer</th>
				<td><input type="checkbox" name="confirm" value="ok" class='checkbox' />
			</tr>
			<tr>
				<td>&nbsp;</td>   
				<td><input type="submit" value="Supprimer" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<?php
clyo::foot() ;
?>
