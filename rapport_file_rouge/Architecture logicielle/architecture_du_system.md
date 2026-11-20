# Architecture logicielle

## Architecture de l'application

L'application est organisée en couches de présentation, d'API, de logique
métier et d'accès aux données. Le navigateur charge l'interface et utilise
`fetch` pour communiquer avec les deux API PHP. Les DAO lisent et mettent à
jour les fichiers JSON locaux.

Le dépôt source fournit les diagrammes Mermaid suivants :
`file.mmd`, `lux de données .mmd` et `diagram_de_cas_d_utilisation.mmd`.
Ils peuvent être placés dans les sous-dossiers du rapport pour une diffusion
dans un générateur HTML.

## Flux de données

Lors de l'authentification, `auth.php` s'appuie sur `AuthService`,
`UserDAO`, `users.json` et la session PHP. Une fois connecté, le navigateur
appelle `posts.php` pour lire ou modifier les publications. `PostService`
valide les données et vérifie l'autorisation, puis `PostDAO` persiste les
changements dans `posts.json`. Les API renvoient des réponses JSON au frontend.

Le diagramme de flux de données du projet décrit les échanges entre
`fetch`, les API PHP, les services, les DAO et les fichiers JSON.

## Modèle architectural

Le projet n'est pas une application MVC stricte. La présentation est une page
HTML/JavaScript côté client ; les fichiers API coordonnent les sessions et les
services ; les services portent les validations et règles métier ; les DAO
encapsulent l'accès aux données JSON. Cette séparation rend le prototype
facile à suivre et permet de remplacer ultérieurement le stockage.
