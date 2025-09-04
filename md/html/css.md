# CSS
## Cascading Style Sheets
---

## Sélecteurs CSS
```CSS
/*Par balise*/
p { color: blue; }

/*Par par class*/
.important { font-weight: bold; }

/*Par par id*/
#header { background-color: #333; }

/*Par par balise et attribut*/
input[type="text"] { border: 1px solid #ccc; }
```

---
## Sélecteurs CSS
```css
.container p {
    color: blue;
}
```

```html
<div class="container">
        <p>Ceci est un paragraphe.</p> <!-- Sélectionné -->
    <article>
        <p>Ceci est un autre paragraphe.</p> <!-- sélectionné -->
    </article>
</div>
```
---
## Sélecteurs CSS
```css
.container > p {
    color: blue;
}
```

```html
<div class="container">
        <p>Ceci est un paragraphe.</p> <!-- Sélectionné -->
    <article>
        <p>Ceci est un autre paragraphe.</p> <!-- Non sélectionné -->
    </article>
</div>
```

---
## Box Média
<img src="img/box-model.png" style="height: 35vh"/>

<sup>Source : MDN </sup>

---
## Mise en page
### Flexbox
```html
  <div class="container">
      <div class="item">Item 1</div>
      <div class="item">Item 2</div>
      <div class="item">Item 3</div>
  </div>
```
```css
.container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
```
---
## Mise en page
### Grid
```html
  <div class="container">
      <div class="item">Item 1</div>
      <div class="item">Item 2</div>
      <div class="item">Item 3</div> 
  </div>
```
```css
.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
```
---
## Mise en page
### Grid
```html
  <div class="container">
      <div class="item">Item 1</div>
      <div class="item">Item 2</div>
      <div class="item">Item 3</div> 
  </div>
```
```css
.container {
    display: grid;
    grid-template-columns: 200px auto;
    grid-template-rows: auto 1fr 2fr auto;
    gap: 20px;
}
```
---

## Mise en page
### Media Queries
```css
    @media screen and (max-width: 768px) {
        p{ color:blue }
    }
    
    @media screen and (max-width: 768px) 
           and (orientation: landscape) {
        p{ color:red }
    }
```
---
# SASS
## Syntactically Awesome Stylesheets

---
## gulp
### A toolkit to automate & enhance your workflow

---
## gulp
Qu'est-ce que Gulp.js ?

Gulp.js est : 
- un outil de **build** pour le développement web, basé sur Node.js.
- un automate gérant la compilation de fichiers Scss en CSS, l’optimisation des images…

---
## gulp
### Définition des taches
```js[1-4|6-13|15-20]
// Tâche 1 : Supprimer le fichier style.css
function cleanTask(){
  return del("./style.css");
}

// Tâche 2 : Compiler les fichiers SCSS en style.css
function sassTask(){
  const flags = {outputStyle: 'compressed'};
  return src("scss/**/*.scss")
  .pipe(sass(flags).on('error', sass.logError))
  .pipe(rename("./style.css"))
  .pipe(dest("./"));
}

// Tâche 3 : Ajouter les préfixes vendeurs sur les règles CSS
function autoprefixerTask(){
  return src("./style.css")
  .pipe(autoprefixer())
  .pipe(dest("."));
}

```
---
## gulp
### Execution des taches
```js[1-2|4-6]
// Tâche 4 : Mettre en série les tâches 1, 2 et 3
const run = series( cleanTask , sassTask , autoprefixerTask ); 

// Tâche 5 : Surveiller les modifications dans le dossier SCSS
function watchTask(){
watch("scss/**/*.scss" , run);
}
```

---
## SCSS
### Les variables
```scss
$primary-color: #3498db;
$base-font-size: 16px;

body{
    $accent-color: #ff6600 !default;
    font-size: $base-font-size;
    color: $primary-color;
}
```

```css
body {
    font-size: 16px;
    color: #3498db;
}
```
---
## SCSS
### L’imbrication de sélecteur
```scss
.container {
  width: 100%;

  .button {
    background-color: #007bff;
    cursor: pointer;

    &:hover {
      background-color: #0056b3;
    }
  }
}
```
---
## SCSS
### L’imbrication de sélecteur
```css
.container {
    width: 100%;
}
.container .button {
    background-color: #007bff;
    cursor: pointer;
}
.container .button:hover {
    background-color: #0056b3;
}
```
---
## SCSS
### L’héritage
```scss
%button-base {
  display: inline-block;
  padding: 10px 20px;
}

.button-primary {
  @extend %button-base;
  background-color: $primary-color;
}

.button-secondary {
  @extend %button-base;
  background-color: $secondary-color;
}
```
---
## SCSS
### L’héritage
```css
.button-secondary, .button-primary {
    display: inline-block;
    padding: 10px 20px;
}

.button-primary {
    background-color: blue;
}

.button-secondary {
    background-color: red;
}
```
---
## SCSS
### Les mixins
```scss
@mixin button-base {
  display: inline-block;
  padding: 10px 20px;
}

.button-primary {
  @include button-base;
  background-color: #007bff;
}

.button-secondary {
  @include button-base;
  background-color: #6c757d;
}
```
---
## SCSS
### Les mixins
```css
.button-primary {
    display: inline-block;
    padding: 10px 20px;
    background-color: blue;
}

.button-secondary {
    display: inline-block;
    padding: 10px 20px;
    background-color: red;
}
```
---
## SCSS
### Les imports
```scss
/* _variables.scss */
$primary-color: #3498db;
$secondary-color: #2ecc71;
$border-radius: 5px;
```

```scss
/* main.scss */
@import 'variables';

.button {
    background-color: $primary-color;
    border-radius: $border-radius;
}

.alert {
    background-color: $secondary-color;
    border: 1px solid $primary-color;
}
```