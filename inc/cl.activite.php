<?php

class activite extends alpha{
	
	public $personne ; 		//num de la personne concernée 
	public $activite ;		//activité actuelle
	public $revenu ;			//revenu lié à cette activité
	public $objectif ;		//objectif premier 
	public $details ;			//détails de ce premier 
	public $etat ;				//état de l'objectif : 
									// 0 pas d'objectif, 
									// 1 objectif en attente de validation, 
									// 2 objectif validé, 
									// 3 objectif atteint en attente de contrôle
	public $augmentation ;	//augmentation du revenu qui suivra
	public $prime ;			//prime qui viendra en plus
	public $argument ; 		//argument donné pour justifier d'un objectif atteint

	public function charge($p) {
		if (!$this->get("personne",$p->num)) {
			$this->personne = $p->num ;
			$this->activite = "aucune" ;
			$this->revenu = 0 ;
			$this->objectif = "" ;
			$this->details = "" ;
			$this->etat = 0 ;
			$this->augmentation = 0 ;
			$this->prime = 0 ;
			$this->argument = "" ;
			$this->save() ;
		}
	}

}

?>
