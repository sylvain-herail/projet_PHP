<?php



class News{
    private $url;
    private $dateInser;
    private $titre;

    public function __construct($url,$dateInser,$titre){
        $this->url=$url;
        $this->dateInser=$dateInser;
        $this->titre=$titre;
    }

    public function getUrl(){
        return $this->url;
    }
    public function getDateInser(){
        return $this->dateInser;
    }
    public function getTitre(){
        return $this->titre;
    }

    public function setUrl($url){
        $this->url=$url;
    }
    public function setDateInser($dateInser){
        $this->dateInser=$dateInser;
    }
    public function setTitre($titre){
        $this->titre=$titre;
    }
}