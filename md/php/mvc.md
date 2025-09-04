# MVC
## Modele Vue Controller

---

### Arborescence du projet

```txt
project_root/
 │
 ├── app/
 │   
 ├── config/
 │   └── config.php
 │   
 └── public/
```
---
### Arborescence du projet
#### /public

```txt
 public/
     ├── index.php 
     ├── print_hello.php
     └── css/
         └── style.css
```
---
### Arborescence du projet
#### /public/print_hello.php

```php
<?php
    require_once '../app/controllers/HelloWorldController.php';
    (new HelloWorldController())->index();
?>
```
---


### Arborescence du projet
#### /app

```txt[]
app/
 │
 ├── controllers/
 │ 
 ├── entities/
 │
 ├── repositories/
 │
 ├── services/
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

```php[1-4|6-10|12-15|17-20|22-25]
require_once '../app/core/Controller.php';
require_once '../app/services/HelloService.php';

class HelloWorldController extends Controller
{
    private HelloService $helloService;
    public function __construct()
    {
        $this->helloService  = new HelloService();
    }
    
    public function index():void
    {
      $this->view('hello_world', $this->helloService->hello(), ['name' => 'Salim']);
    }

    public function indexJson():void
    {
      $this->json(['title' => $this->helloService->hello(), 'name' => 'Salim']);
    }

    public function redirectToJson()
    {
        $this->redirectTo('/json.php');
    }
}

```
---
### Arborescence du projet
#### /app/entities et /app/repositories
##### Entities
  - Classes représentant les tables de la base de données
#####  Repositories
  - Gestion des connexions à la base de données et exécution des requêtes SQL

---
### Arborescence du projet
#### /app/services

```php[]
<?php
class HelloService
{
    public function hello()
    {
        return 'Hello World!';
    }
}
```
---
### Arborescence du projet
#### /app/trait

- Traits utilisés par les services ou les contrôleurs
---
### Arborescence du projet
#### /app/views

```php
public function index():void
    {
      $this->view('hello_world', $this->helloService->hello(), ['name' => 'Salim','errors'=>['Nom incorrect']]);
    }
    
```

```php[]
<?php require '../app/views/_template/header.php'; ?>
<h1>Hello <?php echo $name; ?></h1>

<?php if (!empty($errors)): ?>
    <?php foreach($errors as $error): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $error; ?> //echo $error;
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require '../app/views/_template/footer.php'; ?>
```
---

### Arborescence du projet
#### /app/core/

```php[1|2|5-17|19-24|26-29]
abstract class Controller {
    protected $viewPath = '../app/views/'; // Chemin vers les vues


    protected function view(string $viewName, string $title = 'Titre de la page', array $data = [], $status = 200) {

        $filePath = $this->viewPath . $viewName . '.php';

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
### Arborescence complète du projet : 

| Rôle       | Dossier                                                    |
|------------|------------------------------------------------------------|
| Modéle     | - app/entities<br/> - app/repositories<br/> - app/services |
| Vue        | - app/views                                                |
| Controller | - app/controllers                                          |
| Routes     | - public                                                   |



