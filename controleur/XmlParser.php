<?php
 
class XmlParser {
    private $path;
    private $result;
    private $news=null;
    private $title;
    private $url;
    private $dateInser;
    private $modele;
    private $inBD;
     
    public function __construct($path)
    {
        $this -> path = $path;
        $this->modele = new ModeleAdmin();
        $this->inBD = $this->modele->getAllUrl();
    }
     
    public function getResult() {
        return $this->result;
    }

    public function parse()
    {
        ob_start();
        $xml_parser = xml_parser_create();//création d'un analyseur de fichier xml
        xml_set_object($xml_parser, $this);//signifie que cette classe "WmlParserExample1" devient annalyseur de fichier xml
        xml_set_element_handler($xml_parser, "startElement", "endElement");//affecte les fonctions qui vont gérer les débuts et fin de balise xml
        xml_set_character_data_handler($xml_parser, 'characterData');// affecte la fonctions qui reécupère les données
        if (!($fp = fopen($this -> path, "r"))) {//ouverture en lecture du fichier xml
            die("could not open XML input");//die est un alias de exit
        }
 
        while ($data = fread($fp, 4096)) {//lecture et récup des données dans data (4096 taille en octets)
            if (!xml_parse($xml_parser, $data, feof($fp))) {//commence l'annalyse du fichier xml avec l'annalyseur, une partie des donées data un signal de fin de fichier (si true alors data et le dernier morceau a analyser)
                die(sprintf("XML error: %s at line %d",
                            xml_error_string(xml_get_error_code($xml_parser)),
                            xml_get_current_line_number($xml_parser)));// si l'annalyseur ne marche pas retourne 0 j'affiche une erreur
            }
        }
        //dans les autres cas
        $this -> result = ob_get_contents();//je recup dans result le contenu du tampon de sortie
        ob_end_clean();//Détruit les données du tampon de sortie et éteint la temporisation de sortie
        fclose($fp);//fermeture du fichier
        xml_parser_free($xml_parser);//détruit l'annalyseur xml
    }
     
    private function startElement($parser, $name, $attrs){
        echo "start element avec $name<br> ";
        if($name == "ITEM"){
            echo "j'ai un item<br>";
            $this->news = new News(null,null,null); 
        }
        if($name == "URL" || $name == "LINK"){
            echo "j'ai un url<br>";
            $this->url = true;
        }
        if($name == "TITLE"){
            echo "j'ai un titre<br>";
            $this->title = true;
        }
        if($name == "PUBDATE"){
            echo "j'ai une date<br>";
            $this->dateInser = true;
        }
    }

    private function endElement($parser, $name){
        echo "endelement : $name<br>";
        if($name == "URL" || $name == "LINK"){
            echo "je ferme l'url<br>";
            $this->url = false;
        }
        if($name == "TITLE"){
            echo "je ferme un titre<br>";
            $this->title = false;
        }
        if($name == "PUBDATE"){
            echo "je ferme une date<br>";
            $this->dateInser = false;
        }
        if($name == "ITEM"){
            echo "ouou";
            var_dump($this->news);
            if(!is_null($this->news) && !is_null($this->news->getUrl()) && !is_null($this->news->getTitre()) && !is_null($this->news->getDateInser())){
                try{
                    $this->modele->insert($this->news);
                }
                catch (Exception $e){
                    $dVueErreur[] = 'Exception reçue : ' .$e->getMessage(). "\n";
                    require("vue/error.php");
                }
            }
        }
    }
     
    private function characterData($parser, $data){
        echo "character avec $data<br>";
        $data = trim($data);// trim supprime les espaces
         
        if (strlen($data) > 0 && !(in_array($data, $this->inBD))){
            if ($this->url){  
                if(!is_null($this->news)) {
                    $this->news->setUrl($data);
                    echo "url : $data<br>";
                }
            }
            if($this->title){
                if(!is_null($this->news)) {
                    $this->news->setTitre($data);
                    echo "Titre : $data<br>";
                }
                
            }
            if($this->dateInser){
                if(!is_null($this->news)) {
                    $this->news->setDateInser($data);
                    echo "dateInser : $data<br>";
                }
            }
        }
    }
}
?>