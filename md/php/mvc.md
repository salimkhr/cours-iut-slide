# Le Pattern MVC
## Modèle-Vue-Contrôleur

---

## Problématique du développement web

### Le "Spaghetti Code"

- Code mélangé : logique et HTML dans les mêmes fichiers

- Manque de lisibilité
- Duplication importante
- Difficultés de maintenance
- Forte probabilité d'erreurs

---
## Problématique du développement web
### Solution : Le Pattern MVC

**Architecture de séparation des responsabilités**

- **M**odèle : Données et logique métier

- **V**ue : Affichage et présentation
- **C**ontrôleur : Coordination et orchestration

---

## Le Modèle

### Responsabilités
- Gère les données de l'application

- Contient la logique métier
- Valide les données selon les règles business

---

## La Vue

### Responsabilités
- Se consacre exclusivement à l'affichage
- Détermine **comment** présenter les données
- N'a aucune responsabilité sur **quoi** afficher

### Principe
La Vue reçoit des données et génère du HTML

---

## Le Contrôleur

### Responsabilités
- Réceptionne les requêtes utilisateur
- Orchestre le traitement des données
- Sélectionne la vue appropriée

### Rôle de coordinateur
Interface entre l'utilisateur et l'application

---

## Flux d'une requête MVC

1. Utilisateur → Requête HTTP
2. Point d'entrée → Instancie le contrôleur
3. Contrôleur → Sollicite le modèle
4. Modèle → Retourne les données
5. Contrôleur → Appelle la vue
6. Vue → Génère le HTML
7. Navigateur → Affiche la réponse

---

### Arborescence du projet

```[]
project_tp/
├── public/           ← Accessible par le navigateur
│   ├── index.php
│   └── article.php
├── app/
│   ├── controllers/  ← Contrôleurs
│   ├── views/        ← Templates
│   └── core/         ← Classes de base
└── config/
    └── config.php
```
---


### Arborescence du projet
#### /app

```txt[1|3|5|7|9|11|13]
app/
 │
 ├── controllers/
 │ 
 ├── entities/
 │
 ├── repositories/
 │
 ├── trait/
 │
 ├── views/
 │
 └─ core/
```

---
### Arborescence du projet
#### /app/controllers

```php[1|3|5-12|14-19|22-24]
require_once '../app/core/Controller.php';

class HelloWorldController extends Controller
{
    public function index():void
    {
      $this->view(
        'hello_world',
        'Titre',
        ['name' => 'Salim']
        );
    }

    public function indexJson():void
    {
      $this->json([
        'title' => 'Titre',
        'name' => 'Salim']
      );
    }

    public function redirectToJson()
    {
        $this->redirectTo('/json.php');
    }
}

```
---
### Arborescence du projet
#### /app/core/

```php[1|2|5-9|11-12|14-21|24-29|31-34]
abstract class Controller {
    protected $viewPath = '../app/views/'; // Chemin vers les vues


    protected function view(
    string $viewName,
     string $title = 'Titre de la page',
      array $data = [],
       $status = 200) {

        $filePath = $this->viewPath . 
        $viewName . '.html.php';

        if (file_exists($filePath)) {
            // Extraire les données pour qu'elles soient disponibles dans la vue comme des variables
            extract($data);
            http_response_code($status);
            require $filePath;
        } else {
            throw new Exception("Vue non trouvée : " . $filePath);
        }
    }

    protected function json($data, $status = 200) {
       header('Content-Type: application/json');
       http_response_code($status);
       echo json_encode($data);
       exit();
   }

    protected function redirectTo($url) {
        header("Location: $url");
        exit();
    }
}
```
---

### Arborescence du projet
#### /app/views

```php[]
public function index():void
    {
      $this->view(
        'hello_world',
        'Titre',
       ['article' => $article]
    );
}    
```
---
### Arborescence du projet
#### /app/views
```php[]
<h1><?= $article['title'] ?></h1>

<p>
    <?= $article['content'] ?>
</p>
```
---

### Arborescence du projet
#### /app/views

```php[]
public function index():void
    {
      $this->view(
        'hello_world',
        'Titre',
       ['articles' => $articles, 'isAuthor' => true]
    );
}    
```
---
### Arborescence du projet
#### /app/views
```php[1|5|9]
<?php if ($isAuthor): ?>
    <a href="article_create.php" class="btn">
        Créer un article
    </a>
<?php else: ?>
    <p>
        Seuls les auteurs peuvent créer des articles.
    </p>
<?php endif; ?>
```
---

### Arborescence du projet
#### /app/views

```php[2-13|3|12]
<h2>Liste des articles</h2>
<ul class="articles-list">
<?php foreach ($articles as $article): ?>
    <li>
        <h3>
            <a href="article.php?id=<?= $article['id'] ?>">
                <?= $article['title'] ?>
            </a>
        </h3>
        <p><?= substr($article['content'], 0, 100) ?>...</p>
    </li>
<?php endforeach; ?>
</ul> 
```

---
### Arborescence du projet

| Entities                                              | Repositories                                                  |
|-------------------------------------------------------|---------------------------------------------------------------|
| /app/entities                                         | /app/repositories                                             |
| Classes représentant les tables de la base de données | Connexions à la base de données et exécution des requêtes SQL |

---
### Arborescence du projet

| Rôle       | Dossier                                |
|------------|----------------------------------------|
| Modéle     | - app/entities<br/> - app/repositories |
| Vue        | - app/views                            |
| Controller | - app/controllers                      |
| Routes     | - public                               |