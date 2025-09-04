# JSON
## JavaScript Object Notation

---
### Fonctionnement de JSON
```JSON
 {
  "nom": "John Doe",
  "age": 30,
  "ville": "Paris",
  "estEtudiant": false,
  "amis": ["Alice", "Bob", "Charlie"]
}
```

---
### Fonctionnement de JSON
```JSON
 {
  "nom": "John Doe",
  "age": 30,
  "ville": "Paris",
  "estEtudiant": false,
  "amis": [
    {
      "nom": "Jane Smith",
      "age": 34,
      "ville": "Rouen",
      "estEtudiant": false
    }
  ]
}
```

---

### Destructuration en JavaScript
#### Sur les objets
```JS
 const personne = {
    nom: 'John Doe',
    age: 30,
    ville: 'Paris'
};

const { nom, age, ville } = personne;
console.log(nom); // John Doe
console.log(age); // 30
console.log(ville); // Paris

console.log(`Nom: ${nom}, Age: ${age}, Ville: ${ville}`);
```

---
### Destructuration en JavaScript
#### Sur les tableaux
```JS
const fruits = ['pomme', 'banane', 'orange'];

const [premier, deuxieme, troisieme] = fruits;
console.log(premier); // pomme
console.log(deuxieme); // banane
console.log(troisieme); // orange
```
