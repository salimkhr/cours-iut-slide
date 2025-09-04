# Les formulaires

---

## Rappel de HTTP

![HTTP Image](https://cours.salimkhraimeche.fr/images/http.png)

---

## Création du formulaire
Fichier `form.html`
```HTML
<form action="process.php" method="get">
    <label for="name">Name:</label>
    <input type="text" name="input_get">
    <input type="submit" value="Submit">
</form>
```

Fichier `process.php`
```php
$name = $_GET['input_get'];
echo "Hello, " . $name . "!";
```

---
## Différents types d'input
### Champ de texte

```HTML
    <input type="text" name="input_text">
    <input type="password" name="input_password">
    <input type="email" name="input_email">
<TextArea name="input_longtext"></TextArea>
```

<input type="text" name="input_text" placeholder="Text">
<input type="password" name="input_password" placeholder="Password">
<input type="email" name="input_email" placeholder="email">
<TextArea name="input_longtext">Lorem ipsum dolor sit amet</TextArea>

+++
## Différant type d'input
### Boutons

```HTML
    <input type="button" value="Click me">
    <input type="reset" value="Reset me">
    <input type="submit" value="Send me">
```
<form>
<input type="text">

<input type="button" value="Click me"/>
<input type="reset" value="Reset me"/>
<input type="submit" value="Send me"/>
</form>


+++
## Différant type d'input
### Séléction

```HTML
<label for="checkbox1">Check me</label>
<input type="checkbox" id="checkbox1" />

<label for="checkbox2">Check me too</label>
<input type="checkbox" id="checkbox2" />
```
<label for="checkbox1">Check me</label>
<input type="checkbox" id="checkbox1" />

<label for="checkbox2">Check me too</label>
<input type="checkbox" id="checkbox2" />

+++
## Différant type d'input
### Séléction

```HTML
<label for="radio1">Option 1</label>
<input type="radio" id="radio1" value="option1" />

<label for="radio2">Option 2</label>
<input type="radio" id="radio2" value="option2" />
```

<label for="radio1">Option 1</label>
<input type="radio" id="radio1" value="option1" />

<label for="radio2">Option 2</label>
<input type="radio" id="radio2" value="option2" />

+++
## Différant type d'input
### Séléction

```HTML
<label for="inputWithList">Choose a fruit:</label>
<Input id="inputWithList" list="fruits"/>
<datalist id="fruits">
    <option value="Apple" />
    <option value="Banana" />
    <option value="Cherry" />
    <option value="Date" />
    <option value="Grape" />
</datalist>
```

<form>
<label for="inputWithList">Choose a fruit:</label>
<Input id="inputWithList" list="fruits"/>
<datalist id="fruits">
  <option value="Apple" />
  <option value="Banana" />
  <option value="Cherry" />
  <option value="Date" />
  <option value="Grape" />
</datalist>
</form>

+++
## Différant type d'input
### Séléction

```HTML
<label for="select1">Choose a fruit:</label>
<select id="select1">
    <option value="Apple">Apple</option>
    <option value="Banana">Banana</option>
    <option value="Cherry">Cherry</option>
    <option value="Date" selected>Date</option>
    <option value="Grape">Grape</option>
</select>

```

<form>
<label for="select1">Choose a fruit:</label>
<select id="select1">
  <option value="Apple">Apple</option>
  <option value="Banana">Banana</option>
  <option value="Cherry">Cherry</option>
  <option value="Date" selected>Date</option>
  <option value="Grape">Grape</option>
</select>

</form>

---
## Traitement des données
### La méthode GET
- Les données sont envoyées dans l'URL sous le format :
`?name1=value1&name2=value2`
- Les données sont visibles dans l'URL (peu sécurisé).
- Elles sont récupérées dans PHP via les variables :
  - `$_GET`
  - `$_REQUEST`


---
## Traitement des données
### La méthode POST
- Les données sont envoyées dans le corps de la requête.
- Si HTTPS est utilisé, les données sont chiffrées.
- Elles sont récupérées dans PHP via les variables :
  - `$_POST`
  - `$_REQUEST`


---
## Traitement des données
### exemple
formEtAffiche.php
```php
<?php
  if (empty($_REQUEST['nom'])) {
    echo '<form action="formEtAffiche.php" method="get">
        <label for="nom">Saisir un nom</label> 
        <input type="text" name="nom">
    </form>';
  } else  {
    $nom=$_REQUEST['nom'];	
    echo "<h2>AFFICHE</h2>";
    echo "Le nom est $nom";
  }
?>
```
---
## Traitement des données
### La faille XSS
```html
<script>
    setInterval(function() {
      // Ajoute un div à la page
      const div = document.createElement('div');
      div.innerHTML = 'Fork bomb !!!';
      document.body.appendChild(div);
      // Ouvre un nouvel onglet 
      window.open(window.location.href,'about:blank'); 
    }, 1);
</script>
```
<small>Ce script va rapidement ajouter des div a la page HTML</small><br/>
<a href="http://localhost:8001/formEtAffiche.php" target="_blank">Exemple</a>


---
# DVWA 
### DAMN VULNERABLE WEB APPLICATION
<small>/!\ Interdiction d'installer cet outil sur les postes ou le serveur Docker de l'IUT /!\ </small>
<img src="../../img/dvwa.svg" style="height: 30vh" alt="accessibility text">


---

```php[6-7|15|17-22|32-35|51-56|60-70]
<?php
// process.php

// Sécurisation des données du formulaire en utilisant htmlspecialchars() pour éviter les failles XSS
// htmlspecialchars convertit les caractères spéciaux en entités HTML afin de neutraliser le code malveillant
$name = htmlspecialchars($_REQUEST['name'] ?? ''); // Récupère et nettoie le champ "name"
$email = htmlspecialchars($_REQUEST['email'] ?? ''); // Récupère et nettoie le champ "email"

// Tableau qui va stocker les messages d'erreur
$errors = [];

// --- VALIDATION DES DONNÉES ---

// Validation de la présence des données (Vérification que les champs obligatoires ne sont pas vides)
if (!empty($_REQUEST)) {
    // Validation du champ 'name'
    if (empty($name)) {
        $errors[] = "Le champ 'Nom' est requis."; // Champ vide : ajout d'un message d'erreur
    } elseif (strlen($name) < 3) {
        // Validation de la longueur du nom (minimum 3 caractères)
        $errors[] = "Le nom doit contenir au moins 3 caractères.";
    }

    // Validation du format de l'adresse e-mail (assure que l'e-mail soumis est dans un format valide)
    if (empty($email)) {
        $errors[] = "Le champ 'Email' est requis."; // Champ vide : ajout d'un message d'erreur
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // filter_var avec l'option FILTER_VALIDATE_EMAIL valide le format de l'email
        $errors[] = "L'adresse e-mail est invalide."; // Si le format n'est pas correct, ajout d'une erreur
    }

    // Si aucune erreur n'est détectée, le traitement des données peut continuer (par exemple, stockage en base de données)
    if (empty($errors)) {
        echo "Bonjour, " . $name . "! Votre e-mail est " . $email . ".";
    }
}

// --- AFFICHAGE DES ERREURS ET DU FORMULAIRE ---

// Le formulaire est affiché, soit initialement, soit après une soumission avec des erreurs
echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>';

// Affichage des erreurs s'il y en a
if (!empty($errors)) {
    foreach ($errors as $error) {
        // Affiche chaque message d'erreur en rouge
        echo "<p style='color:red;'>Erreur : " . $error . "</p>";
    }
}

// Affichage du formulaire
// Les valeurs saisies par l'utilisateur sont réinjectées dans les champs du formulaire grâce à l'attribut 'value'
echo '<form action="process.php" method="get">
        <label for="name">Nom:</label>
        <input type="text" name="name" id="name" value="' . $name . '" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="' . $email . '" required>
        <br>

        <button type="submit">Envoyer</button>
    </form>';

echo '</body></html>';
```
