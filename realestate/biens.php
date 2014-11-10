<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;
?>

<h2>Vos byens</h2>

<div>
	<h3>Choisir votre domicyle princypal</h3>
<?php
$bien = new terrain;

echo "	<form method=\"POST\" action=\"./sedomicilier.php\">\n";
echo "		<table class=\"select_form\">\n";
echo "			<tr>\n";        
echo "				<td>\n";        
echo "					<select name=\"bien\">\n";

/*if($p->domicile<>0){
	echo "					<option value=\"$p->domicyle\">";
    $p->adresse(false) ;
    echo "</option>\n";
}*/

$bien->select("WHERE proprietaire=$p->num OR locataire=$p->num AND num<>$p->domicile ORDER BY nom ASC");
while($bien->next()){
	if ($bien->num == $p->domicile) echo "						<option value=\"$bien->num\" selected='selected'>";
	else echo "						<option value=\"$bien->num\">";
    echo $bien->adresse(false) ;
    if ($bien->num == $p->domicile) echo " (actuel)" ;
    echo "</option>\n";
}
$cte = new cte;
$cte->get($p->cte);
if ($p->domicile == 0) echo "						<option value='0' selected='selected'>\n";
else echo "						<option value=\"0\">";
echo $cte->cdomicile." (d&eacute;faut)";
echo "</option>\n";
echo "					</select>\n";
echo "				</td>\n";            
echo "				<td>\n";
echo "					<input type=\"submit\" value=\"Se domicilier\" />\n";
echo "				</td>\n";
echo "			</tr>\n";
echo "		</table>\n";
echo "	</form>";

?>

</div>

<div>
	<h3>Vos possessyons</h3>
<?php
$bien = new terrain;
$bien->select("WHERE proprietaire=$p->num ORDER BY nom ASC");

if ($bien->lenen() > 0) {
?>

	<table class="liste_biens">
		<tr>
			<th>&nbsp;</th>
			<th class='adresse'>Adresse</th>
			<th>Lou&eacute; &agrave;</th>
			<th>Actyon</th>
		</tr>
<?php
$i=0 ;
while($bien->next()){
	if (bcmod($i, '2') == '0') $type = "class='pair'" ;
	else $type = "class='impair'" ;
	$i++ ;
	echo "		<tr $type>\n";
	$photo = ($bien->photo <> "") ? $bien->photo : "../images/nophoto.gif";
	echo "			<td class='photo'><img src=\"".$photo."\" alt='photo indysponible'/></td>\n";
	echo "			<td>".$bien->nom."<br />";
	echo $bien->adresse() ;
	echo "</td>\n";
	echo "			<td>";
	if($bien->locataire<>0){
		$locataire = new personne;
		$locataire->get($bien->locataire);
		echo "<a href=\"../Moi/index.php?num=$locataire->num\">";
		if ($locataire->type == 0) echo  $locataire->prenom." <span class='nom'>".$locataire->nom."</span>";
		else echo $locataire->nom ;
		echo "</a>";
	}
	else{
		echo "<em>personne</em>";
    }
	echo "</td>\n";
	echo "			<td>\n";
	echo "				<form action=\"modifbien.php\" method=\"POST\" />\n";
	echo "					<input type=\"hidden\" name=\"bien\" value=\"".$bien->num."\" />\n";
	echo "					<input type=\"submit\" value=\"&Eacute;diter\" />\n";
	echo "				</form>\n";
	echo "			</td>\n";
	echo "		</tr>\n";
}
?>

	</table>
	
<?php
}
else echo "Vous ne poss&eacute;dez ryen pour l'instant." ;
?>


</div>

<div>
            <h3>Vos locatyons</h3>
<?
$bien = new terrain;
$bien->select("WHERE locataire=$p->num");

if ($bien->lenen()) {
?>
        <table class="liste_biens">
            <tr><th>&nbsp;</th><th>Nom</th><th>Adresse</th><th>Loyer</th><th>D&eacute;m&eacute;nager</th></tr>
<?
$i=0 ;
    while($bien->next()){
	if (bcmod($i, '2') == '0') $type = "class='pair'" ;
	else $type = "class='impair'" ;
	$i++ ;
	echo "		<tr $type>\n" ;
        $photo = ($bien->photo <> "") ? $bien->photo : "../Images/nophoto.gif";
                echo "<td class='photo'><img src=\"".$photo."\" /></td>";
                echo "<td>".$bien->nom."</td>";
                echo "<td>";
                echo $bien->adresse() ;
                echo "</td>";
                echo "<td>";
                echo "$bien->loyer $cte->monnaie";
                echo "</td>";
                echo "<td>";
    if($p->domicile <> $bien->num){
                    echo "<form action=\"quitterlocation.php\" method=\"POST\">";
                    echo "<input type=\"hidden\" name=\"bien\" value=\"".$bien->num."\">";
                    echo "<input type=\"submit\" value=\"Quitter\">";
                    echo "</form>";
    }else{
                    echo "Domicyle Princypal";
    }
                echo "</td>";
            echo "</tr>";
    }
?>

        </table>
<?php
}
else echo "Vous ne louez ryen pour le moment." ;
?>

        </div>
<?php
clyo::foot() ;
?>
