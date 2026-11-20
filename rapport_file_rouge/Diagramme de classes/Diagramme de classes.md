# Modèle de classes

Le backend est principalement organisé autour de services et de DAO. La classe
métier `Post` représente une publication. Les enregistrements utilisateur
restent des tableaux associatifs ; il n'existe pas de classe `User` dans le
projet.

| Élément | Rôle |
|---|---|
| `Post` | Porte l'identifiant, l'auteur, le métier, le contenu, la date de création et l'identifiant utilisateur optionnel. |
| `PostService` | Valide les champs, liste les publications selon le rôle et vérifie la propriété avant modification ou suppression. |
| `PostDAO` | Lit et écrit `posts.json`, et convertit les enregistrements en objets `Post`. |
| `AuthService` | Inscrit les comptes standards, authentifie les utilisateurs et peut créer l'administrateur initial. |
| `UserDAO` | Lit et écrit les comptes dans `users.json`, y compris les empreintes des mots de passe. |
| `BaseService` | Fournit la base commune étendue par `PostService`. |

Les relations d'utilisation sont les suivantes : `PostService` utilise
`PostDAO`, qui hydrate et persiste plusieurs objets `Post` ; `AuthService`
utilise `UserDAO`. L'API et la gestion de session sont procédurales.

Le dépôt contient des diagrammes Mermaid d'architecture, de flux et de cas
d'utilisation, mais pas de diagramme de classes Mermaid. Aucun nouveau
diagramme de classes n'est ajouté dans ce rapport.
