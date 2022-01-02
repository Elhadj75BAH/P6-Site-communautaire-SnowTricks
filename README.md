# Site-communautaire-SnowTricks
Création d'un site collaboratif pour faire connaître le snowbord auprès du grand public.

En utilisation le framework symfony. 

# Requirements:
 - Apache 2.4

 - PHP 7.2

 - MySQL 5.7

 - Composer
  
 - Npm

# Steps :

1 Clonez le dépôt depuis Github.

2 Installez les dépendances du projet avec composer install

3 npm install pour installer les librairies de javascript pour les collections du formulaire 

4 N'oubliez pas de remplir le fichier .env de votre base de donnée comme ci dessous par exemple:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

5 Toujours dans le .env Veuillez configurer Le MAILER_DSN comme ci-dessous par exemple:
MAILER_DSN=gmail://example@gmail.com:password@default

MAILER_FROM_ADRESS=example@gmail.com

6 Créer la base de donnée si cette base n'hesiste pas encore 
- bin/console doctrine:database:create

 Mettre a jour les entites en base de donnée
- bin/console doctrine:schema:update -f

7  Lance les fixtures pour avoir des données de test en base
- bin/console doctrine:fixtures:load
- ou Télécharge directement le fichier "dbProject.sql" de la base de donnée qui se trouve à la racine du projet 

# Link CodeClimate

- https://codeclimate.com/github/Elhadj75BAH/P6-Site-communautaire-SnowTricks
