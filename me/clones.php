<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

function affiche($type) {
	global $p ;
	$text = array("Citoyens","Entrepryses","Services publics") ;
	$proches = new personne;
	$proches->select("WHERE proprietaire=".$p->num." AND type='".$type."'ORDER BY nom ASC");
	if ($proches->lenen() > 0) {
	?>
	<h3><?php echo $text[$type] ; ?></h3>
	<table class="liste_perso_complete">
		<tr>
			<th>&nbsp;</th>
			<th>Nom</th>
         <?php if($proches->type<>2) echo '<th>C&eacute;der &agrave;</th>' ; ?> 
		<th>
	<?php
	$i=0 ;
   while($proches->next()){
    	if (bcmod($i, '2') == '0') $type = "class='pair'" ;
    	else $type = "class='impair'" ;
    	$i++ ;
      echo "		<tr $type>\n";
      $photo = ($proches->photo <> "") ? $proches->photo : "../images/nophoto.gif";
      echo "			<td class='photo'><img src=\"".$photo."\" alt='Photo' /></td>\n";
		if ($proches->type == 0) echo "			<td><span class='nom'>".$proches->nom."</span>, ".$proches->prenom."</td>\n";      
      else echo "			<td>".$proches->nom." ".$proches->prenom."</td>\n";
		if($proches->type<>2){
			echo "			<td>\n";
			echo "				<form action=\"cederclone.php\" method=\"POST\">\n";
         echo "					<select name=\"dest\">\n";
         personne::list_options("WHERE num<>$p->num AND num<>$proches->num") ;
         echo "					</select>\n";
         echo "            	<input type=\"hidden\" name=\"clone\" value=\"".$proches->num."\">\n";
         echo "            	<input type=\"submit\" value=\"C&eacute;der\">\n";
         echo "            </form>\n";
         echo "			</td>\n";
	   }
      echo "		</tr>\n";
    }
	 ?>
        </table>
<?php
	}
}

clyo::head() ;

?>

<h2>Lyste de vos proches</h2>

<div id='proches'>

<?php
affiche(0) ;
affiche(1) ;
affiche(2) ;
?>

</div>

<?php
clyo::foot() ;
?>
