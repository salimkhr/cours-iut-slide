### introduction au DOM
```html
<body>
  <div id="myId">
    Contenu de mon élément
  </div>
</body>
```

```js [1-4|6-12|14-18]
// Accéder à l'élément HTML avec l'id "myId"
const myElement = document.getElementById("myId");
// Affiche l'objet représentant l'élément <div> avec l'id "myId"
console.log(myElement);

// Modifier le contenu de l'élément
myElement.innerHTML = "Nouveau contenu";
// Modifier les styles de l'élément
myElement.style.color = "red";
myElement.style.backgroundColor = "blue";
// Ajouter une classe CSS à l'élément
myElement.classList.add("maClasse");

// Récupérer la valeur d'un attribut HTML
const myAttributeValue = myElement.getAttribute("id");
console.log(myattributeValue); // Affiche "myId"
// Modifier la valeur d'un attribut HTML
myElement.setAttribute("title", "Mon élément");
```
Note:
Cet exemple montre comment utiliser la méthode document.getElementById() pour accéder à un élément HTML en spécifiant son identifiant unique. Une fois l'élément sélectionné, il est possible de modifier son contenu en utilisant la propriété innerHTML, de modifier ses styles en utilisant la propriété style, d'ajouter une classe CSS à l'aide de la propriété classList, de récupérer la valeur d'un attribut HTML à l'aide de la méthode getAttribute(), et de modifier la valeur d'un attribut HTML à l'aide de la méthode setAttribute().
---
### Séléction du DOM
```html
<div>
    <p>Paragraphe 1</p>
    <p>Paragraphe 2</p>
    <p>Paragraphe 3</p>
  </div>
```

```javascript [1-3|5-8|10-12|14-18]
// Sélectionner tous les éléments <p> à l'intérieur de la balise <div>
const paragraphs = document.querySelectorAll("div p");
console.log(paragraphs); // Affiche des éléments <p>

// Modifier le contenu de tous les paragraphes
paragraphs.forEach(function(p) {
  p.innerHTML = "Nouveau contenu";
});

// Sélectionner le premier élément <p>
const firstParagraph = document.querySelector("p");
console.log(firstParagraph); // Affiche du premier élément <p>

// Modifier le style de tous les paragraphes
const paragraphs = document.querySelectorAll("p");
paragraphs.forEach(function(p) {
  p.style.color = "red";
});
```
Note:
Cet exemple montre comment utiliser la méthode document.querySelectorAll() pour sélectionner tous les éléments correspondant à un sélecteur CSS donné, ici tous les éléments <p> à l'intérieur d'une balise <div>. Il est également possible de sélectionner un seul élément en utilisant la méthode document.querySelector() qui va sélectionner le premier élément correspondant au sélecteur. Il est possible de parcourir les éléments sélectionnés avec une boucle forEach pour effectuer des actions sur chacun d'entre eux, comme ici, changer le contenu ou le style.

Ces méthodes sont très utiles pour sélectionner des éléments de manière efficace et précise, sans avoir à parcourir tous les éléments de la page. Il est important de noter que ces méthodes ne sélectionnent que les éléments qui existent dans le DOM au moment où elles sont appelées, il faut donc s'assurer que les éléments que l'on souhaite sélectionner sont bien présents dans le DOM avant de les manipuler.
---
### Parcours du DOM
```html [12-18|23-32|34-38]
<!DOCTYPE html>
<html>
<head>
	<title>Exemple de parcours du DOM avec des enfants</title>
	<style>
		.highlight {
			background-color: yellow;
		}
	</style>
</head>
<body>
	<div id="parent">
		<p>Ceci est un paragraphe.</p>
		<ul>
			<li>Élément 1</li>
			<li>Élément 2</li>
			<li>Élément 3</li>
		</ul>
		<span>Ceci est un span.</span>
	</div>

	<script>
		// Récupère l'élément parent
		var parent = document.getElementById("parent")

		// Parcours tous les enfants de l'élément parent et ajoute une classe
		for (var i = 0; i < parent.childNodes.length; i++) {
			var child = parent.childNodes[i]
			if (child.nodeType === 1) { // Vérifie que l'enfant est un élément HTML
				child.classList.add("highlight")
			}
		}

        for (var i = 0; i < parent.children.length; i++) {
            var child = parent.children[i]
                child.classList.add("highlight")
            }
        }
	</script>
</body>
</html>
```
---
## Création d'un élément
```javascript
// Création d'un élément
const newElement = document.createElement('div')

// Modification de ses attributs et contenu
newElement.innerText = 'Nouvel élément ajouté'
newElement.classList.add('nouvelle-classe')

// Ajout de l'élément au DOM
document.body.appendChild(newElement)

```
---
## Création d'un élément

