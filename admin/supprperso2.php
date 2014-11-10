<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,"root") ;

extraction("confirm") or die("Vous avez oubli&eacute; de confirmer");
extraction("personne") or die("Pr&eacute;cisez une personne.");

//note : cette fonction est récursive

function delete_personne($pnum){
    $personne = new personne;
    $personne->get($pnum);

    $biens = new terrain;
    $biens->select("WHERE proprietaire=$personne->num");
    while($biens->next()){
        $biens->proprietaire = 0;
        $biens->save();
    }

    $biens->select("WHERE locataire=$personne->num");
    while($biens->next()){
        $biens->locataire = 0;
        $biens->compteloc = 0;
        $biens->save();
    }

    $compte = new compte;
    $compte->select("WHERE titulaire=$personne->num");
    while($compte->next()){
        $compte->delete();
    }

    $travail = new activite;
    $travail->select("WHERE personne = $personne->num");
    while($travail->next()){
        $travail->delete();
    }

    $clone = new personne;
    $clone->select("WHERE proprietaire = $personne->num");
    while($clone->next()){
        delete_personne($clone->num);
    }
    
    $personne->delete();
}

delete_personne($personne);
redirect("./supprperso.php");

?>

