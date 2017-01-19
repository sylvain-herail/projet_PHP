<html>
<body>
<?php

class Front{

	private $listeAction_admin= array('deco','supprimer','ajouter','signIn','changerNombreDeNewsParPage');

	public function __construct(){
	//variable globale pour la réutiliser dans la vue
		global $a;
		$action=$_REQUEST['action'];

		try{
			$modele = new ModeleAdmin();
			
			$a = $modele->isAdmin();
			
			if(is_null($a)){
				if(!in_array($action, $this->listeAction_admin)){
					new CtrlUser();
				}
				else if($action == "signIn"){
					new CtrlAdmin();
				}
				else{
					$dVueErreur[] = "Vous n'avez pas accés à c'est action car vous n'étes pas administrateur ! ";
					require("vue/error.php");
				}
			}
			else{
				new CtrlAdmin();
			}
		}

		catch (PDOException $e) {
			$dVueErreur[] = "Erreur inattendue!! ";
			require("vue/error.php");
		}

		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}

	}
}
?>
</body>
</html>
