## Introduction à Git

### Qu'est-ce que Git ?

- Git est un système de contrôle de version distribué.
- Il permet de suivre les modifications apportées aux fichiers au fil du temps.
- Il est largement utilisé pour la gestion de code source dans les projets de développement logiciel.

---

## Pourquoi utiliser Git ?

- **Collaboration** 
- **Historique**
- **Sauvegardes** 
- **Branches**

---

## Principes de base

### Repositories (Dépôts)

- Un dépôt Git contient tous les fichiers et l'historique des modifications.
- Il peut être local (sur votre machine) ou distant (sur un serveur).
- Cloner un dépôt crée une copie locale de celui-ci sur votre machine.

```bash
git clone <URL_du_dépôt>
```

---

## Principes de base

### Commits

- Un commit représente une modification ou un ensemble de modifications.
- Chaque commit est accompagné d'un message décrivant les changements effectués.
- Les commits sont enregistrés dans l'historique du dépôt.

```bash
git add <path/file>
git status
git commit -m "Lorem ipsum dolor"
```

---

## Principes de base de Git
### Branches

- Les branches permettent de travailler sur des fonctionnalités isolées.
- Elles offrent un moyen de développer en parallèle sans affecter le code principal.
- Les branches peuvent être fusionnées pour intégrer les changements dans la branche principale.

```bash
git branch <nom_de_branche>
git checkout <nom_de_branche>
git merge <main>
```
---

## Principes de base de Git
### Pull / Merge Requests

- Les pull requests sont utilisées pour proposer des modifications à fusionner dans la branche principale.
- Elles permettent la révision du code par les pairs et la discussion des changements.
- Les pull requests facilitent la collaboration et maintiennent la qualité du code.

---
![01](../img/01%20How%20it%20works.svg)

---
![02](../img/02%20Feature%20branches.svg)

---
![03](../img/03%20Release%20branches.svg)