```html
<div>
    <p>Paragraphe 1</p>
    <p>Paragraphe 2</p>
    <p>Paragraphe 3</p>
  </div>
```

```javascript [2|4-6|8-10]
// Création d'un élément
const div = document.querySelector("p")

const p4 = document.createElement('p')
p4.innerText = 'Paragraphe 4'
div.insertAdjacentElement('beforeend',p4)

const p4 = document.createElement('p')
p4.innerText = 'Paragraphe 0'
div.insertAdjacentElement('afterbegin',p0)

```
---
## Création d'un élément

```html
<div>
    <p>Paragraphe 1</p>
    <p>Paragraphe 2</p>
    <p>Paragraphe 3</p>
  </div>
```

```javascript [2|4-6|8-10]
// Création d'un élément
const div1 = document.querySelector("div")

const div0 = document.createElement('div')
div1.insertAdjacentElement('beforebegin',div0)

const div2 = document.createElement('div')
div1.insertAdjacentElement('afterend',div2)

```
---
## Gestion des tableaux
```html
<table id="myTable">
  <tr> <th>Header 1</th> <th>Header 2</th> </tr>
  <tr> <td>Value 1</td> <td>Value 2</td> </tr>
  <tr> <td>Value 3</td> <td>Value 4</td> </tr>
</table>
```

```javascript [1-2|4-6|8-13|15-22]
const table = document.getElementById("myTable");
console.log(table); // Affiche l'objet <table>

// Accéder aux lignes du tableau
const rows = table.rows;
console.log(rows); // Affiche un objet HTMLCollection contenant les lignes <tr>

// Accéder à une cellule spécifique en utilisant les propriétés row et cell
const cell = table.rows[1].cells[1];
console.log(cell); // Affiche l'objet représentant la cellule <td> "Value 2"

// Modifier le contenu d'une cellule
cell.innerHTML = "Nouvelle valeur";

//Ajouter une ligne au tableau
const newRow = table.insertRow(-1);

const newCell1 = newRow.insertCell(0);
newCell1.innerHTML = "Value 5";

const newCell2 = newRow.insertCell(1);
newCell2.innerHTML = "Value 6";
```
Note:
Cet exemple montre comment utiliser la méthode document.querySelectorAll() pour sélectionner tous les éléments correspondant à un sélecteur CSS donné, ici tous les éléments <p> à l'intérieur d'une balise <div>. Il est également possible de sélectionner un seul élément en utilisant la méthode document.querySelector() qui va sélectionner le premier élément correspondant au sélecteur. Il est possible de parcourir les éléments sélectionnés avec une boucle forEach pour effectuer des actions sur chacun d'entre eux, comme ici, changer le contenu ou le style.

Ces méthodes sont très utiles pour sélectionner des éléments de manière efficace et précise, sans avoir à parcourir tous les éléments de la page. Il est important de noter que ces méthodes ne sélectionnent que les éléments qui existent dans le DOM au moment où elles sont appelées, il faut donc s'assurer que les éléments que l'on souhaite sélectionner sont bien présents dans le DOM avant de les manipuler.
