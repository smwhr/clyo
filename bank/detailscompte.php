<?php
require_once("../inc/centrale.php");

$p = new personne;
if(!$p->secure()) redirect("../main/toconnect.php");

$compte = new compte;

if (!extraction("c",$_GET)) $compte->getprincipal($p->num) ;
else $compte->get($c) ;

if (!extraction("m",$_GET) || $m > 12 || $m < 1) $m = date("m") ;
if (!extraction("y",$_GET) || ($y."-".$m > date("Y-m"))) $y = date("Y") ;

$liens = "<a href='detailscompte.php?c=".$compte->num."&amp;m=" ;
if ($m == 1) $liens .= "12&amp;y=".($y-1) ;
else $liens .= ($m-1)."&amp;y=".$y ;
$liens .= "'>Moys pr&eacute;c&eacute;dent</a>" ;
if ($m <> date("m") || $y <> date("Y")) {
	$liens .= " | <a href='detailscompte.php?c=".$compte->num."&amp;m=" ;
	if ($m == 12) $liens .= "1&amp;y=".($y+1) ;
	else $liens .= ($m+1)."&amp;y=".$y ;
	$liens .= "'>Moys suivant</a>" ;
}

if($compte->titulaire<>$p->num){
	droit::check($p,"fysc") ;
}

clyo::head() ;

$transaction = new transaction;
if ($m < 10) $M = "0".$m ;
else $M = $m ;

$requete = "WHERE ( comptefrom=$compte->num OR compteto=$compte->num ) AND date > '".$y."-".$M."-00' AND date < '".$y."-".$M."-32' ORDER BY date,num DESC" ;
$transaction->select($requete) ;


$solde = $compte->report($m,$y) ;
?>

	<h2><?echo $compte->libelle;?></h2>

<div>
	<p>Relev&eacute; de compte pour le moys de <?=ysdate($m,$y)?></p>
	<p><?=$liens ?></p>
	<table id="transaction_list">
		<tr>
			<th>Date</th>
			<th>Libell&eacute;</th>
			<th>D&eacute;bit</th>
			<th>Cr&eacute;dit</th>
			<th>Solde</th>
		</tr>
		<tr class='pair'>
			<td class='report' colspan='4'>Report</td>
			<td class='solde'><?=$solde ?></td>
		</tr>
<?php
$i = 1 ;
while($transaction->next()){
   if (bcmod($i, '2') == '0') $type = "class='pair'" ;
   else $type = "class='impair'" ;
   $i++ ;
	echo "		<tr $type>\n";
	//echo "			<td>".$transaction->num."</td>\n";
	$date = explode("-",$transaction->date) ;
	echo "			<td class='date'>".$date[2]."/".$date[1]."</td>\n";
  	echo "			<td class='libelle'>".$transaction->libelle;
	if($transaction->comptefrom == $compte->num){
		if($transaction->comptefrom <> 0){
			$compteto = new compte;
			if ($compteto->get($transaction->compteto)) echo "<br />vers&eacute; &agrave; ".$compteto->libelle ;
		}
		echo "</td>\n" ;
		echo "			<td class='montant'>".$transaction->montant."</td>\n";
		echo "			<td>&nbsp;</td>\n";
		$solde -= $transaction->montant ;
	}
	else{
		if($transaction->comptefrom <> 0){
			$comptefrom = new compte;
			if ($comptefrom->get($transaction->comptefrom)) echo "<br />vers&eacute; depuys ".$compteto->libelle ;
		}
		echo "</td>\n" ; ;
		echo "			<td>&nbsp;</td>\n";
		echo "			<td class='montant'>".$transaction->montant."</td>\n";
		$solde += $transaction->montant ;
	}
	echo "			<td class='solde'>".$solde."</td>\n";
	echo "		</tr>\n";
}

if (bcmod($i, '2') == '0') $type = "class='pair'" ;
else $type = "class='impair'" ;
$i++ ;
?>
		<tr <?=$type ?>>
			<td class='report' colspan='4'>Report</td>
			<td class='solde'><?=$solde ?></td>
		</tr>                
	</table>
	<p><?=$liens ?></p>
</div>

<?php

clyo::foot() ;
?>
