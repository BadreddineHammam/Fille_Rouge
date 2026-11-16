# Réseau social professionnel

Une petite application d’apprentissage pour créer, afficher, modifier et
supprimer des publications dans un fil professionnel. Elle reprend la façon
de structurer et la syntaxe de `project_11` : HTML/Tailwind, JavaScript avec
`fetch`, API PHP, service, DAO et stockage JSON.

> Les profils et publications fournis sont des données de démonstration. Cette
> application n'inclut ni inscription, ni connexion, ni protection des
> publications par utilisateur.

## Structure du projet

```text
ff/
├── assets/
│   └── js/
│       └── app.js
├── backend/
│   ├── api/
│   │   └── posts.php
│   ├── classes/
│   │   └── Post.php
│   ├── dao/
│   │   └── PostDAO.php
│   ├── data/
│   │   └── posts.json
│   └── services/
│       ├── BaseService.php
│       └── PostService.php
├── tests/
│   └── test_post.php
└── index.html
```

- `index.html` affiche le fil et le formulaire.
- `assets/js/app.js` charge les publications et envoie les actions CRUD.
- `backend/api/posts.php` reçoit les requêtes HTTP et retourne du JSON.
- `backend/classes/Post.php` représente une publication.
- `backend/services/PostService.php` vérifie les entrées avant leur sauvegarde.
- `backend/dao/PostDAO.php` lit et écrit les publications en JSON.
- `backend/data/posts.json` contient les publications de démonstration.
- `tests/test_post.php` vérifie les opérations CRUD et quelques validations.

## Prérequis

- PHP CLI 8.1 ou supérieur.
- Un navigateur web.
- Aucun paquet Composer, serveur de base de données ou framework requis.
- Tailwind CSS est chargé depuis son CDN : une connexion internet est requise
  pour le style, mais pas pour le fonctionnement des formulaires.

## Démarrer l'application

Ouvrir PowerShell dans le dossier `ff` et démarrer le serveur PHP :

```powershell
php -S localhost:8000
```

Ouvrir ensuite <http://localhost:8000> dans le navigateur. Utiliser le serveur
PHP plutôt que d'ouvrir `index.html` directement : les appels `fetch` ont besoin
de l'API PHP.

Le serveur doit avoir les droits d'écriture sur `backend/data/posts.json` pour
que les créations, modifications et suppressions soient conservées.

## Utiliser le CRUD

1. **Create — créer :** saisir un nom, un métier et un texte, puis choisir
   « Publier ».
2. **Read — lire :** le fil est chargé à l'ouverture depuis le fichier JSON.
3. **Update — modifier :** choisir « Modifier » sur une publication, corriger
   les champs, puis enregistrer.
4. **Delete — supprimer :** choisir « Supprimer », puis confirmer l'action.

L'API utilise `GET` pour lire, `POST` pour créer, `PUT` pour modifier et
`DELETE` pour supprimer.

## Vérifier

Vérifier la syntaxe PHP depuis ce dossier :

```powershell
Get-ChildItem .\backend, .\tests -Filter *.php -Recurse | ForEach-Object { php -l $_.FullName }
```

Exécuter le test CRUD :

```powershell
php .\tests\test_post.php
```

Le test utilise un fichier temporaire, il ne modifie pas les données de
démonstration dans `backend/data/posts.json`.

## Limites de cette version

- Les auteurs sont des champs de formulaire, pas des comptes authentifiés.
- Toutes les publications sont partagées dans un seul fil et un seul fichier.
- Les données sont stockées dans un fichier JSON, pas dans MySQL.
- Les liens, réactions, commentaires et messages privés ne sont pas inclus.

Ces limites permettent de se concentrer sur le CRUD avant d'ajouter de nouvelles
fonctionnalités.
