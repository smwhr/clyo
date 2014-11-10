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

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

if (!extraction("photo")) $photo = "" ;
if (extraction("bio")) $bio = strip_tags($_POST['bio'],"<em><strong><br>") ;
else $bio = "" ;
if (!extraction("url")) $url = "" ;
if (!extraction("email")) $email = "" ;
if (!extraction("msn")) $msn = "" ;

$p->photo = $photo;
$p->bio = $bio;
$p->url = $url;
$p->email = $email;
$p->msn = $msn;
$p->save();

redirect("./index.php");

?>
