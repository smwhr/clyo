<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
droit::check($p,"root");

clyo::head() ;

?>

<h2>Gestyon des droits adminystratifs</h2>

<div>
	<h3>Droits dystribu&eacute;s</h3>
	<dl class="liste_droit">
<?php
$droits = new droit;
$droits->select();
    while($droits->next()){
        echo "	<dt>".$droits->nom."</dt>\n";
        $possed = new poss_droit;
        $possed->select("WHERE droit=$droits->num");
        while($possed->next()){
            $personne = new personne;
            $personne->get($possed->personne);
            if ($personne->type == 0) echo "	<dd>".$personne->prenom." <span class='nom'>".$personne->nom."</span>" ;
            else echo "	<dd>".$personne->nom ;
            echo " [<a href='admindroit2.php?action=retirer&droit=".$droits->num."&amp;personne=".$personne->num."'>Retirer</a>]\n";
            echo "</dd>\n";
        }
    }
?>            
	</dl>
</div>

<div>
	<h3>Allouer un droit</h3>
	<form action="admindroit2.php" method="get">
		<table class="form_table">
			<tr>
				<th>Droit</th>
				<td>
					<select name="droit">
<?php
$droits = new droit;
$droits->select();
while($droits->next()){
	echo "						<option value=\"".$droits->num."\">";
   echo $droits->nom;
  	echo "</option>\n" ;
}
?>
 					</select>
 	 			</td>
			</tr>
			<tr>
				<th>Personne</th>
				<td>
					<select name="personne">
<?php
personne::list_options() ;
?>
					</select>
				</td>
			</tr>
			<tr>
 				<td><input type="hidden" name="action" value="allouer" /></td>
				<td><input type="submit" value="Allouer" class='button' /></td>
			</tr>
		</table>
	</form>
</div>

<div>
	<h3>Cr&eacute;er un droit</h3>
	<form action="admindroit2.php" method="get">
		<table class="form_table">
			<tr>
				<th>Droit</th>
				<td><input type="text" name="droit" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="action" value="creer" /></td>
				<td><input type="submit" value="Cr&eacute;er" class='button' /></td>
 			</tr>
		</table>
	</form>
</div>

<?php

clyo::foot() ;

?>
