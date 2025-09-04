# Les Tableaux
---

## Déclaration d'un tableau
```php
// tableaux indexés
$colors = ['red', 'green', 'blue'];

//tableaux associatifs.
$person = ['name' => 'Alice', 'age' => 30];
```

---
## Itération sur un tableau
```php
foreach ($colors as $color) 
{ 
    echo $color . ' '; 
}

foreach ($person as $key => $value) 
{ 
    echo $key . ': ' . $value . ' '; 
}
```

---
## Ajout d'un item
```php
<?php
    // Indexed Array
    $colors = ['red', 'green', 'blue'];
    $colors[] = 'yellow'; // Adding a new element
    echo $colors[3]; // Outputs "yellow"
?>
```
---
## Ajout d'un item
```php
<?php
    // Indexed Array
    $person = ['name' => 'Alice', 'age' => 30];
    $person['email'] = 'aliceDu76@gmail.com'; // Adding a new element
    echo $person['email']; // Outputs "aliceDu76@gmail.com"
?>
```


---
## Destructuration des tableaux
```php
list($first, $second) = ['red', 'green'];
echo $first;  // red
echo $second; // green
```

