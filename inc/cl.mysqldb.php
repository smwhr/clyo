<?php
class mysqldb {
	
	public static $inst ;
	public static $prefixe ;
	private static $id;
	public static $base;

	public function __construct($user,$host,$pass,$db,$pref) {
      self::$prefixe = $pref ;
      self::$base = $db ;
		self::$id = mysql_connect($host, $user, $pass) or die ("Erreur de connection MYSQL");
		mysql_select_db(self::$base, self::$id); 
	}
	
	public function __destruct() {
		$this->close() ;
	}	
	
	public static function unik($query) {
		$query = mysqldb::send($query);
		$query = @mysql_result($query, 0, 0);
		return $query;
	}
	
	public static function send($query) {
		$req = mysql_query($query, self::$id);
		if ($req) {
			return $req;
		}
		else {	
			echo("<p id='send'>Erreur dans la requ&ecirc;te : $query </p>");
			return 0;
		}
	}
	
	public static function getline($table, $num) {
		$query = "SELECT * FROM "."$table WHERE num=$num";
		$query = mysqldb::send($query);
		return @mysql_fetch_assoc($query);
	}
	
	public static function deleteline($table, $num) {
		$query = "DELETE FROM ".$table." WHERE num=$num";
		$query = mysqldb::send($query);
		return $query;	
	}
	
	public static function mdate($date) {
		list($annee,$mois,$jour)=split("-",$date);
		return "$jour/$mois/$annee";
	}
	
	public static function ysdate($date) {
		list($annee,$mois,$jour)=split("-",$date);
		/*$moys = array("janvier","f&eacute;vrier","mars","avril","may","juyn","juyllet","ao&ucirc;t","septembre","octobre","novembre","d&eacute;cembre") ;
		$mois = $moys[((int) $mois)-1] ;
		if ($annee > 2000 && $annee < 2021) {
			$an = array("i","ii","iii","iv","v","vi","vii","viii","ix","x","xi","xii","xiii","xiv","xv","xvi","xvii","xviii","xix","xx") ;
			$annee = "de l'an <span class='annee'>".$an[((int) $annee)-2001]."</span> apr&egrave;s la seconde D&eacute;vastatyon" ;
		}
		if ($jour == 01) $jour = "1<sup>er</sup>" ;
		else $jour = (int) $jour ;
		return $jour." ".$mois." ".$annee ; */
		return ysdate($jour,$mois,$annee) ;
	}
	
	public static function close() {
		mysql_close(self::$id);
		//$this->connect = 0;
	}
	
	public static function setdata($table, $data, $value, $num) {
		$query = "UPDATE ".$table." SET $data='$value' WHERE num=$num";
		$query = mysqldb::send($query);
		return $query;	
	} 
	
	// La méthode instance
    public static function instance($user="",$host="",$pass="",$base="",$prefixe="") {
        if (!isset(self::$inst)) {
            self::$inst = new mysqldb($user,$host,$pass,$base,$prefixe) ;
        }
        return self::$inst;
    }

    // Prévient les utilisateurs sur le clônage de l'instance
    public function __clone()
    {
        trigger_error("Le clônage d'une instance _mysqldb n'est pas autorisé.", E_USER_ERROR);
    }	
	
}
?>
