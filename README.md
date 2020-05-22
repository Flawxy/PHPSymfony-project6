# Développer de A à Z le site communautaire SnowTricks
## Un projet OpenClassrooms dans le cadre de ma formation de développeur PHP/Symfony

### Instructions d'installation :
```
- Créer le dossier qui accueillera le projet.

- Cloner le projet dans le dossier créé :
git clone https://github.com/Flawxy/phpsymfony-project6

- On se déplace dans le dossier :
cd phpsymfony-project6

- On installe les dépendances avec Composer :
composer install

- On créé ensuite la base de données :
php bin/console doctrine:database:create

- On applique ensuite les migrations présentes :
php bin/console do:mi:mi

- On lance finalement le serveur :
symfony server:start

Le site est accessible à l'adresse https://127.0.0.1:8000/
```
