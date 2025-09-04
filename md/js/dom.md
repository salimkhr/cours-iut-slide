# Le DOM
## Document Object Model

---
## Recheche par id
```html []
<body>
  <div id="myId">
    Contenu de mon élément
  </div>
    <script>
        // Sélectionner un élément par son ID (unique)
        const element = 
                document.getElementById("myId");
        element.innerHTML = 'Nouveau Contenu de mon élément'
    </script>
</body>
```
---
## Recheche par class
```html []
<body>
  <ul>
    <li class="titre">a</li>
    <li class="titre">b</li>
    <li class="titre">c</li>
    <li class="titre">d</li>
  </ul>
    <script>
        // Sélectionner un élément par son ID (unique)
        const elements = 
                document.getElementsByClassName("titre");
        elements[0].innerHTML = 'Nouveau Contenu de mon élément'
    </script>
</body>
```
---
## Recheche par class
```html []
<body>
  <div class="titre">
    Contenu de mon élément
  </div>
    <script>
        // Sélectionner un élément par sa class
        const elements = 
                document.getElementsByTagName("div");
        elements[0].innerHTML = 'Nouveau Contenu de mon élément'
    </script>
</body>
```
---
## Recheche comme en css
```html []
<body>
  <div class="titre">
    Contenu de mon élément
  </div>
    <script>
        // Sélectionner le premier élément correspondant à un sélecteur CSS
        const firstElement = 
                document.querySelector(".titre");

        // Sélectionner tous les éléments correspondant à un sélecteur CSS
        const allElements = 
                document.querySelectorAll(".titre");
    </script>
</body>
```
---

## Manipulation des éléments
```javascript [1-15|1-2|4-5|7-8|10-11|13-16]
// Modifier le contenu textuel
element.textContent = "Nouveau contenu"; // Remplace le texte de l&apos;élément

// Modifier un attribut (par exemple, une classe CSS)
element.setAttribute("required", true); // Ajoute l&apos;attribut &apos;required&apos; et le définit à true

// Ajouter du style en ligne
element.style.color = "red"; // Applique une couleur rouge au texte de l&apos;élément

// Remplace tout le contenu de l&apos;élément par HTML
element.innerHTML = "<strong>Ceci est du texte avec des balises HTML.</strong>"

// Modifier la classe de l&apos;élément
element.classList.add("nouvelleClasse"); // Ajoute une nouvelle classe à l&apos;élément
element.classList.remove("ancienneClasse"); // Supprime une classe de l&apos;élément
element.classList.toggle("toggleClasse"); // Bascule entre l&apos;ajout et la suppression de la classe
```
---
## Création et ajout des éléments a la fin
```javascript
// Crée un nouvel élément <p>
const newElement = document.createElement("p");

// Ajoute du texte à cet élément
newElement.textContent = "Ceci est un paragraphe.";

// Ajoute cet élément à la fin du body de la page
document.body.appendChild(newElement);
```
---
## Création et ajout des éléments au début
```javascript
// Crée un nouvel élément <p>
const anotherElement = document.createElement("p");

// Ajoute du texte à cet élément
anotherElement.textContent = "Ceci est un paragraphe au début.";

// Ajoute cet élément au début du body
document.body.prepend(anotherElement);
```
---
## Création et ajout des éléments avant un autre
```javascript
// Sélectionner un élément existant
const referenceElement = document.getElementById("someId");

// Crée un nouvel élément <p>
const newElementBefore = document.createElement("p");

// Ajoute du texte à cet élément
newElementBefore.textContent = "Ceci est un paragraphe avant un autre élément.";

// Ajoute cet élément avant le référencé
document.body.insertBefore(newElementBefore, referenceElement);
```
---
##
