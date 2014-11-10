<?php

require_once('../inc/centrale.php') ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

function print_error($case){
	clyo::head() ;
	echo "<h2>Erreur rencontr&eacute;e</h2>\n<div>\n" ;
    switch($case){
    case 1 :
        echo "Nom ind&eacute;f&eacute;ni";
        break;
    case 2 :
        echo "Email invalide";
        break;
    case 3 :
        echo "Communaute invalide";
        break;
    case 4 :
        echo "Statut invalide";
        break;
    case 5 :
        echo "Il y a d&eacute;j&agrave; une personne inscrite &agrave; ce nom";
        break;
    case 6 :
        echo "Il y a d&eacute;j&agrave; une personne inscrite avec cet email.";
        break;
    case 7 :
        echo "Vous devez &ecirc;tre Doge pour cr&eacute;er un Servyce Public.";
        break;
	case 8 :
        echo "Tout citoyen se doyt de dysposer d'un sexe !";
        break;
    case 9 :
        echo "Pr&eacute;nom invalide";
        break;
    }
    echo "<br /><a href=\"./makeaclone.php\">Retour</a>";
    echo "\n</div>\n" ;
    clyo::foot() ;
    die() ;
}

if (!extraction("prenom")) $prenom = "" ;
extraction("nom") or print_error(1) ;
if (!(extraction("email") &&  preg_match('/^[A-z0-9_\-\.]+\@([A-z0-9_\-\.]+\.)+[A-z]{2,4}$/', $email))) $email = "" ;
extraction("cte") or print_error(3) ;
extraction("statut") or print_error(4) ;
if ($prenom == "" && $statut==0) print_error(9) ; 
if ($sexe == "" && $statut==0) print_error(8) ; 
if(!extraction("sexe")) $sexe = ""; 
if(!extraction("redirection")) $redirection = "../me/clones.php" ;

if($statut == 2){
    droit::hasgot($p,"doge") or print_error(7);
}

$clone = new personne;
$clone->select("WHERE nom='$nom' AND prenom='$prenom' ;") ;
if($clone->lenen()>=1) print_error(5);

$clone->select("WHERE email='$email'");
if(($clone->lenen()>=1)&&($email<>"")) print_error(6);

unset($clone) ;
$clone = new personne ;
$clone->num = 0 ;
$clone->nom = $nom ;
$clone->prenom = $prenom ;
$clone->email = $email;
$clone->cte = $cte;
$clone->sexe = $sexe;
$clone->type = $statut;
$clone->proprietaire = $p->num;
$clone->create_personne() ;
if($clone->save()) redirect($redirection);
else echo "Une erreur est apparue. Veuillez soumettre une nouvelle demande dans quelques minutes";

?>
