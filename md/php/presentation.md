# student pack jetbrains 

<img src="https://genqrcode.com/embedded?style=3&inner_eye_style=5&outer_eye_style=0&logo=d39c5f8a46783e216f7134dd68237acb&color=%23000000FF&background_color=%23FFFFFFFF&inner_eye_color=%23000000&outer_eye_color=%23000000&imageformat=svg&language=fr&frame_style=0&frame_text=SCAN%20ME&frame_text_icon_color=%23000000&frame_text_icon=null&frame_color=%23000000&frame_background_color=%23FFFFFF&frame_text_color=%23FFFFFF&invert_colors=false&gradient_style=0&gradient_color_start=%23FF0000&gradient_color_end=%237F007F&gradient_start_offset=5&gradient_end_offset=95&stl_type=1&logo_remove_background=null&stl_size=100&stl_qr_height=1.5&stl_base_height=2&stl_include_stands=false&stl_qr_magnet_type=3&stl_qr_magnet_count=0&type=0&text=https%3A%2F%2Fwww.jetbrains.com%2Facademy%2Fstudent-pack%2F&width=500&height=500&bordersize=2" alt="qr code" />

---

# Le programme

| Langage       | Semestre |         Fonctionnalités pour le projet         |
|:-------------:|:--------:|:----------------------------------------------:|
| HTML&nbsp;/&nbsp;CSS | 2        |                   Bootstrap                    |
| PHP           | 3        |       Base de données, Formulaires, ...        |
| JavaScript    | 4        | Utilisation de l'API, Affichage dynamique, ... |

---

# Le programme

| TP | Sujet                     | Séance  |
|:--:|:--------------------------|:--------:|
| 1  | Introduction à PHP et POO |    1     |
| 2  | Fonctions, Tableaux       |    1     |
| 3  | Modèle vue Contrôleur     |    2     |
| 4  | Formulaires               |    2     |
| 5  | Base de données           |    4     |
| 6  | Sessions                  |    1     |
| 7  | Initiation à Symfony      |    1     |

---

# La notation

|  Type  | Coef  |
|:------:|:-----:|
| Examen |   1   |
|  QCM   |   2   |

---

## Plan du cours

- A- Protocole HTTP
- B- Présentation de PHP 
- C- Programmation Orientée Objet

---

# A- Protocole HTTP

## Introduction au protocole HTTP

**HTTP** (HyperText Transfer Protocol) est le protocole de communication utilisé sur le Web.

**Principe :**
- Le **client** (navigateur) envoie une **requête** au **serveur**
- Le **serveur** traite la requête et renvoie une **réponse**
- Communication sans état (stateless)

---

## Communication entre navigateur et serveur

**Étapes d'une communication HTTP :**

1. **Requête du client** : Le navigateur demande une ressource
2. **Traitement serveur** : Le serveur analyse la demande
3. **Génération de la réponse** : Le serveur prépare le contenu
4. **Envoi de la réponse** : Le serveur renvoie les données au client
5. **Affichage** : Le navigateur interprète et affiche le contenu

---

## Qu'est-ce qu'une URL ?

**URL** = Uniform Resource Locator (Localisateur uniforme de ressource)

**Composants d'une URL :**
- **Protocole** : (HTTP, HTTPS, FTP, SSH ...)
- **Nom du serveur** : le nom de domaine ou adresse IP
- **Numéro de port** : un numéro associé à un service
- **Chemin d'accès** : /dossier/fichier

---

## Structure d'une URL

| Protocole | Nom du serveur              | Port | Chemin                |
|-----------|----------------------------|------|-----------------------|
| http://   | di-web.iut.univ-lehavre.fr | :80  | /pedago/index.xml     |
| https://  | salimkhraimeche.dev        |      | /php/                 |
| ftp://    | files.example.com          | :21  | /documents/file.pdf   |

**Exemple complet :**
`https://www.example.com:8080/dossier/page.php?param=valeur#section`

---

## Les Requêtes HTTP

Une requête HTTP commence par une **méthode** qui indique l'action que le navigateur veut effectuer :

- **GET** : pour récupérer des données depuis le serveur
- **POST** : pour envoyer des données au serveur
- **PUT** : pour mettre à jour une ressource existante
- **DELETE** : pour supprimer une ressource sur le serveur
---

## Codes de réponse HTTP

| Code | Signification        | Exemple                    |
|------|---------------------|----------------------------|
| 2xx  | Succès              | 200 OK                     |
| 3xx  | Redirection         | 301 Moved Permanently     |
| 4xx  | Erreur client       | 404 Not Found              |
| 5xx  | Erreur serveur      | 500 Internal Server Error  |

**Les plus courants :**
- **200** : Succès
- **404** : Page non trouvée
- **500** : Erreur serveur

---

# B- Présentation de PHP

## PHP Hypertext Preprocessor

**PHP** est un langage de scripts, spécialement conçu pour le développement d'applications web.

**Caractéristiques :**
- Langage interprété côté serveur
- Syntaxe inspirée de C, Java et Perl
- Intégration native avec HTML
---

## Syntaxe de base

```php
<?php
    // Ouverture de la balise PHP
    echo "Hello World";
    // Les instructions se terminent par ;
?>
```

