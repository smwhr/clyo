<?php

require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

droit::check($p,'root') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Action undefined";
        break;
    case 1 :
        echo "Droit undefined";
        break;
    case 2 :
        echo "Personne undefinded";
        break;
    case 3 :
        echo "Ce droit existe deja";
        break;
    }
    echo "<br /><a href=\"./admindroit.php\">Retour</a>";
    exit;
}

extraction('action',$_GET) or print_error(0) ;

switch($action){
    case "allouer" :
    	  	extraction("droit",$_GET) or print_error(1) ;
			extraction("personne",$_GET) or print_error(2) ;
       	$d = new droit;
        	$d->get($droit);
        	$d->alloue($personne);
        	break;
    case "retirer" :
        	extraction("droit",$_GET) or print_error(1) ;
			extraction("personne",$_GET) or print_error(2) ;
        	$d = new droit;
        	$d->get($droit);
        	$d->retire($personne);
        	break;
    case "creer" :
         extraction("droit",$_GET) or print_error(1) ;
         $d = new droit;
         if ($d->get('nom',$droit)) print_error(3);
         $d->num=0;
         $d->nom=$droit ;
         $d->save();
         break;
}
redirect("./admindroit.php");
?>
