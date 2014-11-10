<?php
class droit extends alpha{

	public $nom ;
	
	public function getbyname($name){
	    return $this->get("nom",$name) ;
	}
	    
   public function secure($pnum){
       $possede = new poss_droit ;
       $possede->select("WHERE personne=$pnum AND droit=$this->num");
       return ($possede->lenen()>=1) ;
   }
    
   public function alloue($pnum){
       $possede = new poss_droit();
       $possede->select("WHERE personne=$pnum AND droit=$this->num");
       if($possede->lenen()>=1) return true;
       $possede->num = 0;
       $possede->droit = $this->num;
       $possede->personne = $pnum;
       return $possede->save();
   }
    
   public function retire($pnum){
       $possede = new poss_droit();
       $possede->select("WHERE personne=$pnum AND droit=$this->num");
       if($possede->lenen()>=1){
           $possede->next();
           return $possede->delete();
       }else{
           return true;
       }
   }
    
	public function create_droit() {
	}	
	
	public static function check($p,$droit,$page="../main/index.php") {
		$d = new droit ;
		$d->get("nom",$droit) ;
		if (!$d->secure($p->num)) redirect($page) ;
	}

	public static function hasgot() {
		$d = new droit ;		
		$n = func_num_args() ;
		$total = false ;
		if ($n >= 1) {
			$p = func_get_arg(0) ;
			for ($i=1 ; $i<$n ; $i++) {
				$droit = func_get_arg($i) ;
				$d->get("nom",$droit) ;
				if ($d->secure($p->num)) $total = true ;
			}
		}
		return $total ;
	}

}

?>
