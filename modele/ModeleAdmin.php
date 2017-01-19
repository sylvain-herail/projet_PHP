<?php

class ModeleAdmin {

	private $fluxGateway = NULL;
	private $newsGateway = NULL;
	private $adminGateway = NULL;
	private $con = NULL;
	public function __construct(){

		if(is_null($this->con)){
			$this->con = new Connection('mysql:host=localhost;dbname=dbsyherail','root','');
		}

		if (is_null($this->con)) {
			throw new Exception("Connection incorrecte");
			
		}
		$this->newsGateway = new NewsGateway($this->con);
		if (is_null($this->newsGateway)) {
			throw new Exception("Impossible de créer un newsGateway");
		}
		$this->adminGateway = new AdminGateway($this->con);
		if (is_null($this->adminGateway)) {
			throw new Exception("Impossible de créer un adminGateway");
		}
		$this->fluxGateway = new FluxGateway($this->con);
		if (is_null($this->fluxGateway)) {
			throw new Exception("Impossible de créer un fluxGateway");
		}
	}

	public function connexion($login,$password){
		try{
			$this->adminGateway->check_admin($login,$password);
		}
		catch (Exception $e){
			throw $e;
		}
		$_SESSION['role']='admin';
		$_SESSION['login']=$login;
	}

	public function deconnexion(){
		global $a;
		$a=null;
		session_unset();
		session_destroy();
		$_SESSION = array();
	}

	public function getNbNews(){
		try{
			$nbNews = $this->newsGateway->nbNews();
		}
		catch (Exception $e){
			throw $e;
		}
		return $nbNews;
	}

	public function get_allNews($firstNews,$nbNewsParPage){
		try{
			$tabNews = $this->newsGateway->findAll($firstNews,$nbNewsParPage);
		}
		catch (Exception $e){
			throw $e;
		}
		return $tabNews;
	}

	public function isAdmin(){

		if (isset($_SESSION['login']) && isset($_SESSION['role'])){
			$login=Validation::validateItem($_SESSION['login']);
			$role=Validation::validateItem($_SESSION['role']);
			return new Admin($_SESSION['role'],$_SESSION['login']);
		}
		else{
			return NULL;
		}
	}

	public function getNbNewsParPage(){
		try{
			$nbNewsParPage = $this->newsGateway->getNbNewsParPage();
		}
		catch (Exception $e){
			throw $e;
		}
		return $nbNewsParPage;
	}

	public function setNbNewsParPage($nbNewsParPage){
		try{
			$this->newsGateway->setNbNewsParPage($nbNewsParPage);
		}
		catch (Exception $e){
			throw $e;
		}
	}

	public function insert($news){
		try{
			$this->newsGateway->insert($news->getUrl(),$news->getDateInser(),$news->getTitre());
		}
		catch (Exception $e){
			throw $e;
		}
	}

	public function getAllUrl(){
		try{
			$res=$this->newsGateway->findAllUrl();
			return $res;
		}
		catch (Exception $e){
			throw $e;
		}
	}

	public function ajouterLien($lien){
		try {
			$this->fluxGateway->ajouterLien($lien);
		}
		catch (Exception $e){
			throw $e;
		}
	}

	public function supprimerLien($lien){
		try {
			$this->fluxGateway->supprimerLien($lien);
		}
		catch (Exception $e){
			throw $e;
		}
	}
	
	public function findAllLink(){
		try{
			$tabLien = $this->fluxGateway->findAllRSS();
		}
		catch (Exception $e){
			throw $e;
		}
		return $tabLien;
	}
}