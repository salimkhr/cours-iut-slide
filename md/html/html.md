# HTML
## HyperText Markup Language
---

## Qu'est-ce que le HTML?

- **HTML** : HyperText Markup Language
- Langage de balisage pour le Web
- Structure et présente le contenu d’une page web

---
## Éléments HTML et balises

- Chaque élément est défini par une balise, qui peut être ouverte et fermée.
- Les éléments peuvent être imbriqués pour créer une structure hiérarchique dans la page.

Exemple :
```html[]
<p>Ceci est un paragraphe. 
    <strong>Avec quelques chose d’important</strong>
</p>
```

---
## Attributs HTML

- Les attributs HTML fournissent des informations supplémentaires sur les éléments.
- Ils sont spécifiés dans la balise d’un élément et contiennent des valeurs.

Exemple :
```html[]
<img src="image.jpg" alt="Description de l'image">
<a href="https://www.example.com">Lien vers un site</a>
```
---

## Structure de base d’un document HTML

```html[]
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hello world</title>
</head>
<body>
    <p>Hello world</p>
    <!-- Contenu de la page -->

</body>
</html>
```

---
## La Typographie
### Les paragraphes
```html
<p>
  Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
  Sed tempor ullamcorper leo, id tristique ipsum rhoncus vel.
  Vestibulum vitae ultrices lacus. Sed non justo mi.
</p>
```
-----
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Sed tempor ullamcorper leo, id tristique ipsum rhoncus vel.
Vestibulum vitae ultrices lacus. Sed non justo mi.

---
## La Typographie
### Les titres

```html
<h1>Titre 1</h1> <h2>Titre 2</h2> <h3>Titre 3</h3>
```
-----
# Titre 1
## Titre 2
### Titre 3

---
## La Typographie
### Les balises Strong et Emphasize (Em)
```html
<p>
  Lorem ipsum <strong>dolor sit amet</strong>, 
  consectetur adipiscing elit.
  <em>Sed tempor ullamcorper leo</em>.
</p>
```
-----

Lorem ipsum **dolor sit amet**, consectetur adipiscing elit. _Sed tempor ullamcorper leo_.

---
## La Typographie
```html
<blockquote>
  <p>
    Ceci est une longue citation qui nécessite un retrait
    supplémentaire.
  </p>
</blockquote>

<p>Voici une <q>citation en ligne</q> dans un paragraphe.</p>
```
-----
<blockquote>
  <p>Ceci est une longue citation qui nécessite un retrait supplémentaire.</p>
</blockquote>
<p>Voici une <q>citation en ligne</q> dans un paragraphe.</p>

---

## Création de liens
- Utilisation de la balise _`<a>`_ avec les attributs
  - _href_ : pour spécifier la destination et 
  - _target_ : pour ouvrir dans une nouvelle fenêtre.
  - _download_ : pour forcer le téléchargement d’un fichier.

Exemple :
```html[1-6|1|2|3|5-6]
<a href="https://www.example.com">Lien vers un site</a>
<a href="https://www.example.com" target="_blank">nouvel onglet</a>
<a href="document.pdf" download>Télécharger le document</a>

<h1 id="titre">Titre</titre>
<a href="#titre">Lien vers le titre</a>
```

---

## Création de liste

- HTML propose trois types de listes :
  - les listes ordonnées `<ol>`
  - les listes non ordonnées `<ul>`.
  - les liste de définitions  `<dl>`.

---
## Création de liste
### Exemple de liste non ordonnée

  ```html[]
    <ul>
        <li>Élément 1</li>
        <li>Élément 2</li>
        <li>Élément 3</li>
    </ul>
  ```
-----
- Élément 1
- Élément 2
- Élément 3


---
## Création de liste
### Exemple de liste ordonnée
```html[]
<ol>
    <li>Élément 1</li>
    <li>Élément 2</li>
    <li>Élément 3</li>
</ol>
```
-----
1. Élément 1
1. Élément 2
1. Élément 3

---
## Création de liste
### Exemple de liste de définitions
```html[]
<dl>
    <dt>HTML</dt>
    <dd>HyperText Markup Language</dd>
    <dt>CSS</dt>
    <dd>Cascading Style Sheets</dd>
</dl>
```
-----
<dl>
    <dt>HTML</dt>
    <dd>HyperText Markup Language</dd>
    <dt>CSS</dt>
    <dd>Cascading Style Sheets</dd>
</dl>

---

## Création de tableaux
### HTML utilise les balises
- `<table>`
  - `<tr>` pour les lignes, 
    - `<th>` pour les en-têtes de colonnes 
    - `<td>` pour les cellules de données.

---
## Création de tableaux
### Tableau basique

