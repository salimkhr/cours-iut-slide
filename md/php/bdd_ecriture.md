# Création et Modification de Données

Opérations CRUD avec PHP et PostgreSQL

---
## Repository
### Méthode `create()`

Insertion d'une nouvelle catégorie avec `RETURNING`

```php[1-3|4-8|11-12|14-15|17]
public function create(Category $category): ?Category
{
    // Requête préparée avec RETURNING pour récupérer l'ID
    $stmt = $this->pdo->prepare(<<<SQL
        INSERT INTO category (name)
        VALUES (:name)
        RETURNING id
    SQL);
    
    // Exécution avec le paramètre
    $stmt->execute(['name' => $category->getName()]);
    
    // Récupération de l'ID généré
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $category->setId($row['id'] ?? null);
    
    return $category;
}
```

---
## Repository
### Méthode `update()`

Modification d'une catégorie existante

```php[1-3|4-8|10-14]
public function update(Category $category): bool
{
    // Requête préparée pour la mise à jour
    $stmt = $this->pdo->prepare(<<<SQL
        UPDATE category
        SET name = :name
        WHERE id = :id
    SQL);
    
    // Exécution avec les paramètres
    return $stmt->execute([
        'id' => $category->getId(),
        'name' => $category->getName()
    ]);
}
```
---

## Contrôleur : Créer (1/3)

Affichage du formulaire vide

```php[1-2|4-7]
public function create(): void
{
    // Méthode GET : affichage du formulaire
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->view('categories_form', 'Créer une catégorie');
        return;
    }
    
    // Suite du code...
}
```

---

## Contrôleur : Créer (2/3)

Récupération et validation des données

```php[1-3|5-6|8-15|17-23]
// Récupération et sécurisation du nom
$name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
$name = trim($name);

// Création de l'objet
$category = new Category(0, $name); // ID à 0

// Validation côté serveur
if (empty($name)) {
    $this->view('categories_form', 'Créer une catégorie', [
        'error' => 'Le nom est obligatoire',
        'category' => $category
    ]);
    return;
}

if (strlen($name) < 2 || strlen($name) > 100) {
    $this->view('categories_form', 'Créer une catégorie', [
        'error' => 'Le nom doit contenir entre 2 et 100 caractères',
        'category' => $category
    ]);
    return;
}
```

---

## Contrôleur : Créer (3/3)

Insertion et redirection

```php[1-2|4-11]
// Insertion en base de données
$category = $this->categoryRepository->create($category);

// Vérification et redirection
if ($category) {
    $this->redirectTo("category.php?action=show&id={$category->getId()}");
} else {
    $this->view('categories_form', 'Créer une catégorie', [
        'error' => 'Erreur lors de la création',
        'category' => $category
    ]);
}
```

---

## Contrôleur : Modifier (1/3)

Vérification de l'ID et récupération

```php[1-2|4-10|12-17]
public function update(): void
{
    // Récupération de l'ID depuis l'URL
    $id = (int) ($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        $this->redirectTo('category.php');
        return;
    }
    
    // Récupération de la catégorie existante
    $category = $this->categoryRepository->findById($id);
    
    if (!$category) {
        $this->view('errors/404', 'Catégorie non trouvée', [], 404);
        return;
    }
    
    // Suite du code...
}
```

---

## Contrôleur : Modifier (2/3)

Affichage ou traitement du formulaire

```php[1-7|9-12]
// Méthode GET : affichage du formulaire pré-rempli
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $this->view('categories_form', 'Modifier la catégorie', [
        'category' => $category
    ]);
    return;
}

// Méthode POST : traitement du formulaire
$name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
$name = trim($name);
```

---

## Contrôleur : Modifier (3/3)

Validation, mise à jour et redirection

```php[1-8|10-12|14-22]
// Validation (même logique que create)
if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
    $this->view('categories_form', 'Modifier la catégorie', [
        'category' => $category,
        'error' => 'Erreur de validation'
    ]);
    return;
}

// Mise à jour de l'objet
$category->setName($name);
$success = $this->categoryRepository->update($category);

// Vérification et redirection
if ($success) {
    $this->redirectTo("category.php?action=show&id={$id}");
} else {
    $this->view('categories_form', 'Modifier la catégorie', [
        'category' => $category,
        'error' => 'Erreur lors de la modification'
    ]);
}
```

---

## Flux : Création

```
┌─────────────┐
│ GET create  │ → Affichage formulaire vide
└─────────────┘

┌─────────────┐
│ POST create │ → Validation → Repository::create()
└─────────────┘                 ↓
                         ┌──────────────┐
                         │ RETURNING id │
                         └──────────────┘
                                ↓
                         Redirection vers show
```

---

## Flux : Modification

```
┌─────────────┐
│ GET update  │ → findById() → Formulaire pré-rempli
└─────────────┘

┌─────────────┐
│ POST update │ → Validation → Repository::update()
└─────────────┘                 ↓
                         ┌──────────────┐
                         │ UPDATE WHERE │
                         └──────────────┘
                                ↓
                         Redirection vers show
```
---
# Questions ?

---