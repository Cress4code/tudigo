PROCEDURE D’INSTALLATION 

1-	Récupérer les codes sources  depuis : https://github.com/Cress4code/tudigo;
2-	Décompresser le fichier « tudigo.zip » ;
3-	Rendez vous sur l’espace disque lié à theinnovativewoman.com;
4-	Copier le contenu du dossier   “tudigo”  à la racine de votre seveur 
5-	Ouvrir le fichier wp_config.php et  changer les valeurs  DB_NAME,DB_USER, DB_PASSWORD,DB_HOST par les information de votre serveur de base de donnée
6-	Créer une base de donnée sur votre serveur « exemple : tudigo » ou choisir un existant
7-	Ouvrir le fichier « basededonnee.sql » avec votre éditeur de texte préféré.
8-	Rechercher http://nakayobenin.com/tudigo/ et remplacer par  http://theinnovativewoman.com/ 
9-	Sauvegarder le fichier
10-	Depuis l’interface web de votre serveur de base de donnée, importer le fichier de base de donnée.
11-	Tester votre site. La page d’accueil devrait normalement s’afficher correctement
12-	Aller su http://theinnovativewoman.com/wp-admin/ avec les identifiants admin admin 
13-	Cliquer sur extension ou pluggins 
14-	Ajouter l’extension Yoast SEO


IMPORTANT

POUR QUE LA REDURECTION MARCHE,
15- OUVRIR le fichier .htaccess, effacer "tudigo/" si vous avez installé le projet à la racine du serveur

POUR L'ENVOI DES EMAILS

15- Renseigner  les informations de votre serveur MAIL  en remplissant les champs sous l'onglet mail configuration
http://theinnovativewoman.com/wp-admin/admin.php?page=options-generales

