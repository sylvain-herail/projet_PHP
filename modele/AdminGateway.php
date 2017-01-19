<?php


class AdminGateway{
    private $con;

    public function __construct(Connection $con){
        $this->con=$con;
    }

    //Vérife que le mot de passe et le login correspondent bien a ceux dans la base
    public function check_admin($login,$password){
        $query='SELECT * FROM Tadmin WHERE login=:login AND password=:password';
        $res=$this->con->executeQuery($query,array(
            ':login'=>array($login,PDO::PARAM_STR),
            ':password'=>array($password,PDO::PARAM_STR)));

        $res=$this->con->getResults();

        if(!$res) {
            throw new Exception("Pb : mot de passe ou login incompatible !");
        }
    }
}
?>