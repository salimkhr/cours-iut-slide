# Bootstrap
## Build fast, responsive sites
---
## Les Conteneurs

Le conteneur fixe a une largeur maximale et est centré horizontalement sur la page.

```html
<main class="container">
    <!-- Contenu de votre site web ici -->
</main>

ou

<main class="container-fluid">
    <!-- Contenu de votre site web sans marge ici -->
</main>
```
---
## Les Grilles

```html
<div class="container">
    <div class="row">
        <div class="col">Contenu de la colonne 1</div>
        <div class="col">Contenu de la colonne 2</div>
    </div>
</div>
```
---
## Les Grilles

Bootstrap propose une grille de 12 colonnes

```html
<div class="container">
    <div class="row">
        <div class="col-5">Contenu de la colonne 1</div>
        <div class="col-5">Contenu de la colonne 2</div>
        <div class="col-2">Contenu de la colonne 3</div>
    </div>
</div>
```
---
## Les Grilles

```html
<div class="container">
    <div class="row">
        <div class="col">Contenu de la colonne 1</div>
        <div class="col-5">Contenu de la colonne 2</div>
    </div>
</div>
```
---
## Les Grilles

```html
<div class="container">
    <div class="row">
        <div class="col">Contenu de la colonne 1</div>
        <div class="col-5">
            <div class="row">
                <div class="col-5">Contenu de la colonne 2</div>
                <div class="col-5">Contenu de la colonne 3</div>
                <div class="col-2">Contenu de la colonne 4</div>
            </div>
        </div>
    </div>
</div>
```
---
## Les Grilles

- sm : Small (smartphones et tablettes en orientation portrait)
- md : Medium (tablettes en orientation paysage et ordinateurs portables)
- lg : Large (ordinateurs de bureau)
- xl : Extra Large (grand écran et téléviseurs)

---
## Les Grilles
```html
<div class="container">
    <div class="row">
        <div class="col-md-2">Contenu de la colonne 1</div>
        <div class="col">Contenu de la colonne 2</div>
    </div>
</div>
```

---
## Les Grilles
```html
<div class="container">
    <div class="row">
        <div class="col-md-auto">Contenu avec largeur automatique</div>
        <div class="col">Contenu de la colonne 2</div>
    </div>
</div>
```
---
## Typographie
Bootstrap propose un ensemble de classes utilitaires pour ajouter rapidement du style à votre contenu sans écrire de CSS personnalisé.
Alignement du texte

- `.text-left` : Aligné à gauche
- `.text-center` : Centré
- `.text-right` : Aligné à droite
- `.text-justify` : Justifié
- `.text-nowrap` : Non enveloppé

---
## Espacement

Les classes sont nommées selon le format: `{Propriétés}{Cotés}-{breakpoint}-{Taille}`.

---
## Espacement
| Propriétés | Cotés                        | Taille |
|------------|------------------------------|--------|
| m          | t (top)                      | 0      |
| p          | b (bottom)                   | 1      |
|            | y (top and bottom)           | 2      |
|            | s (right in RTL)             | 3      |
|            | e (left in RTL)              | 4      |
|            | x (left and right)           | 5      |


---
## Espacement

```html
<div class="m-2">Marge de 0.5rem</div>
<div class="p-3">Rembourrage de 1rem</div>
<div class="mx-auto">Marge horizontale automatique</div>
<div class="my-4">Marge verticale de 2rem</div>
```
---

## Couleurs et Arrière-Plans

- `.primary`
- `.secondary`
- `.success`
- `.danger`
- `.warning`
- `.info`
- `.dark`

Variantes de couleur claire (ex. primary-light)

---

## Couleurs et Arrière-Plans
```html
    <div class="text-primary">Texte en bleu</div>
    <div class="bg-warning text-white">Fond jaune avec texte blanc</div>
```

---
## Button

```html
    <button type="button" class="btn btn-primary btn-lg">
    Bouton primaire de grande taille
</button>
```

---
## Formulaire

```html
<div class="mb-3">
    <label for="exampleFormControlInput1" 
           class="form-label">
        Email address
    </label>
    <input type="email" 
           class="form-control" 
           id="exampleFormControlInput1" 
           placeholder="name@example.com"
    >
```
