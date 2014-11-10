<?php

class terrain extends alpha{

	public $nom;	//nom du terrain
    public $rue;   //num de la rue mère
    public $numero; //numero dans la rue
    public $proprietaire; //num du proprietaire
    public $photo; //url vers une photo
    public $description; //texte descriptif
    public $loyer; //loyer demandé au locataire
    public $locataire; //num du locataire
    public $compteloc; //compte sur lequel sera prélevé le loyer

	public function create_terrain() {
	}
	
	public function expulser(){
	    if($this->locataire==0) return;
	    //require_once("cl_personne");
	    $locataire = new personne;
	    $locataire->get($this->locataire);
	    $locataire->domicile=0;
	    $locataire->save();
	    $this->locataire = 0;
	    $this->compteloc = 0;
	    $this->save();
	}
	
	public function adresse($pretty=true) {
		$rue = new rue;
		$rue->get($this->rue);
		$quartier = new quartier;
		$quartier->get($rue->quartier);
		$cte = new cte;
		$cte->get($quartier->cte);
		if ($pretty) return "$this->numero, $rue->nom <br /> $quartier->nom <br />  <span class='ville'>".$cte->nomc."</span>";
		else return "$this->numero, $rue->nom, $quartier->nom, ".$cte->nomc ;
	}

}
?>
