<?php

class personne extends alpha{
	
	public $nom;	    //nom de la personne
	public $type;	    //type de personne. 0 = PJ; 1 = entreprise ; 2 = entité publique
	public $password;	//Password
	public $prenom;	//Prenom
	public $email;		//Email
	public $url;		//URL de la personne
	public $photo;		//Photo de la personne
	public $proprietaire;	//Personnage propriétaire ou dirigeant
	public $cte ;          //Communauté d'adoption
	public $domicile;      //num d'un terrain où la personne réside (0 = domicile de base de la cte)
	public $naturalisation;	//Date de naturalisation de la personne
	public $bio;		//n° de la biographie
	public $lastc;		//Date de la dernière connexion
	public $ip;
	public $msn;			//adresse msn messenger de la personne
	public $sexe;			//sexe de la personne 'f' ou 'm'
	public $pere;			//n° du père de la personne
	public $nompere;		//nom du père de la personne
	public $mere;			//n° de la mère de la personne
	public $nommere;		//nom de la mère de la personne
	
	public function secure(){
		session_start() ;
		$playerid = isset($_SESSION['clyoident']) ? $_SESSION['clyoident'] : 0 ;
		if ($playerid > 0 ) {
			$this->get($playerid) ;
			$this->connect();
		}
		return $playerid ;
	}
	
   public function connect() {
		$this->lastc = date("Y-m-d");
		$this->ip    = $_SERVER['REMOTE_ADDR'] ;
		$this->save();
		return $this->num;
	}
	
	public function statut(){
      switch($this->type){
        case 0: 
            return "Citoyen";
        case 1:
            return "Entrepryse";
        case 2:
            return "Servyce Public";
      }
	}
	
	public function create_personne() {
		$this->lastc = date("Y-m-d");
		$this->ip    = $_SERVER['REMOTE_ADDR'] ;
        $this->naturalisation = date("Y-m-d");
        
        //on crée automatiquement un compte
        //on est obligé de faire ->save() sur la personne pour que celle ci ait un num
        $this->save();
        $compte = new compte;
        $compte->titulaire = $this->num;
        $compte->libelle = "Compte de ".$this->prenom." ".$this->nom;
        $compte->banque = $this->cte;
        $compte->principal = 1;
        $compte->save();
	}	

	public static function list_options($option = "") {
		$p = new personne ;
		$p->select("$option ORDER BY type,nom,prenom ASC") ;
		$statut = -1 ;
		$traduction = array("Citoyens", "Entrepryses", "Services publics") ;
		while ($p->next()) {
			if ($statut < $p->type) {
				$statut = $p->type ;
				if ($statut > 0) echo "	</optgroup>\n" ;
				echo "	<optgroup label='".$traduction[$statut]."'>\n" ;
			}
			echo "		<option value='".$p->num."'>";
			if ($statut == 0) echo $p->nom.", ".$p->prenom ;
			else echo $p->nom ;
			echo "</option>\n" ;
		}
		echo "	</optgroup>\n" ;
	}

	public function list_accounts() {
		$comptes = new compte;
		$comptes->select("WHERE titulaire=".$this->num." ORDER BY num ASC");
		if($comptes->lenen()==0){
	        echo "<em>Vous n'avez pas de compte bancaire actuellement.</em>";
		}
		else{
        echo "<table id=\"liste_compte\">\n";
        echo "	<tr>\n";
        echo "		<th>#</th><th>Libell&eacute;</th><th>Solde</th>\n";
        echo "	</tr>\n";
        $i = 0 ;
    	  while($comptes->next()){
    	  		if (bcmod($i, '2') == '0') $type = "class='pair'" ;
    	  		else $type = "class='impair'" ;
    	  		$i++ ;
       		echo "	<tr>\n";
        		echo "		<td $type>".$comptes->num."</td>\n";
        		echo "		<td $type><a href=\"../bank/detailscompte.php?c=".$comptes->num."\">".$comptes->libelle."</a></td>\n";
				$cte = new cte;
				$cte->get($comptes->banque);
        		echo "		<td $type>".$comptes->solde." ".$cte->monnaie."</td>\n";
         	echo "	</tr>\n";
    	  }
        echo "</table>";
		}
	}
	
	public function adresse($pretty=true) {
		if($this->domicile<>0){
			$bien = new terrain;
			$bien->get($this->domicile);
			return $bien->adresse($pretty) ;
		}
		else{
			$cte = new cte;
			$cte->get($this->cte);
			if ($pretty) return "$cte->cdomicile <br /> <span class='ville'>".$cte->nomc."</span>";
			else return "$cte->cdomicile, ".$cte->nomc ;
		}
	}
	
	public function courriel() {
		$p = new personne ;
		$p->get($this->num) ;
		while($p->email == "") {
			$p->get($p->proprietaire) ;
		}
		return $p->email ;
	}

}

?>
