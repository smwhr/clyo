<?
require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 1 :
        echo "Ce bien n'est pas &agrave; louer.";
        break;
    case 2 :
        echo "Compte undefined";
        break;
    case 3 :
        echo "Ce compte ne vous appartient pas.";
        break;
    }
    echo "<br /><a href=\"./index.php\">Retour</a>";
    exit;
}



$biennum = isset($_POST['bien']) ? $_POST['bien'] : print_error(0) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$bien = new terrain;
$bien->get($biennum);

if(($bien->locataire <> 0)||($bien->loyer==0)) print_error(1);

$comptenum = isset($_POST['compte']) ? $_POST['compte'] : print_error(2) ;

$compte = new compte;
$compte->get($comptenum);

if($compte->titulaire <> $p->num) print_error(3);

$bien->locataire = $p->num;
$bien->compteloc = $compte->num;
$bien->save();

redirect("./biens.php");

?>
