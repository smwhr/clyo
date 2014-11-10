<?php

require_once('../inc/centrale.php') ;


function print_error($case){
    switch($case){
    case 0 :
        echo "Clone undefined";
        break;
    case 1 :
        echo "Destinataire undefined";
        break;
    case 2 :
        echo "Ce clone n'est pas un servyce public.";
        break;
    case 3 :
        echo "Destinataire invalide.";
        break;
    case 4 :
        echo "Vous devez &ecirc;tre Doge pour c&eacute;der un Servyce Public.";
        break;
    }
    echo "<br /><a href=\"./conseiladmin.php\">Retour</a>";
    exit;
}

extraction("clone") or print_error(0) ;
extraction("dest") or print_error(1) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::hasgot($p,"doge") or print_error(4);

$newclone = new personne;
$newclone->get($clone);

if($newclone->type<>2) print_error(2);

if($dest==0){
    $newclone->proprietaire = 0 ;
    $clone->save();
    redirect("./conseiladmin.php");    
}

$newdest = new personne;
$newdest->get($dest);
if($dest>=1){
    $newclone->proprietaire = $dest;
    $newclone->save();
    redirect("./conseiladmin.php");
}
else {
    echo $newdest->num;
    print_error(3);
}

?>
