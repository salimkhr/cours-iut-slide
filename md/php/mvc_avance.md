# 🍝 Du Spaghetti Code à la Clean Architecture

---

# Étape 0 : Le code problématique

Classe « Dieu » qui fait tout : HTML, DB, mail, logs…

```{php}[4-23|27-38|40-48|50-52|53-51|63-66|68-75]
<?php
class UserController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // 🔴 PROBLÈME 1 : HTML dans le contrôleur
            echo '<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <form method="POST" action="/register.php">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">S\'inscrire</button>
    </form>
</body>
</html>';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            
            // 🔴 PROBLÈME 2 : Validation dans le contrôleur
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Email invalide");
            }
            
            if (strlen($password) < 8) {
                die("Mot de passe trop court");
            }
            
            // 🔴 PROBLÈME 3 : Accès direct à la DB dans le contrôleur
            $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $exists = $stmt->fetchColumn() > 0;
            
            if ($exists) {
                die("L'utilisateur existe déjà");
            }
            
            // 🔴 PROBLÈME 4 : Logique métier dans le contrôleur
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // 🔴 PROBLÈME 5 : Encore de l'accès DB
            $stmt = $pdo->prepare(
                "INSERT INTO users (email, password, created_at) 
                 VALUES (:email, :password, NOW())"
            );
            $stmt->execute([
                'email' => $email,
                'password' => $hashedPassword
            ]);
            
            // 🔴 PROBLÈME 6 : Envoi d'email dans le contrôleur
            $subject = "Bienvenue sur notre plateforme";
            $message = "Bonjour, merci de vous être inscrit avec $email";
            mail($email, $subject, $message);
            
            // 🔴 PROBLÈME 7 : Logging dans un fichier dans le contrôleur
            file_put_contents(
                __DIR__ . "/logs.txt",
                date('Y-m-d H:i:s') . " - Nouvel utilisateur: $email\n",
                FILE_APPEND
            );
            
            echo "<Heading level={2}>Utilisateur créé avec succès !</Heading>";
        }
    }
}

$controller = new UserController();
$controller->register();
```

---

## Problèmes identifiés

🚨 **Violation du MVC**
- HTML dans le contrôleur  
  🚨 **Violation du SRP**
- Validation, DB, email, logging tout au même endroit  
  🚨 **Test impossible**  
  🚨 **Couplage fort**
- `PDO`, `mail()`, `file_put_contents()` hardcodés

---

# Étape 1 
## Séparer la Vue du Contrôleur

---

## Nouveau Contrôleur

```{php}[1-23|15-17]
<?php
class UserController extends Controller
{
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('users/register', 'Inscription');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('users/register', 'Inscription', ['error' => 'Email invalide']);
                return;
            }

            ...
        }
    }
}
```

---

## Vue séparée

```{php}[1-21]
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <h1>Créer un compte</h1>

    <?php if (isset($error)): ?>
        <div class="alert"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="/register.php">
        <label>Email :</label>
        <input type="email" name="email" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
```

---

# Étape 2 
## Créer un Repository

---

## Contrôleur simplifié

```{php}[1-33|6-9|11-21]
<?php
class UserController extends Controller
{
    private UserRepository $userRepo;
    
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(): void
    {
        ...
        if ($this->userRepo->existsByEmail($email)) {
            $this->view('users/register', 'Inscription', ['error' => "Déjà inscrit"]);
            return;
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepo->create(['email' => $email, 'password' => $hashed]);
    }
}
```

---

## Repository

```{php}[1-25|11-16|18-24]
<?php
class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function existsByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password, created_at)
                                     VALUES (:email, :password, NOW())");
        $stmt->execute($data);
        return (int)$this->pdo->lastInsertId();
    }
}
```

---

# Étape 3
### Extraire la logique métier dans des Services

---

## ValidationService

