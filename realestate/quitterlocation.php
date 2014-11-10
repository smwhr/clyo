<?php

require_once('./inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 2 :
        echo "Vous ne louez pas ce bien.";
        break;
    case 3 :
        echo "Vous ne pouvez pas quitter votre logement princypal.";
        break;
    }
    echo "<br /><a href=\"./biens.php\">Retour</a>";
    exit;
}

extraction("bien") or print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$terrain = new terrain;
$terrain->get($bien);

if ($terrain->locataire <> $p->num) print_error(2);

if ($p->domicile == $terrain->num) print_error(3);

$terrain->locataire = 0;
$terrain->save();
redirect("./biens.php");

?>
