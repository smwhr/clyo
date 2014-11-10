<?
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$droitmaire = new droit;
$droitmaire->getbyname("maire");
if(!$droitmaire->secure($p->num)) redirect("./cadastre.php");

$moi = new personne;

if(isset($_GET['num'])){
    $moi->get($_GET['num']);
}else{
    $moi->get($p->num);
}

clyo::head() ;

?>
        <h2>Adminystratyon du cadastre</h2>
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
                    echo "<td>";
                        echo "<form action=\"supprimmo.php\" method=\"POST\">";
                        echo "<input type=\"checkbox\" name=\"confirm\" />";
                        echo "<input type=\"hidden\" name=\"type\" value=\"quartier\" />";
                        echo "<input type=\"hidden\" name=\"quartier\" value=\"$quartier->num\" />";
                        echo "<input type=\"submit\" value=\"Supprimer\" />";
                        echo "</form>";
                    echo "</td>";
                    
                echo "</tr>";
                echo "<tr>";
                    echo "<td  colspan=\"5\" class=\"desc_quartier\">";
                        echo $quartier->description;
                    echo "</td>";
                echo "</tr>";
                    $rue = new rue;
                    $rue->select("WHERE quartier=$quartier->num ORDER BY nom");
                    while($rue->next()){
                        echo "<tr>";
                            echo "<th colspan=\"4\" class=\"nom_rue\">$rue->nom</th>";
                            echo "<td>";
                                echo "<form action=\"supprimmo.php\" method=\"POST\">";
                                echo "<input type=\"checkbox\" name=\"confirm\" />";
                                echo "<input type=\"hidden\" name=\"type\" value=\"rue\" />";
                                echo "<input type=\"hidden\" name=\"rue\" value=\"$rue->num\" />";
                                echo "<input type=\"submit\" value=\"Supprimer\" />";
                                echo "</form>";
                            echo "</td>";
                        echo "</tr>";
                        $terrain = new terrain;
                        $terrain->select("WHERE rue=$rue->num ORDER BY numero");
                        while($terrain->next()){
                            echo "<tr>";
                                echo "<td>#$terrain->num</td>";
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
                                echo "<td>";
                                    echo "<form action=\"supprimmo.php\" method=\"POST\">";
                                    echo "<input type=\"checkbox\" name=\"confirm\" />";
                                    echo "<input type=\"hidden\" name=\"type\" value=\"terrain\" />";
                                    echo "<input type=\"hidden\" name=\"terrain\" value=\"$terrain->num\" />";
                                    echo "<input type=\"submit\" value=\"Supprimer\" />";
                                    echo "</form>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    }                    
                echo "</table>";
            }
        echo "</div>";    
    }
?>
    <div>
      <h3>Ajouter/Modifier un Quartier</h3>
            <form action="modifquartier.php" method="POST">
                <table class="form_table">
                	<tr>
                		<td> Quartier : </td>
                		<td>
                		    <select name="quartier">
                		        <option value="0">Nouveau</option>
<?
    $quartier = new quartier;
    $quartier->select("ORDER BY nom ASC");
        while($quartier->next()){
                            echo "<option value=\"".$quartier->num."\">";
                    $cte = new cte;
                    $cte->get($quartier->cte);
                            echo $quartier->nom.", ".$cte->nomc;
                            echo "</option>";
        }
?>
                		    </select>
                		</td>
                	</tr>
                	<tr>
                		<td>Nom (si nouveau)</td>
                		<td><input type="text" name="nom" /></td>
                	</tr>
                	<tr>
                		<td>Description</td>
                		<td><textarea name="description"></textarea></td>
                	</tr>
                	<tr>
                		<td>Plan : </td>
                		<td><input type="text" name="plan" /></td>
                	</tr>
                    <tr>
                        <td>Ville :</td>
                		<td><select name="cte">
                    		<option></option>
                <?
                $cte = new cte;
                $cte->select("WHERE mere=0");
                while($cte->next()){
                    echo "<option value=\"".$cte->num."\">".$cte->nomc."</option>";
                }
                ?>
                		    </select>
                		</td>
                	</tr>

            		<tr>
                		<td>&nbsp;</td>
                		<td><input type="submit" value="Cr&eacute;er/Modifier" /></td>
                	</tr>

                </table>         
            </form>
        </div>
        
        <div>
          <h3>Ajouter une rue</h3>
            <form action="addrue.php" method="POST">
                <table class="form_table">
                	<tr>
                		<td> Quartier : </td>
                		<td>
                		    <select name="quartier">
<?
    $quartier = new quartier;
    $quartier->select("ORDER BY nom ASC");
        while($quartier->next()){
                            echo "<option value=\"".$quartier->num."\">";
                    $cte = new cte;
                    $cte->get($quartier->cte);
                            echo $quartier->nom.", ".$cte->nomc;
                            echo "</option>";
        }
?>
                		    </select>
                		</td>
                	</tr>
                	<tr>
                		<td>Nom : </td>
                		<td><input type="text" name="nom" /></td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td><input type="submit" value="Cr&eacute;er" /></td>
                	</tr>
                </table>
            </form>
        </div>
        <div>
          <h3>Ajouter un terrain</h3>
            <form action="addterrain.php" method="POST">
                <table class="form_table">
                	<tr>
                		<td> Rue : </td>
                		<td>
                		    <select name="rue">
<?
    $rue = new rue;
    $rue->select("ORDER BY quartier");
        while($rue->next()){
                echo "<option value=\"".$rue->num."\">";
                        $quartier = new quartier;
                        $quartier->get($rue->quartier);
                        $cte = new cte;
                        $cte->get($quartier->cte);
                                echo $rue->nom.", ".$quartier->nom.", ".$cte->nomc;
                echo "</option>";
        }
?>
                		    </select>
                		</td>
                	</tr>
                	<tr>
                		<td>Nom : </td>
                		<td><input type="text" name="nom" /></td>
                	</tr>
                	<tr>
                		<td>Num&eacute;ro : </td>
                		<td><input type="text" name="numero" value="<?echo rand(13,47);?>" /></td>
                	</tr>
                	<tr>
                		<td>Photo : </td>
                		<td><input type="text" name="photo" /></td>
                	</tr>
                	<tr>
                		<td>Propri&eacute;taire : </td>
                		<td>
                		    <select name="proprietaire">
<?
$newproprio = new personne;
$newproprio->select("ORDER BY nom");
            while($newproprio->next()){
                echo "<option value=\"".$newproprio->num."\">";
                echo $newproprio->nom." ".$newproprio->prenom ;
                echo "</option>";
            }
?>
                            </select>
                    
                	<tr>
                		<td>&nbsp;</td>
                		<td><input type="submit" value="Cr&eacute;er" /></td>
                	</tr>
                </table>
            </form>
        </div> 
<?php
clyo::foot() ;
?>
