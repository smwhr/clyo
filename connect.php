<?

function print_error($case){
    switch($case){
    case 0 :
        echo "Email undefined";
        break;
    case 1 :
        echo "Password undefined";
        break;    
    }
    echo "<br /><a href=\"./main/toconnect.php\">Retour</a>";
    exit;
}

function wrongid($tracer="") {

		echo "<div id=\"error\">\n" ;
		echo "Indentification incorrecte. <br />\n" ;
		echo "<a href=\"./main/toconnect.php\">Retour</a>\n" ;
		echo "</div>\n" ;
		exit;
}

$email = isset($_POST['email']) ? $_POST['email'] : print_error(0);
$password = isset($_POST['password']) ? $_POST['password'] : print_error(1);
$referer = (isset($_POST['referer'])&& ($_POST['referer']<>""))? $_POST['referer'] : "./main/index.php";

//on enregistre l'email dans un cookie si la personne le désire
if(isset($_POST['souvenir'])) setcookie("email",$email,time()+60*60*24*10);

require_once("./inc/centrale.php");
require_once("./inc/cl.personne.php");

$p = new personne ;
$p->select("WHERE email=\"$email\"") ;


	if ($p->lenen()>=1){
		$p->next() ;
	}else{
		wrongid("name") ;
	}
	
	if ($p->password == md5($password)){
		session_start() ;
		$_SESSION['clyoident'] = $p->num ;
		redirect($referer) ;
	}else{
		wrongid("password") ;
	}
?>
