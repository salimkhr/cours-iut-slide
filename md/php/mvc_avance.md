# 🍝 Du Spaghetti Code à la Clean Architecture

---

# Étape 0 : Le code problématique

Classe « Dieu » qui fait tout : HTML, DB, mail, logs…

```{php}[]
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

# Étape 1 : Séparer la Vue du Contrôleur

---

## Nouveau Contrôleur

```{php}[1-3|5|8-10|20-30]
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

```{php}[1-3|6|15-20]
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

# Étape 2 : Créer un Repository

---

## Contrôleur simplifié

```{php}[1-3|7|15-20|28-33]
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

```{php}[1-3|5|10-15|20-30]
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

# Étape 3 : Extraire la logique métier dans des Services

---

## ValidationService

```{php}[1-3|5-8|20-28]
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

# Étape 4 : Interfaces et Inversion de Dépendances

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

## Vision globale

**Les dépendances pointent vers le domaine :**

- Domaine : `User`, `ValidationService`
- Application : `UserService`
- Infrastructure : `UserRepository`, `SmtpEmailService`
- Interface : `UserController`, `Vues`

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

# 🎓 Merci !
### Questions ? 