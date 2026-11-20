# Diagramme de cas d'utilisation

Les acteurs principaux sont l'utilisateur connecté et l'administrateur.

- **Utilisateur** : s'inscrire, se connecter, se déconnecter, créer une
  publication, consulter ses publications, modifier ses publications et
  supprimer ses publications ;
- **Administrateur** : effectuer les mêmes opérations sur toutes les
  publications du système ;
- **Système PHP** : maintenir la session, vérifier le jeton CSRF, appliquer les
  règles d'autorisation et enregistrer les données JSON.

```mermaid
flowchart LR
    U[Utilisateur] --> I[Inscription]
    U --> L[Connexion]
    U --> C[Créer une publication]
    U --> R[Voir ses publications]
    U --> E[Modifier ses publications]
    U --> D[Supprimer ses publications]
    A[Administrateur] --> AP[Voir toutes les publications]
    A --> AE[Modifier toutes les publications]
    A --> AD[Supprimer toutes les publications]
```