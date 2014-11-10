<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,"maire") ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Quartier undefined";
        break;
    case 1 :
        echo "Nom undefined";
        break;
    case 2 :
        echo "Ville undefined";
        break;
    }
    echo "<br /><a href=\"./admincadastre.php\">Retour</a>";
    exit;
}

extraction("quartier") or print_error(0) ;

$quart = new quartier;
if($quartier>=1) {
    $quart->get($quartier);
}
else{
	 extraction("cte") or print_error(2) ;
    $quart->cte = $cte ;
}

$quart->nom = (isset($_POST['nom'])&&($_POST['nom']<>"")) ? $_POST['nom'] : $quart->nom;
$quart->description = (isset($_POST['description'])&&($_POST['description']<>"")) ? $_POST['description'] : $quart->description;
$quart->plan = isset($_POST['plan']) ? $_POST['plan'] : $quart->plan;


if($quartier == 0) $quart->create_quartier();

$quart->save();

redirect("./admincadastre.php");
?>
