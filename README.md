# SnowTricks

<a href="https://codeclimate.com/github/WainlaiN/SnowTricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/98ddb7b3a7999e75e452/maintainability" /></a>

# P6-SnowTricks

Création d'un site communautaire de partage de figures de snowboard via le framework Symfony.


## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/WainlaiN/SnowTricks
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données /serveur SMTP/adresse mail dans le fichier `.env.local` (faire une copie du .env) :
```
DATABASE_URL=mysql://LOGIN:PASSWORD@127.0.0.1:3306/Snowtricks?serverVersion=5.7

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
7. Créez les différentes tables de la base de données en appliquant les migrations :
```
    php bin/console doctrine:migrations:migrate
```
   
8. (Optionnel) Installer les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
9. Lancement du serveur :
```
    php bin/console server:run
```
9. Le projet est maintenant installé, vous pouvez tester l'application.