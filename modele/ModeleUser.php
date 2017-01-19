<?php

class ModeleUser {

	private $newsGateway = NULL;
	private $fluxGateway = NULL;
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
			throw new Exception("Connection incorrecte");
		}
		$this->fluxGateway = new FluxGateway($this->con);
		if (is_null($this->fluxGateway)) {
			throw new Exception("Impossible de créer un fluxGateway");
		}
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

	public function getNbNews(){
		try{
			$nbNews = $this->newsGateway->nbNews();
		}
		catch (Exception $e){
			throw $e;
		}
		return $nbNews;
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