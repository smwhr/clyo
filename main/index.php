<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("toconnect.php");

clyo::head() ;

?>

<h2>Page d'accueil</h2>    
    
<?php
/*
<div id="news">
	<h3>Derni&egrave;res nouvelles</h3>
</div>
*/
?>
        
<div id="profil_sommaire">
	<h3>Vous</h3>
<?php
$photo = ($p->photo <> "") ? $p->photo : "../images/nophoto.gif";
?>
	<div id='profil_photo'>
		<img src="<?echo $photo;?>" />
	</div>
	<div id='profil_infos'>
		<dl>
			<dt>Nom</dt>
			<dd><?php echo $p->prenom." ".$p->nom ; ?></dd>
			
			<dt>Statut</dt>
			<dd><?=$p->statut() ?></dd>
 		</dl> 	
 	</div>
</div>
        
<div id="comptes">
	<h3>Relev&eacute; bancaire</h3>
<?php
$p->list_accounts() ;
?>
 </div>
        
<div id="clones">
	<h3>Se connecter sous une autre identyt&eacute;</h3>
<?php
$aunproprio = 0 ;
if($p->proprietaire <> 0) $aunproprio = 1 ;

$proches = new personne;
$proches->select("WHERE proprietaire=$p->num ORDER BY nom,prenom ASC");
if(($proches->lenen() + $aunproprio)==0){
        echo "	<em>Vous n'avez pas d'autres identyt&eacute;s</em>";
}
else{
    echo "	<form method=\"POST\" action=\"../main/reconnect.php\">\n";
    echo "		<table class=\"form_table\">\n";
    echo "			<tr>\n";
    echo "				<th>Nom</th>\n";         
    echo "				<td>\n";        
    echo "					<select name='personum'>\n";
    if ($aunproprio == 1) {
    	$proprietaire = new personne;
    	$proprietaire->get($p->proprietaire);
    	echo "						<optgroup label='Propri&eacute;tayre'>\n" ;
    	echo "							<option value='".$proprietaire->num."'>".$proprietaire->nom.", 
".$proprietaire->prenom."</option>\n";
    	echo "						</optgroup>\n" ;
    }
    personne::list_options("WHERE proprietaire=$p->num") ;
   /* while($proches->next()){
    echo "<option value=\"$proches->num\">".$proches->nom.", ".$proches->prenom."</option>";
    }*/
    echo "					</select>\n";
    echo "				</td>\n";
    echo "			</tr>\n		<tr>\n" ;
    echo "				<td>&nbsp</td>\n" ;      
    echo "				<td>\n";
    echo "					<input type='submit' class='button' value='Se connecter' />";
    echo "				</td>\n";
    echo "			</tr>\n";
    echo "		</table>\n";
    echo "	</form>";
}
?>

</div>

<?php
clyo::foot() ;
?>
