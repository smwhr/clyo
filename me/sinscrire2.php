<?php

require_once('../inc/centrale.php') ;


function print_error($case){
    switch($case){
    case 0 :
        echo "Prenom undefined";
        break;
    case 1 :
        echo "Nom undefined";
        break;
    case 2 :
        echo "Email invalide";
        break;
    case 3 :
        echo "Communaute undefined";
        break;
    case 31 :
        echo "Sexe incorrect";
        break ;
    case 4 :
        echo "Mot de passe incorrect";
        break;
    case 5 :
        echo "Il y a d&eacute;j&agrave; une personne inscrite &agrave; ce nom";
        break;
    case 6 :
        echo "Il y a d&eacute;j&agrave; une personne inscrite avec cet email";
        break;    
    }
    echo "<br /><a href=\"./sinscrire.php\">Retour</a>";
    exit;
}

extraction("prenom") or print_error(0) ;
extraction("nom") or print_error(1) ;
(extraction("email") and  preg_match('/^[A-z0-9_\-\.]+\@([A-z0-9_\-\.]+\.)+[A-z]{2,4}$/', $email)) or print_error(2) ;
extraction("cte") or print_error(3) ;
extraction("sexe") or print_error(31) ;
if (extraction("password","password2") && ($password==$password2)) $password = md5($password) ;

$p = new personne;
$p->select("WHERE nom='$nom' AND prenom='$prenom' ;") ;
if($p->lenen()>=1) print_error(5);

$p->select("WHERE email='$email'");
if($p->lenen()>=1) print_error(6);

unset($p) ;

$p= new personne ;
$p->nom = $nom ;
$p->prenom = $prenom ;
$p->email = $email;
$p->password = $password;
$p->cte = $cte;
$p->sexe = $sexe;
$p->create_personne() ;

if($p->save()){
	session_start();
	$_SESSION['clyoident']=$p->num;
	redirect("../main/index.php");
	echo "Vous &ecirc;tes correctement enregistr&eacute;.<br /><a href=\"../Main/toconnect.php\">Se Connecter de suite !</a>" ;

}
else{
	echo "Une erreur est apparue. Veuillez soumettre une nouvelle demande dans quelques minutes.";
}


?>
