<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p, "root") ;

clyo::head() ;

?>

<h2>Mettre &agrave; jour Clyo</h2>
<div>
	<h3>Mettre &agrave; jour Clyo</h3>
	<form action="update.php" method="post">
		<table class="form_table">
			<tr>
				<th>Confirmer</th>
				<td><input type="checkbox" name="confirm" class='checkbox' /></td>
			</tr>
        		<td>&nbsp;</td>
        		<td><input type="submit" value="Go !" class='button' /></td>
			</tr>
		</table>
	</form>
</div>
<?if(extraction("confirm")):?>
<div>
    <h3>R&eacute;sultat de la mise-&agrave;-jour</h3>
    <div>
    <pre>
        Mise-&agrave;-jour non effectu&eacute;e.
    </pre>
    </div>
</div>
<?endif;?>
<?php
clyo::foot() ;
?>
