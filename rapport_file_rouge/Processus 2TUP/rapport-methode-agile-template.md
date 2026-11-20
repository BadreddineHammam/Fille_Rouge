## 2TUP — Two Tracks Unified Process

La méthode 2TUP sépare l'analyse fonctionnelle de l'étude technique, puis
converge vers la conception et la réalisation. Elle constitue ici une grille de
lecture du projet, et non une preuve d'un processus de développement suivi
formellement.

### Branche fonctionnelle

Le produit répond au besoin d'un fil professionnel où les utilisateurs peuvent
créer un compte, se connecter, publier et gérer leurs publications. Un compte
standard ne voit et ne gère que ses propres publications ; l'administrateur
peut consulter et gérer l'ensemble du fil.

### Branche technique

Le frontend est une page HTML avec JavaScript et Tailwind CSS chargé depuis un
CDN. Il communique avec deux API PHP. Les services appliquent les règles
métier, les DAO accèdent aux fichiers JSON et les sessions portent
l'identification, le rôle et la protection CSRF. Aucun serveur SQL ni
framework PHP n'est utilisé.

### Convergence et réalisation

Les besoins fonctionnels sont pris en charge par une interface de fil et des
API d'authentification et de publications. La réalisation inclut les
opérations CRUD, les contrôles d'accès par propriétaire ou rôle administrateur
et des tests PHP pour l'authentification et les publications.

![Processus 2TUP](images.jpg)

*Schéma générique du processus 2TUP : les branches fonctionnelle et technique
convergent vers la réalisation.*

Le schéma est un support méthodologique générique. Le dépôt ne fournit pas de
journal de phases ni de planning 2TUP détaillé pour le projet.
