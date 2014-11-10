<?
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

clyo::head() ;
?>
      <h2>Petites Annonces</h2>
        <div>
          <h3>Annonces de Locatyon</h3>
<?
$bien = new terrain;
$bien->select("WHERE locataire=0 AND loyer>=1");
?>
            <table class="liste_bien">
                        <tr><th>&nbsp;</th><th>Nom</th><th>Adresse</th><th>Loyer</th><th>&nbsp;</th></tr>
<?
if($bien->lenen()>=1){
    while($bien->next()){
            echo "<tr>";
        $photo = ($bien->photo <> "") ? $bien->photo : "../Images/nophoto.gif";
                echo "<td><img src=\"".$photo."\" /></td>";
                echo "<td>".$bien->nom."</td>";
                echo "<td>";
                    $rue = new rue;
                    $rue->get($bien->rue);
                    $quartier = new quartier;
                    $quartier->get($rue->quartier);
                    $cte = new cte;
                    $cte->get($quartier->cte);
                    echo "$bien->numero, $rue->nom, $quartier->nom, ".strtoupper($cte->nomc);
                echo "</td>";
                echo "<td>".$bien->loyer."&nbsp;".$cte->monnaie."</td>";
                echo "<td>";
                    echo "<form action=\"louerbien.php\" method=\"POST\">";
        $compte = new compte;
        $compte->select("WHERE titulaire=$p->num");
                    echo "<select name=\"compte\">";
                    echo "<option>Compte &agrave; pr&eacute;lever</option>";
            while($compte->next()){
                    echo "<option value=\"".$compte->num."\">";
                    echo $compte->libelle;
                    echo "</option>";
            }
                    echo "</select>";
                    echo "<input type=\"hidden\" name=\"bien\" value=\"".$bien->num."\">";
                    echo "<input type=\"submit\" value=\"Louer\">";
                    echo "</form>";
                echo "</td>";
            echo "</tr>";
    }
}else{
            echo "<tr><td colspan=\"5\">Aucune annonce de locatyon pour le moment</td></tr>";
}
?>
            </table>
        </div>

        <div>
          <h3>Annonces de Vente</h3>

            <table class="liste_bien">
                        <tr><th>&nbsp;</th><th>Nom</th><th>Adresse</th><th>Prix</th><th>&nbsp;</th></tr>
<?
$annonce = new petite_annonce;
$annonce->select();
if($annonce->lenen()>=1){

    while($annonce->next()){
        $bien = new terrain;
        $bien->get($annonce->terrain);
            echo "<tr>";
        $photo = ($bien->photo <> "") ? $bien->photo : "../Images/nophoto.gif";
                echo "<td><img src=\"".$photo."\" /></td>";
                echo "<td>".$bien->nom."</td>";
                echo "<td>";
                    $rue = new rue;
                    $rue->get($bien->rue);
                    $quartier = new quartier;
                    $quartier->get($rue->quartier);
                    $cte = new cte;
                    $cte->get($quartier->cte);
                    echo "$bien->numero, $rue->nom, $quartier->nom, ".strtoupper($cte->nomc);
                echo "</td>";
                echo "<td>".$annonce->prix."&nbsp;".$cte->monnaie."</td>";
                echo "<td>";
                    echo "<form action=\"acheterbien.php\" method=\"POST\">";
        $compte = new compte;
        $compte->select("WHERE titulaire=$p->num");
                    echo "<select name=\"compte\">";
                    echo "<option>Compte &agrave; pr&eacute;lever</option>";
            while($compte->next()){
                    echo "<option value=\"".$compte->num."\">";
                    echo $compte->libelle;
                    echo "</option>";
            }
                    echo "</select>";
                    echo "<input type=\"hidden\" name=\"bien\" value=\"".$bien->num."\">";
                    echo "<input type=\"submit\" value=\"Acheter\">";
                    echo "</form>";
                echo "</td>";
            echo "</tr>";
    }
}else{
            echo "<tr><td colspan=\"5\">Aucune annonce de vente pour le moment</td></tr>";
}
?>
            </table>
        </div>
        
<?php
clyo::foot() ;
?>