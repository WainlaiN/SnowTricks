# SnowTricks

<a href="https://codeclimate.com/github/WainlaiN/SnowTricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/98ddb7b3a7999e75e452/maintainability" /></a>

# P6-SnowTricks

Création d'un site communautaire de partage de figures de snowboard via le framework Symfony.

## Environnement utilisé durant le développement
* Symfony 4.2.1
* Composer 1.8.0
* Bootstrap 4.2.1
* jQuery 3.3.1
* PHPUnit 7.5.1
* WampServer 3.1.6
    * Apache 2.4.37
    * PHP 7.3.0
    * MySQL 5.7.19

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/WainlaiN/SnowTricks
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données ou votre serveur SMTP ou adresse mail dans le fichier `.env` :
```
DATABASE_URL=mysql://LOGIN:PASSWORD@127.0.0.1:3306/Snowtricks?serverVersion=5.7
```
3. Configurez également l'envoi de mail dans le fichier `.env` :
```
DATABASE_URL=mysql://LOGIN:PASSWORD@127.0.0.1:3306/Snowtricks?serverVersion=5.7
```
3. Téléchargez et installez les dépendances back-end du projet avec [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Téléchargez et installez les dépendances front-end du projet avec [Yarn](https://www.npmjs.com/get-npm) :
```
    Yarn install
```
5. Créer un build d'assets (grâce à Webpack Encore) avec [Yarn](https://www.npmjs.com/get-npm) :
```
    Yarn build
```
6. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
7. Créez les différentes tables de la base de données en appliquant les migrations :
```
    php bin/console doctrine:migrations:migrate
```
8. (Optionnel) Installer les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
9. Le projet est maintenant installé, vous pouvez tester l'application.