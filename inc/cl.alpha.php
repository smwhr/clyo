<?php
abstract class alpha {

	public $num;
	public static $table ;
	//protected $table;
	private $iq;
	
	final function __construct() {
		self::$table = mysqldb::$prefixe.get_class($this) ;
		$this->table = self::$table; 
	}	
	
	final public function get() {
		if (func_num_args() == 1) {
	 	 	//comportement habituel
	     	$num = func_get_arg(0) ;
	 	   $q = mysqldb::getline($this->table,$num) ;
		 	return $this->getrow($q);
	 	}
	 	else {
	 	   //comportement à deux attributs
	 	   $champ = func_get_arg(0) ;
	 	   $valeur = func_get_arg(1) ;
			$this->select("WHERE $champ = '$valeur'");
			if ($this->lenen() > 0 ) {
				$this->next() ;
				return true ;
			}
			else return false ;
	 	}
	}
	
	final public function delete() {
		return mysqldb::deleteline($this->table, $this->num); 
	}
	
	final public function select($string="") {
		$q = "SELECT * FROM ".$this->table." $string";
		$this->iq = mysqldb::send($q);
		return $this->iq;
	}
	
	final public function lenen() {
		return mysql_num_rows($this->iq);
	}
	
	final public function next() {
		//on passe à la ligne suivante dans la sélection
		if ($row = mysql_fetch_assoc($this->iq)) {
			 $this->getrow($row) ;
			 return true ;
		}
		else return false ;
	}

	final private function getrow($row) {
		//on transfert le contenu d'un tableau $row dans l'objet - utilisé en interne
		if (is_array($row)) {
			foreach($row as $key => $value) {
				$this->$key = stripslashes($value) ;
			}
		}
		else return false ;
	}
	
	final public function save() {
		//enregistre dans la base mysql l'objet, soit en création (insert) soit en modification (update), suivant ce qui est nécessaire
		//fonctionnement détaillé : la fonction repose sur une condition centrale (if/else) qui teste la valeur de $this->num. Si celle-ci n'a pas été définie
	   $fields 	= mysql_list_fields(mysqldb::$base, $this->table) ;
		$columns 	= mysql_num_fields($fields) ;
		if (!empty($this->num)) {
			//mode "update"
	    	//on écrit la requête maintenant
			$q = "UPDATE ".$this->table." SET num ='$this->num'" ;
			for ($i = 1 ; $i < $columns ; $i++) {
				$nom 	= mysql_field_name($fields, $i) ;
				$value 	= addslashes($this->$nom) ; 
				$q 		.= ", $nom='".$value."'" ;
			}
			$q .= " WHERE num='$this->num'" ;
			//on envoie la requête ainsi composée
			return mysqldb::send($q);
		}
		else {
			//mode "save"
			$q = "INSERT INTO ".$this->table." VALUES (0" ;
			for ($i = 1; $i < $columns; $i++) {
				$nom 	= mysql_field_name($fields, $i) ;
				$nom 	= addslashes($this->$nom) ;
				$q 		.= ", '".$nom."'" ;
			}
			$q .= ")" ;
			//on envoie la requête ainsi composée
			mysqldb::send($q) ;
			//on détermine ainsi $this->num
			$this->num = mysql_insert_id() ;
			return $this->num ;
		}
	}

}
?>
