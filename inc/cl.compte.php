<?php

class compte extends alpha{

	public $libelle ;
	public $titulaire ;
	public $solde ;
	public $banque ;
	public $principal ; //0 : non ; 1 : compte principal
	
	public function getprincipal($pnum){
		return $this->get("titulaire",$pnum) ;
	}

	public function create_compte() {
	    $this->banque = 1;
	}	

	public function report($m,$y) {
		$debit = mysqldb::unik("SELECT SUM(montant) FROM ".transaction::$table." WHERE comptefrom='".$this->num."' AND date > '".$y."-".$m."-00'" ) ; 
		$credit = mysqldb::unik("SELECT SUM(montant) FROM ".transaction::$table." WHERE compteto='".$this->num."' AND date > '".$y."-".$m."-00'" ) ; 
		return ($this->solde + $debit - $credit) ;
	}

}

?>
