<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check("maire") ;

function print_error($case){
    switch($case){
    case "0" :
        echo "Type undefined";
        break;
    case "1" :
        echo "Vous n'avez pas confirm&eacute; votre choix.";
        break;
    case "2" :
        echo "Personne non valide";
        break;
    default :
        echo $case;
        break;
    }
    echo "<br /><a href=\"./admincadastre.php\">Retour</a>";
    exit;
}

extraction("type") or print_error(0) ;
extraction("confirm") or print_error(1) ;

switch($type){

    case "terrain":
    	  extraction("terrain") or print_error("Terrain undefined") ;
        $terr = new terrain;
        $terr->get($terrain);
            $domicilie = new personne;
            $domicilie->select("WHERE domicile=$terr->num");
            while($domicilie->next()){
                $domicilie->domicile = 0;
                $domicilie->save();
            }
        $terr->delete();
        break;
    case "rue";
        extraction("rue") or print_error("Rue undefined") ;
        $street = new rue;
        $street->get($rue);
        $terr = new terrain;
        $terr->select("WHERE rue=$street->num");
        while($terr->next()){
                $domicilie = new personne;
                $domicilie->select("WHERE domicile=$terr->num");
                while($domicilie->next()){
                    $domicilie->domicile = 0;
                    $domicilie->save();
                }
            $terr->delete();
        }
        $street->delete();
        break;
    case "quartier";
    		extraction("quartier") or print_error("Quartier undefined") ;
			$quart = new quartier;
        $quart->get($quartier);
        $rue = new rue;
        $rue->select("WHERE quartier=$quart->num");
        while($rue->next()){
            $terrain = new terrain;
            $terrain->select("WHERE rue=$rue->num");
            while($terrain->next()){
                    $domicilie = new personne;
                    $domicilie->select("WHERE domicile=$terrain->num");
                    while($domicilie->next()){
                        $domicilie->domicile = 0;
                        $domicilie->save();
                    }
                $terrain->delete();
            }
            $rue->delete();
        }
        $quart->delete();
        break;
}

redirect("./admincadastre.php");
?>
