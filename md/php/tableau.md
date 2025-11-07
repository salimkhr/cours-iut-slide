## Plan du cours

- A- Les tableaux indexés
- B- Les tableaux associatifs
- C- Les tableaux multidimensionnels
- D- Les fonctions
- F- Les chaînes de caractères

---

## A- Les tableaux indexés

- Structure de données la plus simple
- Stockage de plusieurs valeurs sous un seul nom
- Accès par index numérique

---

## Création et manipulation

```php[1-5|7-9|11-12|14-17|19-22]
<?php
// 1. Création d'un tableau indexé
$fruits = ["Pomme", "Banane", "Cerise"];
// Syntaxe alternative (plus ancienne)
$couleurs = array("Rouge", "Vert", "Bleu");

// 2. Accès aux éléments
echo $fruits[0];  // "Pomme" (premier élément)
echo $fruits[2];  // "Cerise" (troisième élément)

// 3. Modification d'un élément
$fruits[1] = "Orange";  // Remplace "Banane" par "Orange"

// 4. Ajout d'éléments
$fruits[] = "Kiwi";           // Ajoute à la fin
$fruits[10] = "Ananas";       // Ajoute à l'index 10
array_push($fruits, "Mangue"); // Ajoute à la fin (fonction)

// 5. Suppression d'éléments
unset($fruits[0]);    // Supprime l'élément à l'index 0
array_pop($fruits);   // Supprime le dernier élément
array_shift($fruits); // Supprime le premier élément
?>
```

---

## Parcours des tableaux

```php[2|4-7|9-12|14-17]
<?php
$nombres = [10, 20, 30, 40, 50];

// Méthode 1 : foreach (recommandée)
foreach ($nombres as $nombre) {
    echo $nombre . " ";
}

// Méthode 2 : foreach avec index
foreach ($nombres as $index => $nombre) {
    echo "Index $index : $nombre\n";
}

// Méthode 3 : boucle for classique
for ($i = 0; $i < count($nombres); $i++) {
    echo "Élément $i : " . $nombres[$i] . "\n";
}
?>
```

---

## Fonctions utiles pour tableaux indexés

| Fonction | Description | Exemple |
|----------|-------------|---------|
| `count()` | Nombre d'éléments | `count($tab)` → 5 |
| `empty()` | Vérifie si vide | `empty($tab)` → false |
| `isset()` | Vérifie existence index | `isset($tab[2])` → true |
| `sort()` | Tri croissant | `sort($tab)` |
| `rsort()` | Tri décroissant | `rsort($tab)` |
| `shuffle()` | Mélange aléatoire | `shuffle($tab)` |
| `in_array()` | Recherche valeur | `in_array(3, $tab)` → true |

---

# B- Les tableaux associatifs

- Relation **clé → valeur**
- Clés peuvent être des chaînes ou nombres
- Idéal pour données structurées
- Équivalent aux dictionnaires/maps d'autres langages

---

## Syntaxe et utilisation

```php[2-8|10-12|14-16|18-19|21-24]
<?php
// 1. Création d'un tableau associatif
$personne = [
    "nom" => "Dupont",
    "prenom" => "Jean",
    "age" => 35,
    "ville" => "Paris"
];

// 2. Accès aux éléments
echo $personne["nom"];     // "Dupont"
echo $personne["age"];     // 35

// 3. Modification et ajout
$personne["age"] = 36;     // Modifie l'âge
$personne["email"] = "jean.dupont@email.com"; // Ajoute une nouvelle clé

// 4. Suppression
unset($personne["ville"]); // Supprime la clé "ville"

// 5. Vérification d'existence
if (isset($personne["email"])) {
    echo "Email : " . $personne["email"];
}
?>
```

---

## Parcours et fonctions spécialisées

```php[2-7|9-12|14-17|20-22]
<?php
$notes = [
    "Mathématiques" => 15,
    "Français" => 12,
    "Histoire" => 14,
    "Anglais" => 16
];

// Parcours avec clé et valeur
foreach ($notes as $matiere => $note) {
    echo "$matiere : $note/20\n";
}

// Fonctions spécifiques
array_keys($notes);      // ["Mathématiques", "Français", "Histoire", "Anglais"]
array_values($notes);    // [15, 12, 14, 16]
array_flip($notes);      // [15 => "Mathématiques", 12 => "Français", ...]

// Tri associatif
asort($notes);   // Tri par valeurs (conserve les associations)
ksort($notes);   // Tri par clés
arsort($notes);  // Tri par valeurs décroissant
?>
```

---

# C- Les tableaux multidimensionnels

- Représentation de données complexes
- Structures hiérarchiques
- Matrices et grilles
- Données organisées en plusieurs niveaux

---

## Types de structures

```php[2-7|8|10-22|24-34]
<?php
// 1. Tableau 2D indexé (matrice)
$matrice = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];
echo $matrice[1][2]; // 6 (ligne 1, colonne 2)

// 2. Tableau 2D associatif
$etudiants = [
    [
        "nom" => "Martin",
        "age" => 20,
        "notes" => [15, 12, 18]
    ],
    [
        "nom" => "Durand", 
        "age" => 21,
        "notes" => [16, 14, 13]
    ]
];

// 3. Structure complexe d'entreprise
$entreprise = [
    "employés" => [
        "dev" => ["Alice", "Bob"],
        "design" => ["Charlie", "David"]
    ],
    "projets" => [
        "site_web" => ["statut" => "actif", "budget" => 5000],
        "app_mobile" => ["statut" => "terminé", "budget" => 8000]
    ]
];
?>
```

