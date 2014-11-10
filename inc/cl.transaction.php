<?php
class transaction extends alpha{

	var $libelle ;
    var $comptefrom;
    var $compteto;
    var $montant;
    var $date;
    
    function setdate(){
        $this->date = date("Y-m-d");
    }
    
    function save_transaction($libelle,$from,$dest,$montant){
        $this->libelle = $libelle;
        $this->comptefrom = $from;
        $this->compteto = $dest;
        $this->montant = $montant;
        $this->setdate();
        $this->save();
    }
}

?>
