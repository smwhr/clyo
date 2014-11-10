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
        echo "Ce clone ne vous appartient pas.";
        break;
    case 3 :
        echo "Destinataire invalide.";
        break;
    case 4 :
        echo "Vous ne pouvez pas c&eacute;der un Servyce Public.";
        break;
    }
    echo "<br /><a href=\"./clones.php\">Retour</a>";
    exit;
}


extraction("clone") or print_error(0) ;
extraction("dest") or print_error(1) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$newclone = new personne;
$newclone->get($clone);

if ($newclone->type == 2) print_error(4);

if ($newclone->proprietaire <> $p->num) print_error(2);

$newdest = new personne;
$newdest->get($dest);
if($newdest->num>=1){
    $newclone->proprietaire = $destnum;
    $newclone->save();
    redirect("./clones.php");
}
else{
    echo $newdest->num;
    print_error(3);
}

?>
