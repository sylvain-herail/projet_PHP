Résumé : Ce fichier reprends de façon bref les diverses fonctionnalitées du site ainsi que ses composants.
(A lire si vous avez un peu de temps à perdre ou que vous n'auriez pas le temps d'explorer et de comprendre le code par exemple).


------------------------------------------------------------------------------------------------------------------------------------

Site de news en php composé des fonctionnalitées suivantes : 

Du coté administrateur : 
-On peut se connecter en tant qu'admin gràce aux mot de passe et au login se trouvant dans la base de donnée gràce au formulaire de connexion(pas de cryptage).

Lorsque nous sommes connectés nous pouvons :
	-Configurer le nombre de news à afficher sur la page gràce à un formulaire.
	-Ajouter un flux RSS de news
	-Supprimer un flux RSS de news
	-Pour finir nous pouvons bien sur nous déconnecter

------------------------------------------------------------------------------------------------------------------------------------

Du coté visiteurs : (remarques il n'y a pas de connection pour les users, ils sont en faite simplement visiteurs) :

-Les visiteurs sont donc là uniquement pour visionnés les news affichées sur la page principale (qui sont récupérées dans la base de donnée) et éventuellement cliquer sur les liens pour étre redirigé sur la page des sites en question.

------------------------------------------------------------------------------------------------------------------------------------

Ce site est composé des grands fichiers suivant :


-Un fichier config comprenant un autoloader permettant de charger tout les classes dans le projet et un fichier de config pourles variables globales.


-Un fichier controleur (couche métier):
	Composé de : 	-Un front controleur pour définir les rôles et les actions.
					-Un controleur Admin permettant de découper toutes les actions possibles en tant qu'administrateur.
					-Un controleur User permetttant de découper toutes les actions possibles en tant que visiteur.
					-Une classe Admin pour stocker et gérer la connexion.
					-Une classe News pour gérer les News.
					-Une classe validation pour la validation de toutes les variables suceptibles d'étre modifieées.
					-Un XmlParser permettant de lire le contenu d'un fichier xml et de créer les news trouvées dans le fichier.


-Un fichier documents composé d'un simple cas d'utilisation du cite.


-Un fichier modele (persistance des données) :
	Composé de :	-Un modéle pour chaque rôle Admin,User permettant de gérer les données utilisées par ces différents rôles.
					-Une classe Gateway pour accéder à chacunes des tables de la base de donnée et y manipuler les données.


-Un fichier de vues : 
	Composé de :	-Un dossier bootstrap permettant la conception des vues avec son utilisation (style)
					-Un fichier cover, le CSS de la page
					-Une page d'erreur utiliser a chaque rencontre de probléme dans le site
					-Une page principale contenant le visuel du site bien sur.

dbsyherail.sql est la base de donnée exporter de phpmyadmin.
L'index.php et le fichier appelé pour avoir accés au site dans tous les cas.


