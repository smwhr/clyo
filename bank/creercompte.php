<?php

require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Libell&eacute; undefined";
        break;
    }
    echo "<br /><a href=\"./index.php\">Retour</a>";
    exit;
}

extraction("libelle") or print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$compte = new compte;
$compte->titulaire = $p->num;
$compte->libelle = $libelle;
$compte->create_compte();
if($compte->save()){
    redirect("index.php");
}
else{
    echo "Une erreur s'est produite.<br /><a href=\"./index.php\">Retour</a>";
}

?>