---

## Manipulation et parcours

```php[2-11|14-19|21-22|24-25]
<?php
$equipes = [
    "Alpha" => [
        ["nom" => "Jean", "role" => "leader"],
        ["nom" => "Marie", "role" => "dev"]
    ],
    "Beta" => [
        ["nom" => "Paul", "role" => "design"],
        ["nom" => "Lisa", "role" => "test"]
    ]
];

// Parcours complet
foreach ($equipes as $nomEquipe => $membres) {
    echo "Équipe $nomEquipe :\n";
    foreach ($membres as $membre) {
        echo "- {$membre['nom']} ({$membre['role']})\n";
    }
}

// Ajout d'un membre
$equipes["Alpha"][] = ["nom" => "Tom", "role" => "marketing"];

// Comptage récursif
count($equipes, COUNT_RECURSIVE); // Compte tous les éléments
?>
```

---

# D- Les fonctions

---

## Syntaxe de base et typage

```php[2-5|7-10|12-14|18-27]
<?php
// Fonction simple sans paramètres
function direBonjour(): string {
    return "Bonjour tout le monde !";
}

// Fonction avec paramètres typés
function calculerSomme(int $a, int $b): int {
    return $a + $b;
}

// Fonction avec paramètres par défaut
function saluer(string $nom = "Visiteur", string $titre = "M./Mme"): string {
    return "Bonjour $titre $nom !";
}

// Types supportés
function exempleTypes(
    string $texte,        // Chaîne de caractères
    int $entier,          // Nombre entier
    float $decimal,       // Nombre décimal
    bool $boolean,        // Booléen
    array $tableau,       // Tableau
    ?string $optionnel    // string ou null
): void {                 // void = aucun retour
    // Traitement...
}
?>
```

---

```php[2-5|7-10|12-14|18-27]
<?php
// Fonction avec paramètres par défaut
function saluer(
string $nom = "Visiteur",
 string $titre = "M./Mme"): string {
    return "Bonjour $titre $nom !";
}

saluer(); // "Bonjour M./Mme Visiteur !"
saluer('Toto'); // "Bonjour M./Mme Toto !"
saluer('Toto','M.'); // "Bonjour M. Toto !"
saluer(titre:'Maitre'); // "Bonjour Maitre Visiteur !"

?>
```

---
## Types de données supportés

| Type | Description | Exemple |
|------|-------------|---------|
| `string` | Chaîne de caractères | `"Hello World"` |
| `int` | Nombre entier | `42` |
| `float` | Nombre décimal | `3.14` |
| `bool` | Booléen | `true`, `false` |
| `array` | Tableau | `[1, 2, 3]` |
| `?type` | Type nullable | `?string` (string ou null) |
| `void` | Aucun retour | Fonction qui ne retourne rien |

---

# F- Les chaînes de caractères

## Types de chaînes en PHP

**Quatre syntaxes de chaînes** :

1. **Simple quotes (`''`)** : Contenu littéral, variables non interprétées
2. **Double quotes (`""`)** : Variables interpolées, caractères d'échappement reconnus
3. **Heredoc** : Texte multiligne avec interpolation
4. **Nowdoc** : Texte multiligne sans interpolation

---

## Syntaxes et interpolation

```php[2-3|56-8-10|12-13]
<?php
$nom = "Alice";
$age = 25;

// 1. Simple quotes - Interprétation littérale
$message1 = 'Bonjour $nom'; // Affiche: Bonjour $nom

// 2. Double quotes - Interpolation de variables
$message2 = "Bonjour $nom"; // Affiche: Bonjour Alice
$message3 = "Tu as $age ans"; // Affiche: Tu as 25 ans

// 3. Syntaxe complexe avec accolades
$message4 = "Bonjour {$nom}, tu as {$age} ans";

// 4. Concaténation
$message5 = "Bonjour " . $nom . ", tu as " . $age . " ans";
$phrase = "Bonjour ";
$phrase .= $nom;  // Opérateur .= pour concaténer

// 5. Heredoc - Multilignes avec interpolation
$texteHeredoc = <<<EOT
Nom: $nom
Âge: $age
Message: Bienvenue sur notre site !
EOT;

// 6. Nowdoc - Multilignes sans interpolation
$texteNowdoc = <<<'EOT'
Nom: $nom
Âge: $age
Message: Les variables ne sont pas interprétées
EOT;
?>
```
---

## Fonctions de manipulation courantes

| Fonction | Description | Exemple |
|----------|-------------|---------|
| `trim()` | Supprime espaces début/fin | `trim("  text  ")` → "text" |
| `strlen()` | Longueur chaîne | `strlen("hello")` → 5 |
| `strtolower()` | Conversion minuscules | `strtolower("HELLO")` → "hello" |
| `strtoupper()` | Conversion majuscules | `strtoupper("hello")` → "HELLO" |
| `substr()` | Extraction sous-chaîne | `substr("hello", 1, 3)` → "ell" |
| `strpos()` | Position sous-chaîne | `strpos("hello", "ll")` → 2 |
| `str_replace()` | Remplacement | `str_replace("old", "new", $str)` |
| `explode()` | Découpage en tableau | `explode(" ", "a b c")` → ["a","b","c"] |

---
# Questions ?