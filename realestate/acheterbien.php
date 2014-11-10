<?php
require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 1 :
        echo "Ce bien n'est pas &agrave; vendre.";
        break;
    case 2 :
        echo "Compte undefined";
        break;
    case 3 :
        echo "Ce compte ne vous appartient pas.";
        break;
    case 4 :
        echo "Vous n'avez pas assez d'argent pour cette transactyon.";
        break;
    }
    echo "<br /><a href=\"./index.php\">Retour</a>";
    exit;
}



$biennum = isset($_POST['bien']) ? $_POST['bien'] : print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$bien = new terrain;
$bien->get($biennum);

$annonce = new petite_annonce;
$annonce->select("WHERE terrain=$bien->num");
if($annonce->lenen()==0) print_error(1);
$annonce->next();

$comptenum = isset($_POST['compte']) ? $_POST['compte'] : print_error(2) ;

$compte = new compte;
$compte->get($comptenum);

if($compte->titulaire <> $p->num) print_error(3);
if($compte->solde < $annonce->prix) print_error(4);

$compte->solde = $compte->solde - $annonce->prix;
$compte->save();

$comptedest = new compte;
$comptedest->getprincipal($bien->proprietaire);
$comptedest->solde = $comptedest->solde + $annonce->prix;
$comptedest->save();

$transac = new transaction;
$transac->save_transaction("Achat du bien #".$bien->num,$compte->num,$compte->dest,$annonce->prix);

$bien->proprietaire = $p->num;
$bien->save();

$annonce->delete();

redirect("./biens.php");

?>
