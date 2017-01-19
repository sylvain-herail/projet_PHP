<?php


class Admin{
	private $login=NULL;
	private $role=NULL;

	public function __construct($role, $login){
		$this->login = $login;
		$this->role = $role;
    }
}