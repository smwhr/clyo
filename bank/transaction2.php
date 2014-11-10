<?php

require_once('../inc/centrale.php') ;


function print_error($case){
    switch($case){
    case 0 :
        echo "Compte d&eacute;biteur undefined";
        break;
    case 1 :
        echo "Compte cr&eacute;diteur undefined";
        break;
    case 2 :
        echo "Montant undefined ou non valide";
        break;
    case 3 :
        echo "Vous ne pouvez virer de l'argent depuis un compte qui ne vous appartient pas.";
        break;
    }
    echo "<br /><a href=\"./index.php\">Retour</a>";
    exit;
}

extraction("from") or print_error(0) ;
extraction("dest") or print_error(1) ;
if (!extraction("libelle")) $libelle = "Rayson inconnue" ;
extraction("montant") or print_error(2) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

if($dest == $from) redirect("./transaction.php");

$comptefrom = new compte;
$comptefrom->get($from);

if($comptefrom->titulaire <> $p->num) print_error(3);

$comptedest = new compte;
$comptedest->get($dest);

$solvable = (($comptefrom->solde - $montant)>=0) ;

$comptefrom->solde = $solvable ? $comptefrom->solde - $montant : $comptefrom->solde;
$comptefrom->save();
$comptedest->solde = $solvable ? $comptedest->solde + $montant : $comptedest->solde;
$comptedest->save();

$trans = new transaction;
$trans->save_transaction($libelle,$comptefrom->num,$comptedest->num,$montant);

redirect("./index.php");
?>
