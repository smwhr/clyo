<?
require_once('../inc/centrale.php') ;

function print_error($case){
    switch($case){
    case 0 :
        echo "Bien undefined";
        break;
    case 1 :
        echo "Destinataire undefined";
        break;
    case 2 :
        echo "Ce bien ne vous appartient pas.";
        break;
    case 3 :
        echo "Destinataire invalide.";
        break;
    case 4 :
        echo "Vous ne pouvez pas c&eacute;der votre logement princypal.";
        break;
    echo "<br /><a href=\"./biens.php\">Retour</a>";
    exit;
    }
}


$biennum = isset($_POST['bien']) ? $_POST['bien'] : print_error(0) ;
$destnum = isset($_POST['dest']) ? $_POST['dest'] : print_error(1) ;

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$bien = new terrain;
$bien->get($biennum);


if ($bien->proprietaire <> $p->num) print_error(2);

if ($p->domicile == $bien->num) print_error(4);

$dest = new personne;
$dest->get($destnum);
if($dest->num>=1){
    $bien->proprietaire = $destnum;
    $bien->save();
    redirect("./biens.php");
}else{
    echo $dest->num;
    print_error(3);
}

?>
