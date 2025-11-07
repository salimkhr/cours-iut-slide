# Connexion a la base de données
---

## Rappel du MVC

Le pattern **MVC** sépare l'application en trois composants :

- **Modèle** : données et logique métier
- **Vue** : affichage uniquement
- **Contrôleur** : orchestration et lien M-V

---

## Le Modèle

Couche métier composée de :

- **Entités** : représentent les données
- **Repositories** : gèrent la persistance

---

## Les Entités

Objets métier avec propriétés et méthodes

```php[1-12|3-6|8-11|13-21]
class Category
{
    public function __construct(
        private int $id, 
        private string $name
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
```
---
## Le constructeur du Repository
Le Pattern Singleton
```php[5|3|6-7|10-12|23-33|15-20|35-38]
<?php

require_once '../config/config.php';

class Repository {
    private static $instance = null;  // Instance unique de la classe
    protected $pdo;

    // Le constructeur est maintenant privé pour empêcher une instanciation directe
    private function __construct() {
        $this->pdo = $this->getDatabaseConnection();
    }

    // Méthode pour obtenir l'instance unique de la classe (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Repository();
        }
        return self::$instance;
    }

    // Fonction pour se connecter à la base de données
    protected function getDatabaseConnection() {
        $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Mode d'erreur
            return $pdo;
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    // Méthode pour obtenir la connexion PDO
    public function getPDO() {
        return $this->pdo;
    }

    // Empêche le clonage de l'objet
    private function __clone() {}

}
```
---

## Les Repositories
Gèrent la connexion et les opérations CRUD

```php[1-10|11-19|21-27]
<?php
class CategoryRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Repository::getInstance()->getPDO();
    }
    
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM category");
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $this->createCategoryFromRow($row);
        }
        return $categories;
    }
    
    private function createCategoryFromRow(array $row): Category
    {
        return new Category(
            (int) $row['id'],
            $row['name']
        );
    }
```
---

## Requêtes Préparées

Protection contre les injections SQL

- Séparation requête / valeurs
- Compilation unique
- Sécurité renforcée

---


## Requêtes Préparées
Les injections SQL
```php[]
    $login = 'admin'; //saisi utilisateur
    $password = "' OR 1=1"; //saisi utilisateur

    $sql = "SELECT id, nom, email 
    FROM utilisateurs 
    WHERE login = '" . $login . "' 
      AND password = '" . $password . "'";
```
---
## Pourquoi utiliser des requêtes preparé ?
```sql
    SELECT id, nom, email
    FROM utilisateurs
    WHERE login = 'admin'
      AND password = '' OR 1=1;
```
---

## Binding avec un entier

```php
$stmt = $this->pdo->prepare(
    "SELECT * FROM category WHERE id = :id"
);
$stmt->execute(['id' => $id]);
```

Le paramètre `:id` est lié à la valeur
---

## Binding multiple

```php[1-6|8-12]
$stmt = $this->pdo->prepare(
    "SELECT * FROM category 
     WHERE name ILIKE :name 
        AND is_active = :is_active 
        AND created_at >= :created_after"
);

$stmt->execute([
    'name' => '%' . $searchName . '%',
    'is_active' => $isActive,
    'created_after' => $createdAfter
]);
```

---

## findById()

Récupère une catégorie par ID

```php[1-13|3-7|9-12]
public function findById(int $id): ?Category
{
    $stmt = $this->pdo->prepare(
        "SELECT * FROM category WHERE id = :id"
    );
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        return $this->createCategoryFromRow($row);
    }
    return null;
}
```

---

## findByName()

Récupère les catégories par nom

```php[1-15|3-7|9-12 | 14]
public function findByName(string $name): array
{
    $stmt = $this->pdo->prepare(
        "SELECT * FROM category WHERE name = :name"
    );
    $stmt->execute(['name' => $name]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $categories = [];
    foreach ($rows as $row) {
        $categories[] = $this->createCategoryFromRow($row);
    }

    return $categories;
}
```

---

## Le Contrôleur

Utilise les Repositories pour accéder aux données

**Principe** : Jamais de SQL dans le contrôleur

---

## CategoryController

```php[1-8|9-18|20-34]
class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }
    public function index(): void
    {
        // Récupération via le repository
        $categories = $this->categoryRepository->findAll();
        
        // Transmission à la vue
        $this->view('categories_list', 'Liste des catégories', [
            'categories' => $categories
        ]);
    }
    
    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        
        $category = $this->categoryRepository->findById($id);
        
        if (!$category) {
            $this->view('errors/404', 'Non trouvée', [], 404);
            return;
        }
        
        $this->view('categories_show', $category->getName(), [
            'category' => $category
        ]);
    }
}
```

---

## La Vue

Affiche les données reçues du contrôleur

```php[3|12-17|20-22]
<h1>Liste des catégories</h1>

<?php if (!empty($categories)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category->getId() ?></td>
                    <td><?= $category->getName() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune catégorie disponible.</p>
<?php endif; ?>
```

