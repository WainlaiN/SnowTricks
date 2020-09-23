# SnowTricks

<a href="https://codeclimate.com/github/WainlaiN/SnowTricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/98ddb7b3a7999e75e452/maintainability" /></a>

# P6-SnowTricks

Création d'un site communautaire de partage de figures de snowboard via le framework Symfony.

## Description

Vous êtes chargé de développer le site répondant aux besoins de Jimmy.
Vous devez ainsi implémenter les fonctionnalités suivantes : 
```
* un annuaire des figures de snowboard, vous pouvez vous inspirer de la liste des figures sur Wikipédia.
  Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes ;
* la gestion des figures (création, modification, consultation) ;
* un espace de discussion commun à toutes les figures.
```
Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :
```
* la page d’accueil où figurera la liste des figures ; 
* la page de création d'une nouvelle figure ;
* la page de modification d'une figure ;
* la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).
```

## Prérequis

Choisissez votre serveur en fonction de votre système d'exploitation:

    - Windows : WAMP (http://www.wampserver.com/)
    - MAC : MAMP (https://www.mamp.info/en/mamp/)
    - Linux : LAMP (https://doc.ubuntu-fr.org/lamp)
    - XAMP (https://www.apachefriends.org/fr/index.html)

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/WainlaiN/SnowTricks
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données/serveur SMTP/adresse mail dans le fichier `.env.local` (faire une copie du .env.test) :
```
    DATABASE_URL=mysql://DB_LOGIN:DB_PASSWORD@127.0.0.1:3306/Snowtricks?serverVersion=5.7

    MAILER_DSN=gmail://email:password@default
```
3. Téléchargez et installez les dépendances back-end du projet avec [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Téléchargez et installez les dépendances front-end du projet avec [Yarn](https://classic.yarnpkg.com/en/docs/install) :
```
    Yarn install
```
5. Créer un build d'assets (grâce à Webpack Encore) avec [Yarn](https://classic.yarnpkg.com/en/docs/install) :
```
    Yarn build (en prod)
    Yarn watch (en dev)
```
6. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
7. Créez les tables de la base de données :
```
    php bin/console doctrine:schema:update --force
```
   
8. (Optionnel) Installer les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
9. Lancement du serveur :
```
    php bin/console server:run
```
9. Le projet est maintenant installé, vous pouvez tester l'application sur cette URL:
```
    http://127.0.0.1:8000
```

## Auteur

**Dupriez Nicolas** - Étudiant à Openclassrooms Parcours suivi Développeur d'application PHP/Symfony