**Points importants :**
- Commence toujours par `<?php`
- Instructions séparées par `;`
- Commentaires avec `//` ou `/* */`

---

## Les variables en PHP

<img src="https://lesjoiesducode.fr/content/053/personne-variables-php.jpg" alt="meme PHP" width="400"/>
---

## Les variables en PHP

```php[]
<?php
    $message = "Hello, World!"; // string
    $age = 25;                  // integer
    $price = 19.99;             // float
    $isStudent = true;          // boolean
    $vide = null;               // NULL
    
    // Affichage
    echo $message;
    echo "J'ai $age ans"; // "" uniquement
?>
```
---

## Affichage de Texte

```php[2-3|5-6|8-9|11-12|14-15|18-19]
<?php
    $nom = "Alice";
    $age = 25;
    
    // Echo simple
    echo "Bonjour !";
    
    // Concaténation avec l'opérateur .
    echo "Je m'appelle " . $nom . " et j'ai " . $age . " ans.";
    
    // Interpolation avec guillemets doubles
    echo "Je m'appelle $nom et j'ai $age ans.";
    
    // Print (similaire à echo)
    print "Autre façon d'afficher";
    
    // Pour déboguer
    print_r($variable);
    var_dump($variable);
?>
```
---
## Affichage de Texte

```php[2|9-17]

<? $name = "Charlie" ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Hello World PHP</title>
    </head>
    <body>
        <h1>Ma première page PHP</h1>
        <?php     
            echo "<p>Hello World!</p>";
            echo "<p>Hello $name!</p>";
        ?>
    </body>
</html>
```

---

## Les structures de contrôle
### If

```php[1-7|9-14|16-23]
<?php
    $age = 20;
    
    // Structure if simple
    if ($age >= 18) {
        echo "Vous êtes majeur";
    }
    
    // Structure if-else
    if ($age >= 18) {
        echo "Vous êtes majeur";
    } else {
        echo "Vous êtes mineur";
    }
    
    // Structure if-elseif-else
    if ($age < 13) {
        echo "Enfant";
    } elseif ($age < 18) {
        echo "Adolescent";
    } else {
        echo "Adulte";
    }
?>
```

---

## Les structures de contrôle
### Switch

```php[2|4-9|10-15]
<?php
$humeur = 'triste';

switch($humeur) {
    case 'heureux':
    case 'joyeux':
        echo 'Je suis de bonne humeur';
        break;
        
    case 'triste':
        echo 'bof!!';
        break;
        
    default:
        echo $humeur;
}
?>
```
---

## Les structures de contrôle
### Match

```php[]
<?php
$humeur = 'triste';
echo match ($humeur) {
    'heureux' => 'Je suis de bonne humeur',
    'triste' => 'bof!!',
    default => $humeur,
};
?>
```

---

## Les structures de contrôle
### Boucles

```php[2-5|7-12]
<?php
    // Boucle FOR
    for ($i = 0; $i < 5; $i++) {
        echo "<li>Nombre : $i<li/>";
    }
    
    // Boucle WHILE
    $compteur = 0;
    while ($compteur < 3) {
        echo "<li>Compteur : $compteur <li/>";
        $compteur++;
    }
?>
```

---

# C- Programmation
# Orientée Objet

**Concepts clés :**
- **Classe** : Modèle ou blueprint d'un objet
- **Objet** : Instance d'une classe
- **Propriétés** : Variables de la classe
- **Méthodes** : Fonctions de la classe

---

## Définition d'une classe

```php[2-5|7-14|16-22|24-26]
<?php
class Person {
    // Propriétés (attributs)
    private string $name;
    private int $age;
    
    // Constructeur
  public function __construct(
    string $name,
    int $age
  ) {
        $this->name = $name;
        $this->age = $age;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function setName(string $name): void {
        $this->name = $name;
    }
    
    public function __toString(): string {
        return 'Name: ' . $this->name . ', Age: ' . $this->age;
    }
}
?>
```
---

## Instanciation d'un objet

```php[2-4|6-11]
<?php
    // Créer une instance (objet) de la classe Personne
    $personne1 = new Personne("Dupont Jean", 30);
    $personne2 = new Personne("Martin Marie", 25);
    
    // Utiliser les méthodes
    echo $personne1->getName(); // "Jean Dupont"
    echo $personne2->getName(); // "Marie Martin"
    
    $personne1->setAge(31);     // Modification de l'âge
?>
```
---

## Résumé des concepts POO

**Avantages de la POO :**
- **Encapsulation** : Protection des données
- **Héritage** : Réutilisation du code
- **Polymorphisme** : Flexibilité dans l'utilisation
- **Abstraction** : Simplification des concepts complexes

**Utilisation en PHP :**
- Classes et objets avec `new`
- Visibilité : `public`, `private`, `protected`
- Héritage avec `extends`
- Traits avec `use`
- Méthodes statiques avec `::`
- Classes abstraites et interfaces
---
# Questions ?

---
## TP1 - Application Z-Event
- A- Rappel HTML : Tableau des dons Z-Event
- B- Hello World PHP : Variables et formatage
- C- Debug : var_dump() et die()
- D- Classe Streamer : POO complète

