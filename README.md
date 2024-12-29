# ANDRE WANG - NICOLAS SUNG - ALAIN SLIMAN

## Procédure d'installation

1. clone le repo `https://github.com/wngandre/Projet_Symfony_Ecom.git`
2. modifier le `.env` avec vos accès à la base de données
3. installer les dépendances manquantes : `composer update`
4. créer la base de données : `php bin/console d:d:c`
5. exécuter les migrations : `php bin/console d:m:m`
6. lancer le serveur symfony : `symfony server:start`

## Procédure pour etre admin

1. aller dans RegistrationController.php
2. enlever le commentaire ligne 23 pour etre admin
3. s'inscrire
