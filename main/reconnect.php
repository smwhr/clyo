<?php

require_once("../inc/centrale.php");

function print_error($case){
    switch($case){
    case 0 :
        echo "Nouvelle identit&eacute; undefined";
        break;
    case 1 :
        echo "Ce personnage ne vous appartient pas ou vous n'&ecirc;tes pas connect&eacute; &agrave; Clyo.";
        break;    
    }
    echo "<br /><a href=\"../main/index.php\">Retour</a>";
    exit;
}

function wrongid($tracer="") {

		echo "<div id=\"error\">\n" ;
		echo "Indentification incorrecte. <br />\n" ;
		echo "<a href=\"../main/index.php\">Retour</a>\n" ;
		echo "</div>\n" ;
		exit;
}

if (extraction("personum")) {
	if ($personum == "0") redirect("../main/index.php") ;
	else {
		$p = new personne;
		if(!$p->secure()) redirect("../main/index.php");
		$estroot = droit::hasgot($p,"root") ; 
		$proche = new personne ;
		$proche->get($personum);
		if (($proche->proprietaire == $p->num)||($proche->num == $p->proprietaire)||($rootdroit->secure($p->num))){
   		session_start() ;
    		$_SESSION['clyoident'] = $proche->num ;
    		$proche->connect();
    		redirect("../main/index.php") ;
		}
		else{
		    print_error(1);
		}
	}
}
else print_error(0) ;
?>
