<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,"doge") ;

clyo::head() ;

$proches = new personne;
$proches->select("WHERE type=2 ORDER BY nom ASC");
?>

<h2>Allocatyon des postes</h2>

<div>
	<table id="liste_services_publics">
		<tr>
			<th>Nom</th>
			<th>Attribu&eacute; &agrave;</th>
			<th>C&eacute;der &agrave;</th>
		</tr>
<?php
$i = 0 ;
while($proches->next()){
	if (bcmod($i, '2') == '0') $typ = "class='pair'" ;
    else $typ = "class='impair'" ;
 	$i++ ;
	echo "		<tr $typ>\n";
	/*$photo = ($proches->photo <> "") ? $proches->photo : "../images/nophoto.gif";
	echo "			<td><img src=\"".$photo."\" alt='Photo' /></td>\n";*/
 	echo "			<td>".$proches->nom."</td>\n";
	echo "			<td>";
	if($proches->proprietaire>=1){
		$proprio = new personne;
		$proprio->get($proches->proprietaire);
		if ($proprio->type == 0) echo "<span class='nom'>".$proprio->nom."</span>";
		else echo $proprio->nom ;
	}
	else echo "Inactif";
	echo "</td>\n";
	echo "			<td>\n";
	echo "				<form action=\"conseiladmin2.php\" method=\"post\">\n";
	echo "					<select name=\"dest\">\n";
	echo "						<option value=\"0\">D&eacute;sactiver</option>\n";
	personne::list_options("WHERE num<>$proches->num") ;
	echo "					</select>\n";
	echo "					<input type=\"hidden\" name=\"clone\" value=\"".$proches->num."\" />\n";
	echo "					<input type=\"submit\" value=\"C&eacute;der\" />\n";
	echo "				</form>\n";
	echo "			</td>\n";
	echo "		</tr>\n";
}
?>
	</table>
</div>

<div>
	<h3>Cr&eacute;er un Poste</h3>
	<form action="./creerposte.php" method="post">
		<table class="form_table">
        	<tr>
        		<th> Intitul&eacute; </th>
        		<td><input type="text" name="nom" /></td>
        	</tr>
        	<tr>
        		<th> Statut : </th>
        		<td>Sevyce Public<input type="hidden" name="statut" value="2" /></td>
			</tr>
			<tr>
				<th> Ville d'affectatyon </th>
 				<td>
 					<select name="cte">
<?php
$cte = new cte;
$cte->select("WHERE mere=0");
while($cte->next()){
  	echo " 						<option value=\"".$cte->num."\">".$cte->nomc."</option\n>";
}
?>
 					</select>
 				</td>
 			</tr>
			<tr>
				<td><input type='hidden' name='redirection' value='../me/makeaclone2.php'/></td>
 				<td><input type="submit" value="Cr&eacute;er" class='button' /></td>
			</tr>
		</table>         
	</form>
</div>

<?php
clyo::foot() ;
?>