```{php}[1-18|4-9|11-17]
<?php
class ValidationService
{
    public function validateEmail(string $email): void
    {
        if (empty($email)) throw new ValidationException("Email requis");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new ValidationException("Email invalide");
    }

    public function validatePassword(string $password): void
    {
        if (strlen($password) < 8)
            throw new ValidationException("Mot de passe trop court");
        if (!preg_match('/[A-Z]/', $password))
            throw new ValidationException("Une majuscule requise");
    }
}
```

---

# Étape 4
## Interfaces et Inversion de Dépendances

---

## EmailSenderInterface

```{php}[]
<?php
interface EmailSenderInterface
{
    public function sendWelcomeEmail(string $toEmail): void;

    public function send(string $to, string $subject, string $message): void;
}
```

---

# Étape 5 : Clean Architecture

---

## 🎯 Principe Central

**La règle de dépendance** : Les dépendances pointent **uniquement vers l'intérieur**

```
┌─────────────────────────────────┐
│   Interface (UI)                │  ← Externe
├─────────────────────────────────┤
│   Infrastructure (DB, Email)    │
├─────────────────────────────────┤
│   Application (Services)        │
├─────────────────────────────────┤
│   Domaine (Métier)              │  ← Cœur
└─────────────────────────────────┘
```

---

## 1️⃣ Couche Domaine

**Le cœur métier**

- Logique métier pure
- Entités et règles business
- ❌ Aucune dépendance technique
- Exemple : règles de validation, calculs métier

---

## 2️⃣ Couche Application

**L'orchestrateur**

