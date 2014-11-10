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
        echo "Rue undefined";
        break;
    case 1 :
        echo "Personne undefined";
        break;
    case 2 :
        echo "Personne non valide";
        break;
    }
    echo "<br /><a href=\"./admincadastre.php\">Retour</a>";
    exit;
}

$rue = isset($_POST['rue']) ? $_POST['rue'] : print_error(0) ;
$nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$numero = isset($_POST['numero']) ? $_POST['numero']%65555 : rand(12,47);
$photo = isset($_POST['photo']) ? $_POST['photo'] : "";
$proprionum = isset($_POST['proprietaire']) ? $_POST['proprietaire'] : print_error(1) ;

$proprio = new personne;
$proprio->get($proprionum);

$terrain = new terrain;
$terrain->rue = $rue;
$terrain->nom = $nom;
$terrain->numero = $numero;
$terrain->photo = $photo;
$terrain->proprietaire = $proprionum;
$terrain->create_terrain();
$terrain->save();

redirect("./admincadastre.php");
?>
