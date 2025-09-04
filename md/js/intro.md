# Introduction au JavaScript

---

## Structure d'une page HTML avec JavaScript

```html[1-15|9-11|13]
<!DOCTYPE html>
<html lang="en">
    <head>
          <!-- META -->
    </head>
    <body>
          <h1>Ma première page JavaScript</h1>
           <!-- Ajouter JavaScript directement -->
          <script>
            console.log("Bonjour depuis le script intégré !");
          </script>
          <!-- Lien vers un fichier JS -->
          <script src="script.js"></script>
    </body>
</html>
```
---
## Déclaration des variables
#### Déclaration avec const
```javascript []
const pi = 3.14;
console.log(pi); // 3.14

// Exemple de modification d'un tableau avec const
const arr = [1, 2, 3];
arr.push(4); // Ok, modification du contenu
console.log(arr); // [1, 2, 3, 4]
```
---
## Déclaration des variables
#### Déclaration avec let
```javascript []
let age = 25;
age = 26; // Ok
console.log(age); // 26
```
---
## Déclaration des variables
#### Déclaration avec var
```javascript []
// var : ancien mot-clé, à ne plus utiliser, peut avoir des fonctionnements étranges
var name = "Alice";
name = "Bob"; // Ok
console.log(name); // Bob
```
---
## Les types de données
```javascript []
// Chaîne de caractères
const message = "Bonjour !";

// Nombre
const age = 30;

// Booléen
const isStudent = true;

// Tableau
const fruits = ["pomme", "banane", "cerise"];
```
---
## Les types de données
```javascript []
// Objet
const utilisateur = {
    nom: "Alice",
    age: 30,
    hobbies: ["lecture", "voyage", "cuisine"],
    adresse: {
        rue: "123 Rue Exemple",
        ville: "Paris",
        codePostal: "75001"
    }
}

console.log(utilisateur.hobbies[0]);  // Affiche "lecture"
console.log(utilisateur.adresse.ville);  // Affiche "Paris"

```
---
## Afficher des informations dans la console
```javascript []
console.log("Bonjour, monde !");
console.log("Age :", age);
console.error("/!\\ Une erreur est survenue /!\\");
console.table(fruits);
```
---
## Boucles et itérations
#### Parcourir un tableau avec for
```javascript []
const fruits = ["pomme", "banane", "cerise"];
for (let i = 0; i < fruits.length; i++) {
  console.log(fruits[i]); // Affiche chaque fruit du tableau
}

for (let fruit of fruits) {
    console.log(fruit); // Affiche chaque fruit du tableau
}
```
#### Parcourir un tableau avec forEach
```javascript []
fruits.forEach((fruit) => {
console.log(fruit); // Affiche chaque fruit du tableau
});
```
---
## Boucles et itérations
#### Parcourir un objet

```javascript []
const personne = { nom: "Alice", age: 25 };
for (let key in personne) {
  console.log(key, ":", personne[key]);
}

Object.keys(personne).forEach(key => {
    console.log(key, ":", personne[key]);
});
```
