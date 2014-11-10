<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,"root") ;

clyo::head() ;

?>

<h2>Gestyon des droits adminystratifs</h2>

<div>
	<h3>Lyste des IP</h3>
<?php
$personne = new personne;
$personne->select("ORDER BY nom,prenom");
?>
	<table id='liste_ip'>
		<tr>
			<th>Nom</th>
			<th>Derni&egrave;re Connexion</th>
			<th>IP</th>
		</tr>
<?php
$i=0 ;
while($personne->next()){
	if (bcmod($i, '2') == '0') $typ = "class='pair'" ;
   	else $typ = "class='impair'" ;
 	$i++ ;
	echo "		<tr $typ>\n";
	echo "			<td>$personne->nom $personne->prenom</td>\n";
	echo "			<td>$personne->lastc</td>\n";
	echo "			<td>$personne->ip</td>\n";
	echo "		</tr>\n";
}
?>
	</table>
</div>

<?php
clyo::foot() ;
?>