```html[1-10|2-5|3|1-10]
<table>
    <tr>
        <td>L1 C1</td>
        <td>L1 C2</td>
    </tr>
    <tr>
        <td>L2 C1</td>
        <td>L2 C2</td>
    </tr>
</table>
```
-----

| L1 C1 | L1 C2 |
|-------|-------|
| L2 C1 | L2 C2 |

---
## Création de tableaux
### Tableau avec en-tête

```html[1-18|2-7|8-17|4-5|1-18]
<table>
    <thead>
        <tr>
            <th>En-tête C1</th>
            <th>En-tête C2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>L1 C1</td>
            <td>L1 C2</td>
        </tr>
        <tr>
            <td>L2 C1</td>
            <td>L2 C2</td>
        </tr>
    </tbody>
</table>
```

---
## Création de tableaux
### Gestion des colonnes

```html[1-22|2-5|1-22]
<table>
    <colgroup>
        <col class="first-col">
        <col style="background-color: lightblue;">
    </colgroup>
    <thead>
        <tr>
            <th>En-tête C1</th>
            <th>En-tête C2</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>L1 C1</td>
        <td>L1 C2</td>
    </tr>
    <tr>
        <td>L2 C1</td>
        <td>L2 C2</td>
    </tr>
    </tbody>
</table>
```

---
## Utilisation des médias
### Les images
```html[]
<img 
  src="https://picsum.photos/200/300" 
  alt="Une photo aléatoire" 
  width="200" 
  height="300"
>

<picture>
    <source media="(min-width: 768px)" srcset="image-large.jpg">
    <source media="(min-width: 320px)" srcset="image-medium.jpg">
    <img src="image-small.jpg" alt="Description de l'image">
</picture>
```
---
## Utilisation des médias
### L'audio
```html[]
<audio controls>
    <source src="audio.mp3" type="audio/mpeg">
    <source src="audio.ogg" type="audio/ogg">
    <p>Votre navigateur ne supporte pas la lecture audio.</p>
</audio>
```
-----
<audio controls style="width: 100%">
 <source src="../../media/exemple.mp3" type="audio/mpeg">
</audio>

---
## Utilisation des médias
### La vidéo
```html[]
<video controls>
    <source src="video.mp4" type="video/mp4">
    <source src="video.webm" type="video/webm">
    <p>Votre navigateur ne supporte pas la lecture de vidéos.</p>
</video>
```
-----
<video controls style="height:30vh">
 <source src="../../media/exemple.mp4" type="video/mp4"> 
</video>
---

## Structure sémantique

- HTML offre des balises sémantiques pour décrire.
- Cela améliore :
  - l’accessibilité
  - le référencement
  - la compréhension du contenu par les navigateurs et les lecteurs d’écran.

---
## Structure sémantique
```html[1-16|2-11|4-10|12-24|15-18|19-22|25-27]
<body>
    <header>
        <h1>Titre de l’en-tête</h1>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
      <section>
          <h2>Titre de la section principale</h2>
          <article>
              <h3>Titre de l'article</h3>
              <p>Contenu de l'article…</p>
          </article>
          <aside>
              <h3>À propos</h3>
              <p>Informations supplémentaires…</p>
          </aside>
      </section>
    </main>
    <footer>
        <p>Droit d’auteur © 2024</p>
    </footer>
</body>
```
---

## Les metas
```html[1-32|4-5|6-7|8-11|12-13|14-15|16-17|18-19|20-21|22-23|24-25]
<!DOCTYPE html> 
<html lang="fr">
<head>
    <!-- Définit l'encodage des caractères de la page -->
    <meta charset="UTF-8">
    <!-- Redimensionne la page pour les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Description de la page pour les moteurs de recherche -->
    <meta name="description" content="Description">
    <!-- Mots-clés pour les moteurs de recherche -->
    <meta name="keywords" content="Mots-clés, séparés, par, des, virgules">
    <!-- Nom de l'auteur de la page -->
    <meta name="author" content="Nom de l'auteur">
    <!-- Instructions pour les robots d'indexation -->
    <meta name="robots" content="index, follow">
    <!-- Fréquence de réindexation par les moteurs de recherche -->
    <meta name="revisit-after" content="7 days">
    <!-- Langue de la page -->
    <meta name="language" content="French">
    <!-- Logiciel utilisé pour créer la page -->
    <meta name="generator" content="Nom du logiciel / CMS">
    <!-- Couleur du thème de la page -->
    <meta name="theme-color" content="#ffffff">
    <!-- URL canonique de la page (variante d'une même page)-->
    <link rel="canonical" href="https://www.example.com/page-canonical.html">
</head>
<body>
    <!-- Contenu de la page -->
</body>
</html>
```
---

## L’accessibilité
### ARIA Accessible Rich Internet Applications

```html[]
  <div role="progressbar"> Work in progress... </div>
  <button aria-label="Fermer la fenêtre">X</button>
```