- Cas d'usage de l'application
- Coordonne le domaine et l'infrastructure
- Utilise des interfaces (pas d'implémentations)
- Exemple : "Inscrire un utilisateur", "Passer une commande"

---

## 3️⃣ Couche Infrastructure

**Les détails techniques**

- Implémente les interfaces de l'Application
- Accès DB, emails, APIs externes
- Remplaçable sans toucher au métier
- Exemple : Repository, EmailService, FileStorage

---

## 4️⃣ Couche Interface

**Le point d'entrée**

- Controllers, Views, CLI, API
- Transforme les requêtes en appels métier
- Formate les réponses
- Exemple : UserController, API REST

---

## 🔄 Flux d'une Requête

**Inscription utilisateur :**

1. **Interface** : Reçoit POST /register
2. **Application** : Vérifie l'email, crée l'utilisateur
3. **Domaine** : Valide les règles métier
4. **Infrastructure** : Sauvegarde en DB, envoie email
5. **Interface** : Retourne la confirmation

---

## 💡 Avantages

✅ Indépendance du framework  
✅ Testabilité maximale  
✅ Changement de DB sans impact  
✅ Évolution facilitée  
✅ Code maintenable

---

## 🎯 Quand l'Utiliser ?

**✅ OUI** : Projets complexes, long terme, forte logique métier  
**❌ NON** : Prototypes, petits scripts, deadline serrée

---

# Étape 6 : SOLID

---

## 🧱 Les 5 Principes

```
S - Single Responsibility
O - Open/Closed
L - Liskov Substitution
I - Interface Segregation
D - Dependency Inversion
```

**Objectif** : Code flexible, maintenable, compréhensible

---

## S - Single Responsibility

### 📖 Principe

**Une classe = une seule raison de changer**

---

### 🔴 Violation

Une classe `User` qui :
- Gère les données
- Valide les entrées
- Sauvegarde en DB
- Envoie des emails

**4 responsabilités = 4 raisons de changer**

---

### ✅ Solution

Séparer en classes distinctes :
- `User` : entité métier
- `UserValidator` : validation
- `UserRepository` : persistence
- `EmailService` : notifications

**1 classe = 1 responsabilité**

---

## O - Open/Closed

### 📖 Principe

**Ouvert à l'extension, fermé à la modification**

Ajouter des fonctionnalités sans modifier le code existant

---

### 🔴 Violation

Pour ajouter un nouveau type de notification (Slack, Discord...), on modifie la classe `NotificationService`

**Risque** : casser le code existant

---

### ✅ Solution

Utiliser des interfaces :
- `NotificationInterface` (contrat)
- `EmailNotification` (implémentation)
- `SmsNotification` (implémentation)
- `SlackNotification` (nouvelle classe, pas de modification)

**Extension sans modification**

---

## L - Liskov Substitution

### 📖 Principe

**Les classes dérivées doivent pouvoir remplacer les classes de base**

Respecter le contrat de la classe parente

---

### 🔴 Violation

Un `Carré` hérite de `Rectangle`
- `setWidth()` et `setHeight()` modifient les deux dimensions
- Comportement différent du `Rectangle`
- Casse les tests qui attendent un `Rectangle`

**Le contrat est violé**

---

### ✅ Solution

Ne pas hériter si le comportement diffère
- Interface commune `Shape`
- `Rectangle` implémente `Shape`
- `Square` implémente `Shape`

**Chacun respecte son contrat**

---

## I - Interface Segregation

### 📖 Principe

**Plusieurs petites interfaces spécifiques plutôt qu'une grosse générique**

Ne pas forcer à implémenter des méthodes inutilisées

---

### 🔴 Violation

Interface `Worker` avec :
- `work()`
- `eat()`
- `sleep()`

Un `Robot` doit implémenter `eat()` et `sleep()` inutilement

---

### ✅ Solution

Interfaces spécifiques :
- `Workable` : `work()`
- `Eatable` : `eat()`
- `Sleepable` : `sleep()`

Chaque classe implémente ce dont elle a besoin

---

## D - Dependency Inversion

### 📖 Principe

**Dépendre d'abstractions, pas d'implémentations concrètes**

Les modules de haut niveau ne dépendent pas des modules de bas niveau

---

### 🔴 Violation

`UserService` crée directement une instance de `MySQLDatabase`

**Couplage fort** : impossible de changer de DB

---

### ✅ Solution

- `UserService` dépend de `DatabaseInterface`
- `MySQLDatabase` implémente `DatabaseInterface`
- Injection de dépendance

**Remplaçable** : MySQL → PostgreSQL → MongoDB

---

## 📊 Récapitulatif SOLID

| Principe | En bref |
|----------|---------|
| **S**RP | 1 classe = 1 responsabilité |
| **O**CP | Extension sans modification |
| **L**SP | Respecter les contrats |
| **I**SP | Interfaces spécifiques |
| **D**IP | Dépendre d'abstractions |

---

## 🎯 Bénéfices de SOLID

✅ Code testable  
✅ Code maintenable  
✅ Code extensible  
✅ Couplage faible  
✅ Haute cohésion

---

## 🏆 Clean Architecture + SOLID

**= Code professionnel de qualité**

Indépendant • Testable • Évolutif • Maintenable

---

# Étape finale : Ajout des Services dans notre MVC

---

## Exemple simple de Service

~~~php
<?php
class HelloService
{
    public function hello()
    {
        return 'Hello World!';
    }
}
~~~

---

# Organisation finale du projet

~~~plaintext
project_tp/
 ├── public/
 │   └── register.php
 ├── app/
 │   ├── controllers/
 │   │   └── UserController.php
 │   ├── services/
 │   │   ├── UserService.php
 │   │   ├── ValidationService.php
 │   │   └── SmtpEmailService.php
 │   ├── repositories/
 │   │   └── UserRepository.php
 │   ├── interfaces/
 │   │   └── EmailSenderInterface.php
 │   ├── entities/
 │   │   └── User.php
 │   └── views/
 │       └── users/
 │           ├── register.php
 │           └── success.php
 └── tests/
     └── UserServiceTest.php
~~~

---

# ✅ Résumé final

✅ Code modulaire  
✅ Testable  
✅ Couplage faible  
✅ Maintenable  
✅ Conforme aux principes **SOLID**  
✅ Structure MVC + Services + Clean Architecture

---

---

# 🎓 Merci !
### Questions ?