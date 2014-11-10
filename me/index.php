<?php
require_once("../inc/centrale.php");

$p = new personne;
$connecte = $p->secure() ;

$moi = new personne;

if(isset($_GET['num'])){
	$moi->get($_GET['num']) ;
	if (!$moi->num) redirect("../politics/registre.php");
}
else {
	if ($connecte)  $moi->get($p->num) ;
	else redirect("../main/toconnect.php");
}

clyo::head() ;
?>

<h2>Fiche d'identit&eacute;</h2>
<?php
$photo = ($moi->photo <> "") ? $moi->photo : "../images/nophoto.gif";
$site = ($moi->url <> "") ? "[<a href=\"".$moi->url."\">Syte</a>]" : "";
$cte=new cte;
$cte->get($moi->cte);
?>

<div id="profil_sommaire">
	<div id='profil_photo'>
		<img class="imgprofil" src="<?echo $photo;?>" alt="Photo" />
	</div>    
	<div id="profil_infos">
		<dl>
			<dt>Nom</dt>
			<dd class='nom'><?php echo $moi->nom;?></dd>
			
			<?php
			if ($moi->type == 0) {
				?>
			<dt>Pr&eacute;nom</dt>
   		<dd><?echo $moi->prenom;?></dd>
				<?php
			}
			?>
			
			<dt>Statut</dt>
			<dd><?echo $moi->statut();?></dd>

			<?php
			if ($connecte && ($moi->email <> "" || $moi->type>0)) {
			?>
			<dt>Adresse &eacute;l&eacute;ctronique</dt>
   		<dd><address><a href='mailto:<?echo $moi->courriel();?>'><?echo $moi->courriel();?></a></address></dd>
				<?php
			}
			?>

 			<dt><?php echo ($moi->type > 0 ? "Sy&egrave;ge" : "Domicile") ;?></dt>
			<dd><?php echo $moi->adresse() ; ?></dd>
			
						<dt>Ville d'origine</dt>
			<dd class='ville'><?echo $cte->nomc;?></dd


			<dt>Activit&eacute;</dt>
	<?php
	$travail = new activite;
	$travail->charge($moi);
	$travail->next();
	?>
			<dd><?echo ucfirst($travail->activite);?></dd>

<?php            
if($moi->type==0){
	?>
			<dt>Date de naturalisatyon</dt>
			<dd><?echo mysqldb::ysdate($moi->naturalisation) ;?></dd>

	<?php        
	if ($moi->bio <> "") {
		echo "			<dt>Biographie</dt>\n" ;
		echo "			<dd>".$moi->bio."</dd>\n" ;
	}
}
else {
	?>
	
			<dt>Dirig&eacute; par</dt>
	<?php
	$proprio = new personne;
	$proprio->get($moi->proprietaire);
	?>            
			<dd><a href='../me/index.php?num=<?php echo $proprio->num ; ?>'><?php echo $proprio->prenom." ".$proprio->nom ; ?></a></dd>
            
            
	<?php
	if ($moi->bio <> "") {
		echo "			<dt>Descriptyon</dt>\n" ;
		echo '			<dd>'.$moi->bio."</dd>\n" ;
	}
}

if($moi->url<>""){
	?> 
			<dt>Syte internet</dt>
			<dd><a href="<?echo $moi->url;?>"><?echo $moi->url;?></a></dd>
				
	<?php
}
if($moi->msn <> ""){
	?>
	
			<dt>Messagerie instantan&eacute;e</dt>
			<dd><?php echo $moi->msn ;?></dd>
	<?php
}
?>
		</dl>
	</div>  
      
	<div id='joli'>
		Vous n'auriez jamais d&ucirc; voir &ccedil;a
	</div>
</div>

<?php
clyo::foot() ;
?>
