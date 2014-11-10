<?
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");
$droit = new droit;
$droit->getbyname("maire");
if(!$droit->secure($p->num)) redirect("../main/index.php");



function print_error($case){
    switch($case){
    case 0 :
        echo "Quartier undefined";
        break;
    case 1 :
        echo "Nom undefined";
        break;
    case 2 :
        echo "Personne non valide";
        break;
    }
    echo "<br /><a href=\"./admincadastre.php\">Retour</a>";
    exit;
}

$quartier = isset($_POST['quartier']) ? $_POST['quartier'] : print_error(0) ;
$nom = isset($_POST['nom']) ? $_POST['nom'] : print_error(1) ;

$rue = new rue;
$rue->quartier = $quartier;
$rue->nom = $nom;
$rue->create_rue();
$rue->save();

redirect("./admincadastre.php");
?>
