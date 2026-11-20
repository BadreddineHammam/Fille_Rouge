# Branche technique

La branche technique décrit les choix effectivement présents dans
`file_rouge`. L'application est volontairement légère : une interface statique
communique avec des points d'entrée PHP, et les données sont conservées dans
des fichiers JSON.

## Architecture en couches

- **Présentation** : `frontend/index.html` fournit l'interface et
  `frontend/assets/js/app.js` gère les formulaires, l'affichage du fil et les
  appels `fetch`.
- **API** : `backend/api/auth.php` expose les opérations de compte et
  `backend/api/posts.php` expose les opérations de publication.
- **Services** : `AuthService` applique les règles des comptes ;
  `PostService` valide les publications et vérifie leur propriété.
- **Accès aux données** : `UserDAO` et `PostDAO` lisent et écrivent les
  fichiers JSON. `Post` représente une publication.
- **Persistance** : `backend/data/users.json` et `backend/data/posts.json`.

Le projet n'utilise pas strictement MVC : les pages sont rendues côté navigateur
et le backend est organisé autour des API, services et DAO.

## Contrôles et sessions

Les API renvoient des réponses JSON. Les requêtes d'écriture transmettent un
jeton CSRF ; les sessions PHP portent l'identifiant et le rôle du compte. Un
utilisateur standard ne voit et ne modifie que ses publications, tandis qu'un
administrateur peut gérer toutes les publications. L'inscription publique
attribue uniquement le rôle standard. Le premier administrateur est créé par
`backend/scripts/create_admin.php`, utilisable depuis la ligne de commande.

Le routeur `backend/router.php` refuse l'accès HTTP direct à `backend/data`.
Les mots de passe sont stockés sous forme d'empreintes, et non en clair.

## Limites techniques

Les fichiers JSON conviennent au prototype et à l'apprentissage, mais ne
remplacent pas une base transactionnelle pour une utilisation simultanée
importante. Tailwind CSS est chargé depuis un CDN ; le fonctionnement du style
nécessite donc une connexion internet. Aucun framework PHP, paquet Composer ou
serveur de base de données n'est requis.
