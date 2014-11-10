<?php
require_once("../inc/centrale.php") ;

$p = new personne;
if($p->secure()) redirect("index.php");

clyo::head("exterieur") ;

$referer = str_replace("404.php", "index.php", $_SERVER['HTTP_REFERER']) ;

?>

<h2>Connexion</h2>

<form method="post" action="../connect.php">
	<table>
		<tr>
			<th>Adresse &eacute;l&eacute;ctronique</th>
			<td><input name="email" type="text" value="<?echo isset($_COOKIE['email']) ? $_COOKIE['email'] : "" ;?>" /></td>
		</tr>
		<tr>
			<th>Mot de passe</th>
			<td><input  type="password" name="password" /></td>
		</tr>
		<tr>
			<th>Se souvenir de moi</th>
			<td><input name="souvenir" type="checkbox" class="checkbox" /></td>
		</tr>
		<tr>
			<td><input name="referer" value="<?echo $referer ;?>" type="hidden" /></td>
			<td><input value="Se connecter !" type="submit" class='button' /></td>
		</tr>
	</table>
</form>
	
<h2>Inscription</h2>
<p>Vous n'avez pas encore de compte sur Clyo&nbsp;? <a href="../me/sinscrire.php">Inscrivez-vous maintenant&nbsp;!</a></p>

<?php
clyo::foot() ;
?>
