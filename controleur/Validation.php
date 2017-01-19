<?php


class Validation{
		
	static function validate($tab){
		foreach($tab as $ligne){
			$ret[]=filter_var($ligne['valeur'],validateItem($ligne['type']));
		}
		return $ret;
	}
	
	static function validateItem($var){
		$res=false;
		$type = gettype($var);
		switch ($type){
			case 'email':
				$res=filter_var($var,FILTER_VALIDATE_EMAIL);
				break;
			case 'integer':
				$res=filter_var($var,FILTER_VALIDATE_INT);
				break;
			case 'boolean':
				$res=filter_var($var,FILTER_VALIDATE_BOOLEAN);
				break;
			case 'ip':
				$res=filter_var($var,FILTER_VALIDATE_IP);
				break;
			case 'url':
				$res=filter_var($var,FILTER_VALIDATE_URL);
				break;
			case strlen($var)==0:
				$res=false;
				break;
			default:
				$res = true;
				break;
		}
		return $res;
	}

	static function validateRegExp($exp,$var){
		if(preg_match($exp, $var)){
			return true;
		}
		else{
			return false;
		}
	}

	static function val_action($action) {

		if (!isset($action)){
			throw new Exception('pas d\'action');
		}
	}

	static function validForm($login,$pwd,&$dVueErreur){
		if(!Validation::validateItem($login) || !Validation::validateItem($pwd)){
			$dVueErreur[] = "Erreur mot de passe ou login invalide";
			//login accepte 3 a 16 caracs : maj,min,chiffre ou _
			//le mot de passe prend 4 a 16 carcs tous les alphanumérique
			if(!(Validation::validateRegExp(" /^[a-zA-Z0-9_]{3,16}$/ ",$login)) || !(Validation::validateRegExp('`^([[:alnum:]]{4,16})$`',$pwd))){
				$dVueErreur[] = "Erreur mot de passe ou login invalide";
			}
		}
	}
}

?>

