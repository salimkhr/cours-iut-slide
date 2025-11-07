# Les formulaires en HTML & PHP

---

## 1. Rappel de HTTP

![HTTP Image](https://cours.salimkhraimeche.fr/images/http.png)

---

## 2. Création d'un formulaire (exemple simple)

**form.html**

```html[8-12]
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Formulaire</title>
</head>
<body>
  <form action="process.php" method="get">
    <label for="name">Name :</label>
    <input id="name" type="text" name="input_get" required>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
```

---

## 3. Types de champs (exemples)

### Champs texte

```html
<input type="text" name="input_text" placeholder="Texte">
<input type="password" name="input_password" placeholder="Mot de passe">
<input type="email" name="input_email" placeholder="email@example.com">
<textarea name="input_longtext">Texte long...</textarea>
```

---

### Boutons

```html
<input type="button" value="Click me">
<input type="reset" value="Réinitialiser">
<input type="submit" value="Envoyer">
```

---

### Cases à cocher (checkbox)

```html
<label for="checkbox1">Case 1</label>
<input type="checkbox" id="checkbox1" name="opt[]" value="1">

<label for="checkbox2">Case 2</label>
<input type="checkbox" id="checkbox2" name="opt[]" value="2">
```

---

### Boutons radio (choix unique)

```html
<label><input type="radio" name="choice" value="option1"> Option 1</label>
<label><input type="radio" name="choice" value="option2"> Option 2</label>
```

---

### Datalist (suggestions)

```html
<label for="inputWithList">Choose a fruit :</label>
<input id="inputWithList" name="fruit" list="fruits">
<datalist id="fruits">
  <option value="Apple">
  <option value="Banana">
  <option value="Cherry">
  <option value="Date">
  <option value="Grape">
</datalist>
```

---

### Select (liste déroulante)

```html
<label for="select1">Choose a fruit :</label>
<select id="select1" name="fruit">
  <option value="Apple">Apple</option>
  <option value="Banana">Banana</option>
  <option value="Cherry">Cherry</option>
  <option value="Date" selected>Date</option>
  <option value="Grape">Grape</option>
</select>
```

---

## 4. Transmission des données en PHP

| Méthode  | Caractéristiques                                                                                   | Usage recommandé                          |
| -------- | -------------------------------------------------------------------------------------------------- | ----------------------------------------- |
| **GET**  | Données visibles dans l’URL, limitées (~2000 chars), cache possible                                | Recherches, filtres                       |
| **POST** | Données envoyées dans le corps HTTP, non visibles dans l’URL, meilleure pour les données sensibles | Connexion, inscription, envoi de messages |

---
## 4. Traitement des données
### Format GET

* URL : `?name1=value1&name2=value2`
* Récupération en PHP : `$_GET` ou `$_REQUEST`

### Format POST

* Données dans le corps de la requête
* Récupération en PHP : `$_POST` ou `$_REQUEST`

---

## 5. Validation côté serveur (exemple)

```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
  $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');

  if (empty($name)) echo "Le nom est requis.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) echo "Email invalide.";
}
?>
```

---

## 6. Sécurité — XSS

⚠️ **Vulnérable**

```php
<?php
$name = $_POST['name'];
echo "Bonjour " . $name;
?>
```

Si l'utilisateur envoie `<script>alert('XSS')</script>`, le script s'exécutera.

✅ **Sécurisé**

```php
<?php
$name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
echo "Bonjour " . $name;
?>
```

---

## 7. Exemple complet : formulaire de contact

### a) Initialisation

```php
<?php
$errors = [];
$success = false;
$name = '';
$email = '';
$message = '';
?>
```

### b) Traitement POST et validation

```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $message = trim($_POST['message'] ?? '');

  // Validation
  if ($name === '') {
    $errors[] = "Le nom est requis.";
  }
  if ($email === '') {
    $errors[] = "L'email est requis.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide.";
  }
  if ($message === '') {
    $errors[] = "Le message est requis.";
  } elseif (mb_strlen($message) < 10) {
    $errors[] = "Le message doit contenir au moins 10 caractères.";
  }

  if (empty($errors)) {
    // Traitement : envoi d'email, enregistrement en BDD, etc.
    $success = true;
    $name = $email = $message = '';
  }
}
?>
```

### c) HTML d'affichage

```html
<h1>Contactez-nous</h1>

<?php if ($success): ?>
  <p class="success">✓ Votre message a été envoyé !</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="error">
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" novalidate>
  <label for="name">Nom :</label>
  <input id="name" type="text" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required>

  <label for="email">Email :</label>
  <input id="email" type="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>

  <label for="message">Message :</label>
  <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></textarea>

  <button type="submit">Envoyer</button>
</form>
```

---

## 8. Récapitulatif

* HTML : `name` obligatoire pour chaque input. Utiliser les attributs HTML5 (`required`, `pattern`, `min`, `max`, `autocomplete`).
* PHP : `GET` pour les recherches/filtrages, `POST` pour les données sensibles.
* Toujours valider côté serveur et échapper les données avant affichage (`htmlspecialchars`).
* Vérifier les formats (`filter_var`, expressions régulières) et gérer les valeurs par défaut avec l'opérateur `??`.

---

## 9. À propos de DVWA

**DVWA — DAMN VULNERABLE WEB APPLICATION**

> *Interdiction d'installer cet outil sur les postes ou le serveur Docker de l'IUT.*

<img src="../../img/dvwa.svg" style="height:30vh" alt="DVWA logo">

