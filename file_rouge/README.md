# Réseau social professionnel

Une petite application d’apprentissage pour créer, afficher, modifier et
supprimer des publications dans un fil professionnel. Elle reprend la façon
de structurer et la syntaxe de `project_11` : HTML/Tailwind, JavaScript avec
`fetch`, API PHP, service, DAO et stockage JSON.

> Les anciennes publications fournies sont des données de démonstration. Les
> nouveaux comptes et publications sont stockés dans des fichiers JSON.

## Structure du projet

```text
file_rouge/
├── backend/
│   ├── api/
│   │   ├── auth.php
│   │   └── posts.php
│   ├── classes/
│   │   └── Post.php
│   ├── dao/
│   │   ├── PostDAO.php
│   │   └── UserDAO.php
│   ├── data/
│   │   ├── posts.json
│   │   └── users.json
│   ├── scripts/
│   │   └── create_admin.php
│   ├── services/
│   │   ├── AuthService.php
│   │   ├── BaseService.php
│   │   ├── PostService.php
│   │   └── Session.php
│   └── tests/
│       ├── test_auth.php
│       └── test_post.php
└── frontend/
    ├── assets/
    │   └── js/
    │       └── app.js
    └── index.html
```

- `frontend/index.html` affiche le fil et le formulaire.
- `frontend/assets/js/app.js` charge les publications et envoie les actions CRUD.
- `backend/api/auth.php` gère l'inscription, la connexion et la déconnexion.
- `backend/api/posts.php` reçoit les requêtes HTTP et retourne du JSON.
- `backend/router.php` empêche le serveur PHP intégré de livrer directement les fichiers de données.
- `backend/classes/Post.php` représente une publication.
- `backend/services/PostService.php` vérifie les entrées avant leur sauvegarde.
- `backend/dao/PostDAO.php` lit et écrit les publications en JSON.
- `backend/services/AuthService.php` valide les comptes et vérifie les mots de passe.
- `backend/dao/UserDAO.php` lit et écrit les comptes dans `backend/data/users.json`.
- `backend/services/Session.php` configure les sessions et vérifie les requêtes qui modifient les données.
- `backend/data/posts.json` contient les publications, y compris les exemples existants.
- `backend/scripts/create_admin.php` crée un administrateur depuis la ligne de commande.
- `backend/tests/` contient les tests des comptes et des publications.

## Prérequis

- PHP CLI 8.1 ou supérieur.
- Un navigateur web.
- Aucun paquet Composer, serveur de base de données ou framework requis.
- Tailwind CSS est chargé depuis son CDN : une connexion internet est requise
  pour le style, mais pas pour le fonctionnement des formulaires.

## Démarrer l'application

Ouvrir PowerShell dans le dossier `file_rouge` et démarrer le serveur PHP :

```powershell
php -S localhost:8000 .\backend\router.php
```

Ouvrir ensuite <http://localhost:8000/frontend/> dans le navigateur. Utiliser
le serveur PHP plutôt que d'ouvrir `frontend/index.html` directement : les
appels `fetch` ont besoin de l'API PHP.

Avant de démarrer le site, créer le premier administrateur depuis ce dossier :

```powershell
php .\backend\scripts\create_admin.php
```

Le script demande le nom, l'adresse e-mail et le mot de passe. Il est réservé à
la ligne de commande et n'est pas une page web. Le serveur doit avoir les droits
d'écriture sur `backend/data/posts.json` et `backend/data/users.json`.

Les autres comptes peuvent s'inscrire depuis la page. L'inscription donne
toujours le rôle normal : le navigateur ne peut pas se déclarer administrateur.

Chaque nouvelle publication enregistre le `userId` de la session sur le
serveur. Le service compare cet identifiant au propriétaire avant de modifier
ou supprimer une publication. Le rôle d'administrateur permet de voir et gérer
toutes les publications; un compte normal ne peut gérer que celles associées à
son propre identifiant.

## Utiliser le CRUD

1. Connectez-vous ou créez un compte.
2. **Create — créer :** saisir un nom, un métier et un texte, puis choisir
   « Publier ». Le serveur ajoute l'identifiant du compte connecté.
3. **Read — lire :** un compte normal ne reçoit que ses publications; un
   administrateur reçoit toutes les publications.
4. **Update/Delete — modifier/supprimer :** un compte normal ne peut agir que
   sur ses propres publications. L'administrateur peut agir sur toutes.

L'API utilise `GET` pour lire, `POST` pour créer, `PUT` pour modifier et
`DELETE` pour supprimer.

## Vérifier

Vérifier la syntaxe PHP depuis ce dossier :

```powershell
Get-ChildItem .\backend -Filter *.php -Recurse | ForEach-Object { php -l $_.FullName }
```

Exécuter les tests :

```powershell
php .\backend\tests\test_post.php
php .\backend\tests\test_auth.php
```

Les tests utilisent des fichiers temporaires et ne modifient pas les fichiers
de données du projet.

## Limites de cette version

- Les données restent dans des fichiers JSON; ce format est conçu pour cet
  exercice et n'est pas adapté à une forte utilisation simultanée.
- Les anciennes publications sans `userId` sont visibles par l'administrateur,
  mais pas par les comptes normaux.
- Les données sont stockées dans un fichier JSON, pas dans MySQL.
- Les liens, réactions, commentaires et messages privés ne sont pas inclus.

Ces limites permettent de se concentrer sur le CRUD avant d'ajouter de nouvelles
fonctionnalités.
