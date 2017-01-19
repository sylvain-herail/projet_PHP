
<?php

class CtrlUser{


	private $dVueErreur = array();
	private $modele;

	public function __construct(){

		$this->modele = new ModeleUser();

			try {
				$action=$_REQUEST['action'];
		
				switch($action){
					case NULL:
					$this->majNews();
					$this->affichNews();
					break;

					default:
					$dVueErreur[] = "Action invalide";
					require("vue/error.php");
			}


			} catch (PDOException $e) {
				$dVueErreur[] = "Erreur inattendue!! ";
				require("vue/error.php");

			} catch (Exception $e2){
				$dVueErreur[] = "Erreur inattendue!! ";
				require("vue/error.php");
			}
	}

	public function affichNews(){
		try{
			$nbNews = $this->modele->getNbNews();
			$nbNewsParPage = $this->modele->getNbNewsParPage();
			
			$nombreDePages=ceil($nbNews/$nbNewsParPage);


			if(isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']) == 1){
				
				if ($_GET['page'] > $nombreDePages) {
					$pageActuelle=$nombreDePages;
				}
				else{
					$pageActuelle = $_GET['page'];
				}
			}
			else{
				$pageActuelle=1;
			}

			$firstNews = ($pageActuelle - 1) * $nbNewsParPage;

			$tabNews = $this->modele->get_allNews($firstNews,$nbNewsParPage);

			require("vue/mainPage.php");
		}
		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}
	}

	public function majNews(){
		try{
			$tabLien = $this->modele->findAllLink();
			//je parse tous les flux contenu dans la base
			foreach ($tabLien as $ligne) {
				$parser = new XmlParser($ligne['lien']);
				$parser ->parse();
			}

		}
		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}
	}
}


?>

