# PHP
## PHP Hypertext Preprocessor

---

```PHP []
    <!DOCTYPE html>
        <html>
        <body> 
            <?php
                echo "bonjour";
            ?>
        </body>
    </html>
```

---

```PHP []
<!DOCTYPE html>
    <html>
        <body>
            mon premier programme php :
        <?php
             print ( date( "d/m/Y" ) );
        ?>
        </body>
    </html>
```
<small>
<ul>
<li> par quoi a été remplacé le script php <b>print ( date("d/m/Y") );</b> ?</li>
<li> est-ce la date du serveur ou du client qui est affichée ?</li>
</ul>
</small>
---

## Gestion des string
### Différence entre les Guillemets Simples et Doubles

- En PHP, vous pouvez utiliser pour définir des chaînes de caractères :
    - des guillemets simples (`'`)
    - des guillemets doubles (`"`)

---
## Gestion des string
### Guillemets Simples ('')

- Les variables et les \n \t... dans des ' ' sont ignoré.

```PHP []
  <?php
      $nom = 'Alice';
      echo 'Bonjour,\t $nom !'; 
      //Affiche : Bonjour,\t $nom !
  <?
```
---
## Gestion des string
### Guillemets Doubles (" ")

- Les variables et les \n \t... dans des " " sont interprété.
  ```PHP []
  <?php
      $nom = 'Bob';
      echo "Bonjour,\t $nom !"; 
      //Affiche : Bonjour,  Bob !
  <?
  ```
---

## Gestion des string
```PHP [2-12|2,4|2,5|2,6|2,7|2,8|2,9|2,10|2,11]
<?php
  $i = "Bonjour";

  echo 'Essai $i<br>';
  echo 'Essai 2 $i<br>\n';
  echo "Essai $i<br>";
  echo "Essai 2 $i\n<br>";
  echo 'Essai '.$i.'<br>';
  echo 'Essai 2 '.$i."<br>\n";
  echo 'Un texte avec "des guillemets"<br>';
  echo "Un texte avec \"des guillemets\"<br>";
?>
```
---

## Exemple de Structure "if" en PHP
```PHP []
<?php
  $note = 18;
  if ($note >= 10) {
      echo "Félicitations!";
  } else {
      echo "Vous avez échoué.";
  }
  //Affiche : Félicitations!
?>
```
---

## Exemple de Structure "if ternaire" en PHP
```PHP []
<?php
 $note = 18;
 echo $note >= 10 ? "Félicitations !" : "Vous avez échoué." ;
 //Affiche : Félicitations!
?>
```
---
## Exemple de Structure "if" en PHP

Deux opérateurs utilisés pour tester les égalités :
  - `==` (égalité) 
  - `===` (égalité stricte).

---
## Exemple de Structure "if" en PHP
### Opérateur `==` (Égalité)

- Test de l'égalité **sans tenir compte du type de données**.
- Exemple : `5=='5'` est **vrai** car les valeurs sont égales.

---
## Exemple de Structure "if" en PHP
##### Opérateur `===` (Égalité Stricte)

- Test de l'égalité **en tenant compte du type de données**.
- Exemple : `5==='5'` est **faux** car les types de données sont différents.

---
## Exemple de Structure " ?? (fusion null)" en PHP
```PHP []
<?php
  $i = null 
  echo $i ?? 0;
  //Affiche : 0
  
  $i = 1 
  echo $i ?? 0;
  //Affiche : 1
?>
```
---
## Exemple de Structure "switch" en PHP
```PHP []
<?php
  $jour = 'Lundi';
  
  switch ($jour) {
      case 'Lundi':
          echo 'C\'est le début de la semaine.';
          break;
      case 'Vendredi':
          echo 'Le week-end approche.';
          break;
      default:
          echo 'Jour non spécifié.';
  }
  //Affiche : C'est le début de la semaine.
<?
```
---
## Exemple de Structure "match" en PHP (>8.0)
```php
<?php
    $note = 11;
    $message = match ($note) {
        $note >= 12 => 'Félicitations!',
        $note >= 10 => 'Vous avez réussi de justesse.',
        default => 'vous avez échoué.'
    };
    echo $message;
   //Affiche : Vous avez réussi de justesse.
<?
```

---
## Exemple de Structure "while" en PHP
```PHP []
<?php
    $compteur = 1;
    while ($compteur <= 5) {
        echo 'Tour '.$compteur/'<br>';
        $compteur++;
    }
<?
```
Il existe aussi le do...while
---
## Exemple de Structure "for" en PHP
```php
<?php
    for ($i = 1; $i <= 5; $i++) {
        echo 'Tour '.$i.'<br>';
    }
<?  
```
---
## Exemple de Structure "foreach" en PHP
```PHP []
<?php
    $prenoms = ["Alice", "Bob", "Charlie"];
    
    foreach ($prenoms as $prenom) {
        echo 'Bonjour, '.$prenom.'<br>';
    }
<?
```

