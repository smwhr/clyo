<?php

function print_error($case){
    switch($case){
    case 0 :
        echo "Nouvelle identit&eacute; undefined";
        break;
    case 1 :
        echo "Ce personnage ne vous appartient pas ou vous n'&ecirc;tes pas connect&eacute; &agrave; Clyo.";
        break;    
    }
    echo "<br /><a href=\"./Main/index.php\">Retour</a>";
    exit;
}

function wrongid($tracer="") {

		echo "<div id=\"error\">\n" ;
		echo "Indentification incorrecte. <br />\n" ;
		echo "<a href=\"./Main/index.php\">Retour</a>\n" ;
		echo "</div>\n" ;
		exit;
}

require_once("./Classes/centrale.php");
require_once("./Classes/cl_personne.php");
require_once("./Classes/cl_admin.php");

/*
$personum = isset($_POST['personum']) ? $_POST['personum'] : print_error(0);
*/
if (extraction("personum")) {
	if ($personum == "0") redirect("./Main/index.php") ;
	else {
		$p = new personne;
		if(!$p->secure()) redirect("./Main/index.php");

		$rootdroit = new droit;
		$rootdroit->getbyname("root");
		$estroot = $rootdroit->secure($p->num) ;

		$proche = new personne ;
		$proche->get($personum);
		if (($proche->proprietaire == $p->num)||($proche->num == $p->proprietaire)||($rootdroit->secure($p->num))){
   		session_start() ;
    		$_SESSION['clyoident'] = $proche->num ;
    		$proche->connect();
    		redirect("./Main/index.php") ;
		}
		else{
		    print_error(1);
		}
	}
}
else print_error(0) ;
?>
