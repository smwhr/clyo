<?
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$moi = new personne;

if(isset($_GET['num'])){
    $moi->get($_GET['num']);
}else{
    $moi->get($p->num);
}

clyo::head() ;
?>
        <h2>Cadastre Yssois</h2>
<?
$cte = new cte;
$cte->select("ORDER BY num");
    while($cte->next()){
        echo "<div>";
            echo "<h3>Cadastre de $cte->nomc</h3>";
            $quartier = new quartier;
            $quartier->select("WHERE cte=$cte->num");
            while($quartier->next()){
                echo "<table class=\"cadastre_table\">";
                echo "<tr>";
                    echo "<th  colspan=\"4\" class=\"nom_quartier\">$quartier->nom</th>";
                echo "</tr>";
                echo "<tr>";
            $photo = ($quartier->plan <> "") ? $quartier->plan : "../Images/nophoto.gif";
                    echo "<td><img src=\"".$photo."\" /></td>";
                    echo "<td colspan=\"3\" class=\"desc_quartier\">$quartier->description</td>";
                echo "</tr>";
                    $rue = new rue;
                    $rue->select("WHERE quartier=$quartier->num ORDER BY nom");
                    while($rue->next()){
                        echo "<tr>";
                            echo "<th colspan=\"4\" class=\"nom_rue\">$rue->nom</th>";
                        echo "</tr>";
                        $terrain = new terrain;
                        $terrain->select("WHERE rue=$rue->num ORDER BY numero");
                        while($terrain->next()){
                            echo "<tr>";
        $photo = ($terrain->photo <> "") ? $terrain->photo : "../Images/nophoto.gif";
                echo "<td><img src=\"".$photo."\" /></td>";
                                echo "<td>";
                                    echo $terrain->nom;
                                echo "</td>";
                                echo "<td>";
                                    echo $terrain->numero.", ".$rue->nom;
                                echo "</td>";
                                echo "<td>";
                                    $proprio = new personne;
                                    $proprio->get($terrain->proprietaire);
                                    echo "<a href=\"../Moi/index.php?num=$proprio->num\">";
                                    echo $proprio->nom." ".$proprio->prenom;
                                    echo "</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    }                    
                echo "</table>";
            }
        echo "</div>";    
    }

clyo::foot() ;
?>
