<?php



class NewsGateway{
    private $con;

    public function __construct(Connection $con){
        $this->con=$con;
    }

    //Insert une ligne de données avec les parametres suivants
    public function insert($url,$dateInser,$titre){
        $query='INSERT INTO Tnews VALUES(:dateInser,:url,:titre)';
        $res=$this->con->executeQuery($query,array(
            ':url'=>array($url,PDO::PARAM_STR),
            ':dateInser'=>array($dateInser,PDO::PARAM_STR),
            ':titre'=>array($titre,PDO::PARAM_STR)));
        if(!$res) {
            throw new Exception("Pb insertion failed !");
        }
    }

    //Affiche la table Tnews
    public function findAll($firstNews,$nbNewsParPage){
        $query="SELECT * FROM Tnews ORDER BY dateInser DESC LIMIT $firstNews,$nbNewsParPage";
        $res=$this->con->executeQuery($query);
        if(!$res){
            throw new Exception("Pb affichage de la table Tnews !");
        }
        $res=$this->con->getResults();

        return $res;
    }

    //Récupére tou les URL des sites déja enregistré dans la base
    public function findAllUrl(){
        $query='SELECT url FROM Tnews';
        $res=$this->con->executeQuery($query);
        if(!$res){
            throw new Exception("Pb impossible de récupérer les url des news de la base");
        }
        $res=$this->con->getResults();
        return $res;
    }

    

    //Modifie le titre de la ligne avec l'URL passée en argument
    public function updateTitre($url,$modif){
        $query='UPDATE Tnews SET titre=:titre WHERE url=:url';
        $res=$this->con->executeQuery($query,array(':url'=>array($url,PDO::PARAM_STR),':titre'=>array($modif,PDO::PARAM_STR)));
        if(!$res){
            throw new Exception("Pb impossible de modifier le titre de la news d'url :".$url);
        }
    }

    //Compte le nombre de news
    public function nbNews(){
        $query='SELECT count(*) FROM Tnews';
        $res=$this->con->executeQuery($query);
        if(!$res){
            throw new Exception("Pb dans le nombre de news !");
        }
        $res=$this->con->getResults();
        foreach ($res as $value) {
            return $value[0];
        }
    }

    //récupére le nombre de news a afficher sur une page
    public function getNbNewsParPage(){
        $query='SELECT nbNewsParPage FROM Tadmin';
        $res=$this->con->executeQuery($query);
        if(!$res){
            throw new Exception("Pb impossible de récupérer le nombre de news a afficher dans la page");
        }
        $res=$this->con->getResults();
        foreach ($res as $value) {
            return $value[0];
        }
    }
    //change le nombre de news a afficher sur une page
    public function setNbNewsParPage($nbNewsParPage){
        $query='UPDATE Tadmin SET nbNewsParPage=:nbNewsParPage';
        $res=$this->con->executeQuery($query,array(':nbNewsParPage'=>array($nbNewsParPage,PDO::PARAM_STR)));
        if(!$res){
            throw new Exception("Pb impossible de change le nombre de news a afficher dans la page");
        }
        
    }
}

?>