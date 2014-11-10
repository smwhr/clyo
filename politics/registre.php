<?php
require_once("../inc/centrale.php");

$p = new personne;
$connecte = $p->secure() ;

$t = isset($_GET['t']) ? $_GET['t']%3 : 0;
$personne = new personne;
$requete = "WHERE type=$t";
$requete .= ($t==2) ? " AND proprietaire<>0" : "" ;
$requete .= " ORDER BY nom ASC";

$personne->select($requete);

$mot = array("Annuayre yssois", "Regystre du commerce", "Lyste des services publics") ;
$mot2 = array("Nom, pr&eacute;nom", "Entrepryse", "Service public") ;

clyo::head() ;

?>
<h2><?php echo $mot[$t] ;?></h2>

<div>
	<table class="liste_perso_complete">
<?php
/*
		<tr>
			<th>Photo</th>
			<th><?php echo $mot2[$t] ; ?></th>
		</tr>
*/
$i = 0 ;
$lettre = "" ;
while($personne->next()){
	if ($lettre <> ucfirst($personne->nom[0])) {
		$lettre = ucfirst($personne->nom[0]) ;
		?>
		<tr>
			<th><?php echo $lettre ; ?></th>
			<th>&nbsp;</th>
		</tr>
		<?php
	}
   if (bcmod($i, '2') == '0') $type = "class='pair'" ;
   else $type = "class='impair'" ;
   $i++ ;
	echo "		<tr $type>\n";
	$photo = ($personne->photo <> "") ? $personne->photo : "../images/nophoto.gif";
	echo "			<td class='photo'><img src=\"".$photo."\" alt='photo indisponible' /></td>\n";
	$nom = "<a href=\"../me/index.php?num=$personne->num\">".($personne->type > 0 ? $personne->nom : "<span class='nom'>".$personne->nom."</span>, ".$personne->prenom)."</a>";
	$nom .= "<br />".$personne->adresse() ;
	if ($personne->type == 2) {
		$proprio = new personne;
		$proprio->get($personne->proprietaire);
		$nom .= "<br />dirig&eacute; par <a href=\"../me/index.php?num=$proprio->num\">".$proprio->prenom." ".$proprio->nom."</a>";
	}
	if ($connecte && ($personne->email <> "" || $personne->type>0)) $nom .= "<br />M&eacute;l&nbsp;: <address><a href='mailto:".$personne->courriel()."'>".$personne->courriel()."</a></address>" ;
	if ($personne->url <> "") $nom .= "<br /><a href='".$personne->url."'>Site internet</a>" ;
	echo "			<td>".$nom."</td>\n";
	echo "		</tr>";
}
?>
	</table>
</div>


<?php
clyo::foot() ;
?>
