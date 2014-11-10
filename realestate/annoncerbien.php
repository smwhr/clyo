<?php

require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 1 :
        echo "Prix undefined";
        break;
    case 2 :
        echo "Ce bien ne vous appartient pas.";
        break;
    case 3 :
        echo "Destinataire invalide.";
        break;
    case 4 :
        echo "Vous ne pouvez pas c&eacute;der votre logement princypal.";
        break;
    echo "<br /><a href=\"./biens.php\">Retour</a>";
    exit;
    }
}


$biennum = isset($_POST['bien']) ? $_POST['bien'] : print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$bien = new terrain;
$bien->get($biennum);


if ($bien->proprietaire <> $p->num) print_error(2);

if ($p->domicile == $bien->num) print_error(4);

$annonce = new petite_annonce;
$annonce->select("WHERE terrain=$bien->num");
if($annonce->lenen()>=1){
    while($annonce->next()){
        $annonce->delete();
    }
}else{
    $annonce->num = 0;
    $annonce->prix = isset($_POST['prix']) ? $_POST['prix']%1000000000 : print_error(0) ;
    $annonce->terrain = $bien->num;
    $annonce->save();
}

redirect("./index.php");

?>
