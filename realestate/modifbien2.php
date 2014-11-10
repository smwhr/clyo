<?php

require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 1 :
        echo "Ce bien ne vous appartiens pas.";
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

if($terrain->proprietaire <> $p->num) print_error(1);

if (!extraction("nom")) $nom = "";
if (!extraction("photo")) $photo = "";
if (extraction($description)) $description = strip_tags($_POST['description'],"<em><strong><br>");
else $description = 0 ;
if (!extraction("loyer")) $loyer = 0 ;

$terrain->nom = $nom;
$terrain->photo = $photo;
$terrain->description = $description;
$terrain->loyer = $loyer;
if($loyer == 0) $terrain->expulser(); //en mettant le loyer à zéro, on expulse le locataire.
$terrain->save();

redirect("./biens.php");

?>
