
# Les Fonctions
---

## Définition d’une fonction
```php
function calculatePrice(
    float $price,
    float $tax,
    float $discount
): float {
    return $price * (1 + $tax) - $discount;
}

echo calculatePrice(100, 0.2, 10);
```
---

# Les Fonctions en PHP
## Paramètres Optionnels
```php
function calculatePrice(
    float $price,
    float $tax = 0.2,
    float $discount = 0
): float {
    return $price * (1 + $tax) - $discount;
}

echo calculatePrice(100);
```
---

## Arguments Nommés
```php
function calculatePrice(
    float $price,
    float $tax = 0.2,
    float $discount = 0
): float {
    return $price * (1 + $tax) - $discount;
}

echo calculatePrice(100, discount: 5);
```
