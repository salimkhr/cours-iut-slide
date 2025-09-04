### Gestion des evenememts
```html
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
```html
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
```html
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

---
### Gestion des evenememts
```html[1-30|1-7|10-12|14-24|26-28]
<div id="outer" style="border: 2px solid red; padding: 20px;">
    <div id="middle" style="border: 2px solid green; padding: 20px;">
        <div id="inner" style="border: 2px solid blue; padding: 20px;">
            Cliquez ici!
        </div>
    </div>
</div>

<script>
    const outer = document.getElementById('outer');
    const middle = document.getElementById('middle');
    const inner = document.getElementById('inner');

    outer.addEventListener('click', function() {
        console.log('outer (Capture)');
    }, true);

    middle.addEventListener('click', function() {
        console.log('middle (Capture)');
    }, true);

    inner.addEventListener('click', function() {
        console.log('inner (Capture)');
    }, true);
    /**
        Clic sur l'élément outer (Capture)
        Clic sur l'élément middle (Capture)
        Clic sur l'élément inner (Capture)
    */
</script>
```

---
### Gestion des evenememts
```html[1-30|1-7|10-12|14-25|27-28]
<div id="outer" style="border: 2px solid red; padding: 20px;">
    <div id="middle" style="border: 2px solid green; padding: 20px;">
        <div id="inner" style="border: 2px solid blue; padding: 20px;">
            Cliquez ici!
        </div>
    </div>
</div>

<script>
    const outer = document.getElementById('outer');
    const middle = document.getElementById('middle');
    const inner = document.getElementById('inner');

    outer.addEventListener('click', function() {
        console.log('outer (Capture)');
    }, true);

    middle.addEventListener('click', function(event) {
        console.log('middle (Capture)');
        event.preventDefault();
    }, true);

    inner.addEventListener('click', function() {
        console.log('inner (Capture)');
    }, true);
    /**
        Clic sur l'élément outer (Capture)
        Clic sur l'élément middle (Capture)
    */
</script>
```

---
### Gestion des evenememts
```html[1-30|1-7|10-12|14-24|26-28]
<div id="outer">
    <div id="middle">
        <div id="inner">
            Cliquez ici!
        </div>
    </div>
</div>

<script>
    const outer = document.getElementById('outer');
    const middle = document.getElementById('middle');
    const inner = document.getElementById('inner');

    outer.addEventListener('click', function() {
        console.log('outer (Propagation)');
    }, true);

    middle.addEventListener('click', function() {
        console.log('middle (Propagation)');
    }, true);

    inner.addEventListener('click', function() {
        console.log('inner (Propagation)');
    }, true);
    /**
        Clic sur l'élément outer (Propagation)
        Clic sur l'élément middle (Propagation)
        Clic sur l'élément inner (Propagation)
     */
</script>
```

---
### Gestion des evenememts
```html [1-12|14-27]
<form id="myForm">
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name"><br><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email"><br><br>

    <label for="message">Message :</label>
    <textarea id="message" name="message"></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>
<script>
// Exemple de code JavaScript pour la gestion de l'événement de soumission du formulaire
    var myForm = document.getElementById("myForm");

    function submitCallback(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var message = document.getElementById("message").value;
    
        console.log("Nom : " + name);
        console.log("Email : " + email);
        console.log("Message : " + message);
    }
    
    myForm.addEventListener("submit", submitCallback);
</script>
```
---
| Type d'Événement      | Rôle                                                                |
|-----------------------|---------------------------------------------------------------------|
| `click`               | cliqué avec la souris.                                              |
| `mousedown`/`mouseup` | bouton de la souris est enfoncé /relâché                            |
| `mousemove`           | mouvement de souris est détecté.                                    |
| `keydown` / `keyup`   | touche du clavier est enfoncée / relâchée.                                  |
| `keypress`            | touche du clavier est enfoncée et libérée.                          |
---
| Type d'Événement      | Rôle                                                                |
|-----------------------|---------------------------------------------------------------------|
| `change`              | valeur d'un élément de formulaire change.                           |
| `submit`              | formulaire est soumis.                                              |
| `focus`               | élément reçoit le focus.                                            |
| `blur`                | élément perd le focus.                                              |
| `load`                | la page ou une ressource est entièrement chargée. |

