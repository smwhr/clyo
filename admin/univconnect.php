<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,'root') ;

clyo::head() ;

?>

<h2>Gestyon des Droits Adminystratifs</h2>

<div>
	<h3>Connexyon Universelle</h3>
	<form action="../connect2.php" method="post">
  		<table class="form_table">
			<tr>
				<th>Personne</th>
				<td>
					<select name="personum">
<?php
personne::list_options() ;
?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Se connecter" /></td>
			</tr>
		</table>
	</form>
</div>

<?php
clyo::foot() ;
?>

