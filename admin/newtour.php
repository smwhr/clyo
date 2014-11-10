<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p, "root") ;

clyo::head() ;

?>
<h2>Nouveau tour</h2>
<div>
	<h3>D&eacute;clencher un tour</h3>
	<form action="newtour2.php" method="post">
		<table class="form_table">
			<tr>
				<th>Confirmer</th>
				<td><input type="checkbox" name="confirm" class='checkbox' /></td>
			</tr>
        		<td>&nbsp;</td>
        		<td><input type="submit" value="D&eacute;clencher" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<?php
clyo::foot() ;
?>
