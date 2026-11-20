# Rapport du projet Réseau Pro

Ce dossier reprend la structure du rapport et rassemble la documentation
adaptée au projet `file_rouge`, une application web de fil professionnel.

## Contenu

- `rapport-final.md` : rapport assemblé.
- `skeleton.md` : plan des sections.
- `build_rapport.py` : script d'assemblage du rapport.
- Les sous-dossiers contiennent les sections, les visuels de méthodologie et
  les diagrammes Mermaid existants du projet.

## Diagrammes du projet

- Architecture logicielle : `Architecture logicielle/architecture.mmd`
- Flux de données : `Architecture logicielle/lux de données .mmd`
- Cas d'utilisation : `Diagramme de cas d'utilisation/diagram_de_cas_d_utilisation.mmd`

Les autres fichiers `.mmd` du projet source ne sont pas recréés : ils sont
repris tels quels dans ce rapport.

## Générer le rapport assemblé

Depuis ce dossier, exécuter :

```powershell
python .\build_rapport.py
```

Le script lit les fichiers Markdown des sections et met à jour
`rapport-final.md`. Les sections associées à des fichiers Markdown vides restent
vides.

## Projet documenté

`file_rouge` est une application pédagogique de gestion CRUD des publications
d'un fil professionnel. Le frontend utilise HTML, JavaScript et Tailwind CSS
via CDN. Le backend est écrit en PHP et stocke les comptes et publications dans
des fichiers JSON, sans base de données relationnelle ni dépendance Composer.
