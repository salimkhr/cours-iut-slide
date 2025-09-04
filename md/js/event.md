# Fonction et événements
---
### Les fonctions
```javascript []
// Définir une fonction classique
const noms = ["Alice", "Bob", "Charlie"];
function saluer(nom) {
    return `Bonjour, ${nom} !`;
}

const messages = noms.map(saluer);
console.log(messages);
// ["Bonjour, Alice!", "Bonjour, Bob!", "Bonjour, Charlie!"]
```
---
### Les fonctions
```javascript []
// Fonction anonyme utilisée avec map
const noms = ["Alice", "Bob", "Charlie"];
const messages = noms.map(function(nom) {
    return `Bonjour, ${nom} !`;
});

console.log(messages); 
// ["Bonjour, Alice!", "Bonjour, Bob!", "Bonjour, Charlie!"]
```
---
### Les fonctions
```javascript []
// Définir une fonction classique
const noms = ["Alice", "Bob", "Charlie"];
const messages = noms.map((nom) => {
    return `Bonjour, ${nom} !`;
});

console.log(messages);
// ["Bonjour, Alice!", "Bonjour, Bob!", "Bonjour, Charlie!"]
```
---
### Les fonctions
```javascript []
// Définir une fonction classique
const noms = ["Alice", "Bob", "Charlie"];
const messages = noms.map(nom => `Bonjour, ${nom} !`);

console.log(messages);
// ["Bonjour, Alice!", "Bonjour, Bob!", "Bonjour, Charlie!"]
```

---
### Gestion des evenememts
```html []
<button id="btn">Cliquez ici</button>

<script>
    const btn = document.getElementById("btn");
    // Ajout d'un listener
    btn.addEventListener("click", function(event) {
        console.log("Le lien a été cliqué !");
    });
</script>
```
---
### Gestion des evenememts
```html []
<button id="btn">Cliquez ici</button>

<script>
    const btn = document.getElementById("btn");
    // Ajout d'un listener
    btn.addEventListener("click", function(event) {
        event.target.innerText="Vous avez cliqué"
        event.target.disabled = true
    });
</script>
```
---
### Gestion des evenememts
```html []
<button id="btn1">Cliquez ici</button>
<button id="btn2">Ou ici</button>

<script>
    function clickEvent(event) {
        event.target.innerText="Vous avez cliqué"
        event.target.disabled = true
    }

    const btn1 = document.getElementById("btn1")
    const btn2 = document.getElementById("btn2")
    
    btn1.addEventListener("click",clickEvent);
    btn2.addEventListener("click",clickEvent);
</script>
```
