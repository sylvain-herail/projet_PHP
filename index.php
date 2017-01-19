<?php
// chargement de la config
require_once(__DIR__.'/config/config.php');

//chargement de l'autoloader pour charger automatiquement les classes
require_once(__DIR__.'/config/Autoload.php');
Autoload::charger();

// require("controleur/Front.php");
session_start();
new Front();

?>