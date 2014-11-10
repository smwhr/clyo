<?php
/*Config file*/
require_once('config.php');

/*Fonctions utiles*/

function redirect($url){
	header("Location: ".$url);
	exit;
}

function extraction() {
	$n = func_num_args() ;
	$derniere = func_get_arg($n-1) ;
	if (is_array($derniere)) {
		$method = $derniere ;
		$d = 1 ;
	}
	else {
		$method=$_POST ;
		$d = 0 ;
	}
	for($i=0 ; $i<$n-$d ; $i++) {
		$_nom = func_get_arg($i) ;
		if (array_key_exists($_nom,$method)) {
			global $$_nom ;
			$$_nom = $method[$_nom] ;
		}
		else {
			return false ;
		}
	}
	return true ;
}

function ysdate() {
	$n = func_num_args() ;
	$moys = array("janvier","f&eacute;vrier","mars","avril","may","juyn","juyllet","ao&ucirc;t","septembre","octobre","novembre","d&eacute;cembre") ;
	$an = array("i","ii","iii","iv","v","vi","vii","viii","ix","x","xi","xii","xiii","xiv","xv","xvi","xvii","xviii","xix","xx") ;
	$texte = "" ;
	switch ($n) {
		case 3 :
			$d = func_get_arg($n-3) ;
			if (((int) $d) == 1) $texte .= "1<sup>er</sup> " ;
			else $texte .= ((int) $d)." " ;
		case 2 :
			$m = func_get_arg($n-2) ;
			$texte .= $moys[((int) $m) -1]." de l'" ;
		case 1 :
			$y = func_get_arg($n-1) ;
			if ($y > 2000 && $y < 2021) {
				$texte .= "an <span class='annee'>".$an[((int) $y)-2001]."</span> apr&egrave;s la seconde D&eacute;vastatyon" ;
			}
			else $texte .= "ann&eacute;e ".$y ;
	}
	return $texte ;
}

function __autoload($class_name) {
    ((@include "../inc/cl.".$class_name.".php") or (@include "inc/cl.".$class_name.".php")) or (trigger_error("Impossible de trouver mysqldb.", E_USER_ERROR));
}

/*Instanciation mysql*/
$dbinfo = $db[$server_name];
mysqldb::instance($dbinfo['user'],
		  $dbinfo['hostname'],
		  $dbinfo['password'],
		  $dbinfo['database'],
		  $dbinfo['dbprefix']
		);
?>
