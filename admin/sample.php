<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,'doge') ;
clyo::head() ;

?>

<h2>Titre de la page</h2>

<div>
	<h3>Titre de la section</h3>
</div>

<?php
clyo::foot() ;
?>
