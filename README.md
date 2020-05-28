<img src="https://i.ibb.co/N9kdrby/Screenshot-1.png" alt="Screenshot-1" />

# Développer de A à Z le site communautaire SnowTricks
## Un projet OpenClassrooms dans le cadre de ma formation de développeur PHP/Symfony

### Instructions d'installation :

- Créer le dossier qui accueillera le projet.

- Cloner le projet dans le dossier créé :

`git clone https://github.com/Flawxy/phpsymfony-project6`

- On se déplace dans le dossier :

`cd phpsymfony-project6`

- On installe les dépendances avec Composer :

`composer install`

- On créé ensuite la base de données :

`php bin/console doctrine:database:create`

- On applique ensuite les migrations présentes :

`php bin/console do:mi:mi`

- On charge le jeu de données disponible en BDD :

`php bin/console doctrine:fixtures:load -n`

- On lance finalement le serveur :

`symfony server:start`

Le site est accessible à l'adresse https://127.0.0.1:8000/

Vous pouvez vous connecter au compte :
```
Nom d'utilisateur : FirstUser
Mot de passe : motdepasse
```
ou bien créer votre propre compte (nécessite une adresse mail valide).
