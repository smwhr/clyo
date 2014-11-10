<?php

require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 2 :
        echo "Vous ne louez ni ne poss&eacute;dez ce bien.";
        break;
    case 3 :
        echo "Vous devez vivre dans l'un de vos biens.";
        break;
    }
    echo "<br /><a href=\"./biens.php\">Retour</a>";
    exit;
}

extraction("bien") or print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

if($bien == 0){
    $possessions = new terrain;
    $possessions->select("WHERE proprietaire=$p->num OR locataire=$p->num");
    if($possessions->lenen()>=1){
        print_error(3);
    }
    $p->domicile = 0;
    redirect("./biens.php");
}

$terrain = new terrain;
$terrain->get($bien);


if (($terrain->locataire <> $p->num)&&($terrain->proprietaire <> $p->num)) print_error(2);


$p->domicile = $terrain->num;
$p->save();
redirect("./biens.php");

?>
