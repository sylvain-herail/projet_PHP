<html>
<body>
<?php

class CtrlAdmin{

	private $modele;
	private $dVueErreur = array();

	public function __construct(){
		
		$this->modele = new ModeleAdmin();
		
		try {
			$action=$_REQUEST['action'];

			switch($action){

				case NULL:
					$this->majNews();
					$this->affichNews();
					break;

				case "ajouter":
					$this->ajouter();
					break;

				case "changerNombreDeNewsParPage":
					$this->changerNombreDeNewsParPage();
					break;

				case "supprimer":
					$this->supprimer();
					break;

				case "signIn":
					$this->signIn();
					break;

				case "deco":
					$this->deconnexion();
					break;

				default:
					$dVueErreur[] = "Erreur d'appel php";
					require("vue/error.php");
					break; 
			}


		} catch (PDOException $e) {

			$dVueErreur[] = "Erreur inattendue!! ";
			require("vue/error.php");
		}
		catch (Exception $e2){
			$dVueErreur[] = 'Exception reçue : ' .$e2->getMessage(). "\n";
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

	public function ajouter(){
		$lien = $_POST['ajoutLien'];

		Validation::validateItem($lien);
		
		try{
			$this->modele->ajouterLien($lien);
		}
		catch (PDOException $e) {
			$dVueErreur[] = "Erreur inattendue!! ";
			require("vue/error.php");

		}
		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}

		$this->affichNews();
	}

	public function supprimer(){
		$lien = $_POST['supprimerLien'];

		Validation::validateItem($lien);
		
		try{
			$this->modele->supprimerLien($lien);
		}
		catch (PDOException $e) {
			$dVueErreur[] = "Erreur inattendue!! ";
			require("vue/error.php");

		}
		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}

		$this->affichNews();
	}

	/*****************************************Je test si l'adminitrateur sign in correctement *********************/
	public function signIn(){
		
		$login=$_POST['login'];
		$pwd=$_POST['pwd'];

		Validation::validForm($login,$pwd,$dVueErreur);
		
		try{
			$this->modele->connexion($login,$pwd);
			global $a;
			$a = $this->modele->isAdmin();
		}
		catch (PDOException $e) {
			$dVueErreur[] = "Erreur inattendue!! ";
			require("vue/error.php");

		}
		catch (Exception $e){
			$dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
			require("vue/error.php");
		}
		
		$this->affichNews();
		
	}

	public function deconnexion(){
		$this->modele->deconnexion();
		$this->affichNews();
	}

	public function changerNombreDeNewsParPage(){
		$nbNewsParPage = $_POST['nbNewsParPage'];
		try{
			$this->modele->setNbNewsParPage($nbNewsParPage);
			$this->affichNews();
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
</body>
</html>
