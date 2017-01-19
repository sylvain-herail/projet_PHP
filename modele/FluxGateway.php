<?php


class FluxGateway{
    private $con;

    public function __construct(Connection $con){
        $this->con=$con;
    }

    //Insert un flux dans la base de donnée
    public function ajouterLien($lien){
        $query='INSERT INTO tflux VALUES(:lien)';
        $res=$this->con->executeQuery($query,array(
            ':lien'=>array($lien,PDO::PARAM_STR)));
        if(!$res) {
            throw new Exception("Pb insertion failed !");
        }
    }
    //Supprime un flux dans la base de donnée
    public function supprimerLien($lien){
        $query='DELETE FROM tflux where lien=:lien';
        $res=$this->con->executeQuery($query,array(
            ':lien'=>array($lien,PDO::PARAM_STR)));
        if(!$res) {
            throw new Exception("Pb insertion failed !");
        }
    }

    //Récupére tous les flux RSS enregistrer dans la base de donnée
    public function findAllRSS(){
        $query='SELECT lien FROM tflux';
        $res=$this->con->executeQuery($query);
        if(!$res){
            throw new Exception("Pb impossible de récupérer les liens de la base");
        }
        $res=$this->con->getResults();
        return $res;
    }
}
?>