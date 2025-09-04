# Événements et parcour
---
### Parcours Père/Fils dans le DOM
```html [8-11|13-19]
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Parcours Père/Fils</title>
</head>
<body>
    <div id="parent">
        <div id="child">Element enfant</div>
    </div>

    <script>
        const child = document.getElementById("child");

        // Trouver l'élément parent le plus proche
        const parentDiv = child.parentElement
        
        console.log("Parent <div> trouvé : ", parentDiv);
        console.log("enfants du parent trouvé : ", parentDiv.children);
        
    </script>
</body>
</html>
```
---
### Parcours Père/Fils dans le DOM
```html [8-14|17-21]
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Parcours Père/Fils</title>
</head>
<body>
    <div id="parent">
        <div>
            <ul>
                <li id="child">Lorem ipsum</li>
            </ul>
        </div>
    </div>

    <script>
        const child = document.getElementById("child");

        // Trouver l'élément parent le plus proche
        const parentDiv = closest('#parent')
        console.log("Parent <div> trouvé : ", parentDiv);
    </script>
</body>
</html>
```
---
### La propagation par défaut
```html []
<a id="link" href="cour.salimkhraimeche.fr">Le cours de JS</a>

<script>
    const link = document.getElementsBy('link');

    // Arrêt de propagation sur l'enfant
    link.addEventListener("click", (event) => {
        console.log("Clic sur le lien");
        event.preventDefault(); // Arrête la propagation ici
    });

    parent.addEventListener("click", () => console.log("Clic sur le parent"));
</script>
```

---
### La propagation 
```html []
<div id="parent" style="width: 200px; height: 200px; background-color: lightblue;">
    <button id="child">Cliquez sur moi</button>
</div>

<script>
    const parent = document.getElementById("parent");
    const child = document.getElementById("child");

    // Ajout de gestionnaires d'événements
    parent.addEventListener("click", () => console.log("Clic sur le parent (bouillonnement)"));
    child.addEventListener("click", () => console.log("Clic sur l'enfant"));

    // Résultat en cliquant sur l'enfant :
    // - "Clic sur l'enfant"
    // - "Clic sur le parent (bouillonnement)"
</script>
```

---
### La propagation
```html []
<div id="parent" style="width: 200px; height: 200px; background-color: lightblue;">
    <button id="child">Cliquez sur moi</button>
</div>

<script>
    const parent = document.getElementById("parent");
    const child = document.getElementById("child");

    // Phase de capture
    parent.addEventListener("click", () => console.log("Clic capturé sur le parent"), true);
    child.addEventListener("click", () => console.log("Clic capturé sur l'enfant"), true);

    // Résultat en cliquant sur l'enfant :
    // - "Clic capturé sur le parent" (Phase de capture)
    // - "Clic capturé sur l'enfant" (Phase de capture)
    // - "Clic sur l'enfant" (Phase de cible)
    // - "Clic sur le parent (bouillonnement)" (Phase de bouillonnement)
</script>
```
---

