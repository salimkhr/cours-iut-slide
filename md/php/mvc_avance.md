# 🍝 Du Spaghetti Code à la Clean Architecture

---

## Plan de la présentation

1. Introduction aux Services MVC
2. Le problème : La God Class
3. Étape 1 : Séparation Vue/Contrôleur
4. Étape 2 : Repository Pattern
5. Étape 3 : Services métier
6. Étape 4 : Dependency Inversion
7. Clean Architecture
8. Principes SOLID
9. Avant/Après & Conclusion

---

## 🎯 Les Services dans l'architecture MVC

### Qu'est-ce qu'un Service ?

- **Couche supplémentaire** entre Contrôleurs et Repositories
- **Extrait la logique métier** des contrôleurs
- **Rend le code** plus clair, testable et maintenable

### Principe fondamental

> Les contrôleurs **orchestrent**, les services **exécutent**

---

## 📁 Architecture des dossiers

```
/app/
  ├── controllers/     ← Gère requêtes/réponses
  ├── services/        ← Logique métier
  ├── repositories/    ← Accès base de données
  ├── entities/        ← Objets métier
  ├── views/          ← Affichage
  ├── core/           ← Classes de base
  └── interfaces/     ← Contrats (abstractions)
```

---

## 💡 Exemple simple de Service

```php
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

# 🔴 Étape 0 : Le Code Problématique

## La "God Class" - Tous les problèmes réunis

---

## Le UserController cauchemardesque

```php{1-2|4-5|7-27|29-32|34-38|40-44|46-51|53-58|60-66|68-73|75-76}
<?php
class UserController {
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            // 🔴 PROBLÈME 1 : HTML dans le contrôleur
            echo '<!DOCTYPE html>
<html>
<head><title>Inscription</title></head>
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
            
            // 🔴 PROBLÈME 3 : Accès direct à la DB
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
            
            // 🔴 PROBLÈME 7 : Logging dans le contrôleur
            file_put_contents(
                __DIR__ . "/logs.txt",
                date('Y-m-d H:i:s') . " - Nouvel utilisateur: $email\n",
                FILE_APPEND
            );
            
            echo "<h2>Utilisateur créé avec succès !</h2>";
        }
    }
}
```

---

## 😱 Les 7 problèmes identifiés

1. **HTML écrit directement** dans le contrôleur → Violation MVC
2. **Validation** dans le contrôleur → Violation SRP
3. **Accès DB direct** → Couplage fort avec PDO
4. **Logique métier** dans le contrôleur → Pas réutilisable
5. **Requêtes SQL** partout → Duplication de code
6. **Envoi email** dans le contrôleur → Fonction native non mockable
7. **Logging** dans le contrôleur → Impossible à tester

### Conséquences

- ❌ **Impossible à tester** unitairement
- ❌ **Code non réutilisable** (API, CLI impossible)
- ❌ **Maintenance cauchemardesque**
- ❌ **Couplage maximal**

---

# ✅ Étape 1 : Séparer Vue et Contrôleur

## Respecter le principe MVC de base

---

## Le contrôleur délègue l'affichage

```php{1-3|5-10|12-14|16-26|28-34|36-42}
<?php
require_once '../app/core/Controller.php';

class UserController extends Controller
{
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // ✅ Délègue l'affichage à la vue
            $this->view('users/register', 'Inscription');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            
            // Validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('users/register', 'Inscription', 
                    ['error' => 'Email invalide']
                );
                return;
            }
            
            if (strlen($password) < 8) {
                $this->view('users/register', 'Inscription', 
                    ['error' => 'Mot de passe trop court']
                );
                return;
            }
            
            // ... reste du code (DB, email, etc.)
            
            $this->view('users/success', 'Succès', 
                ['message' => 'Utilisateur créé !']
            );
        }
    }
}
```

---

## La vue séparée

```php{1-5|7-15|17-25|27-28}
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Créer un compte</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/register.php">
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">S'inscrire</button>
        </form>
    </div>
</body>
</html>
```

---

## 🎉 Améliorations obtenues (Étape 1)

### Ce qu'on a gagné

✅ **Séparation des responsabilités**
- Contrôleur = coordonne
- Vue = affiche

✅ **Flexibilité du design**
- Modification CSS sans toucher au contrôleur

✅ **Réutilisation**
- Template utilisable pour d'autres formulaires

✅ **Gestion élégante des erreurs**
- Affichage conditionnel propre

---

# ✅ Étape 2 : Repository Pattern

## Séparer l'accès aux données (SRP)

---

## Le contrôleur utilise le Repository

```php{1-2|4-11|13-16|18-33|35-37|39-48|50-56}
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
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('users/register', 'Inscription');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            
            // Validation...
            
            // ✅ Utilise le repository
            if ($this->userRepo->existsByEmail($email)) {
                $this->view('users/register', 'Inscription', 
                    ['error' => "L'utilisateur existe déjà"]
                );
                return;
            }
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // ✅ Utilise le repository pour créer
            $userId = $this->userRepo->create([
                'email' => $email,
                'password' => $hashedPassword
            ]);
            
            // Envoi email, logging...
            
            $this->view('users/success', 'Succès', 
                ['message' => 'Utilisateur créé !']
            );
        }
    }
}
```

---

## Le UserRepository

```php{1-2|4-10|12-18|20-26|28-41|43-55}
<?php
class UserRepository
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * Vérifie si un utilisateur existe par email
     */
    public function existsByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM users WHERE email = :email"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Crée un nouvel utilisateur
     */
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (email, password, created_at) 
             VALUES (:email, :password, NOW())"
        );
        
        $stmt->execute([
            'email' => $data['email'],
            'password' => $data['password']
        ]);
        
        return (int) $this->pdo->lastInsertId();
    }
    
    /**
     * Récupère un utilisateur par son ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ?: null;
    }
}
```

---

## 🎉 Améliorations obtenues (Étape 2)

### Ce qu'on a gagné

✅ **Single Responsibility Principle**
- Repository = UNIQUEMENT l'accès aux données
- Contrôleur = coordination

✅ **Requêtes SQL centralisées**
- Pas de duplication
- Réutilisables partout

✅ **Testabilité**
- On peut mocker le repository facilement

✅ **Flexibilité**
- Changement de DB plus facile (MySQL → PostgreSQL)
- Ajout de cache transparent

---

# ✅ Étape 3 : Services Métier

## Extraire la logique métier (SRP)

---

## ValidationService

```php{1-2|4-11|13-38|40-49}
<?php
class ValidationService
{
    /**
     * Valide un email
     * @throws ValidationException
     */
    public function validateEmail(string $email): void
    {
        if (empty($email)) {
            throw new ValidationException("L'email est requis");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("L'email n'est pas valide");
        }
    }
    
    /**
     * Valide un mot de passe
     * @throws ValidationException
     */
    public function validatePassword(string $password): void
    {
        if (empty($password)) {
            throw new ValidationException("Le mot de passe est requis");
        }
        
        if (strlen($password) < 8) {
            throw new ValidationException(
                "Le mot de passe doit contenir au moins 8 caractères"
            );
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            throw new ValidationException(
                "Le mot de passe doit contenir au moins une majuscule"
            );
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            throw new ValidationException(
                "Le mot de passe doit contenir au moins un chiffre"
            );
        }
    }
}
```

---

## 🎉 Améliorations obtenues (Étape 3)

### Services spécialisés

✅ **ValidationService**
- Règles métier de validation centralisées
- Réutilisable dans API, CLI, Web

✅ **EmailService**
- Logique d'envoi d'emails isolée
- Changement de provider facilité

✅ **AuditService**
- Logging centralisé
- Format uniforme

### Bénéfices

- Code **DRY** (Don't Repeat Yourself)
- **Testabilité** unitaire maximale
- **Maintenance** simplifiée

---

# ✅ Étape 4 : Dependency Inversion

## SOLID Principe "D" - Dépendre d'abstractions

---

## Le principe

> **"Les modules de haut niveau ne doivent pas dépendre des modules de bas niveau. Les deux doivent dépendre d'abstractions."**

### Concrètement

- ❌ **Avant** : `UserService` dépend de `SmtpEmailService`
- ✅ **Après** : `UserService` dépend de `EmailSenderInterface`

### Avantages

- Flexibilité maximale
- Tests simplifiés (mocks/fakes)
- Changement d'implémentation sans modifier le code métier

---

## Interface pour l'envoi d'emails

```php{1-2|4-9|11-14}
<?php
interface EmailSenderInterface
{
    /**
     * Envoie un email de bienvenue
     */
    public function sendWelcomeEmail(string $toEmail): void;
    
    /**
     * Envoie un email générique
     */
    public function send(string $to, string $subject, string $message): void;
}
```

---

## Implémentation SMTP

```php{1-2|4-10|12-18|20-24}
<?php
class SmtpEmailService implements EmailSenderInterface
{
    public function sendWelcomeEmail(string $toEmail): void
    {
        $subject = "Bienvenue sur notre plateforme";
        $message = "Merci de votre inscription !";
        
        $this->send($toEmail, $subject, $message);
    }
    
    public function send(string $to, string $subject, string $message): void
    {
        // Configuration SMTP réelle
        // mail() ou PHPMailer ou Symfony Mailer
        mail($to, $subject, $message);
    }
}
```

---

## Implémentation Fake (pour les tests)

```php{1-2|4-10|12-17|19-24}
<?php
class FakeEmailService implements EmailSenderInterface
{
    private array $sentEmails = [];
    
    public function sendWelcomeEmail(string $toEmail): void
    {
        $this->sentEmails[] = [
            'to' => $toEmail,
            'type' => 'welcome'
        ];
    }
    
    public function send(string $to, string $subject, string $message): void
    {
        $this->sentEmails[] = compact('to', 'subject', 'message');
    }
    
    // Méthode utile pour les tests
    public function getSentEmails(): array
    {
        return $this->sentEmails;
    }
}
```

---

## UserService avec injection de dépendances

```php{1-2|4-17|19-30|32-43}
<?php
class UserService
{
    public function __construct(
        private UserRepository $userRepo,
        private ValidationService $validator,
        private EmailSenderInterface $emailService,  // ✅ Interface
        private AuditService $auditService
    ) {}
    
    public function register(string $email, string $password): void
    {
        // Validation
        $this->validator->validateEmail($email);
        $this->validator->validatePassword($password);
        
        // Vérification unicité
        if ($this->userRepo->existsByEmail($email)) {
            throw new DomainException("L'utilisateur existe déjà");
        }
        
        // Création
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userId = $this->userRepo->create([
            'email' => $email,
            'password' => $hashedPassword
        ]);
        
        // Email de bienvenue
        $this->emailService->sendWelcomeEmail($email);  // ✅ Abstraction
        
        // Audit
        $this->auditService->log("Nouvel utilisateur: $email");
    }
}
```

---

## 🎉 Avantages de la Dependency Inversion

### Flexibilité

```php
// En production
$emailService = new SmtpEmailService();

// En tests
$emailService = new FakeEmailService();

// Dans tous les cas
$userService = new UserService($repo, $validator, $emailService, $audit);
```

### Bénéfices

✅ **Tests simplifiés** - Injection de fakes/mocks
✅ **Couplage faible** - Changement d'implémentation sans impact
✅ **Extensibilité** - Ajout de nouvelles implémentations
✅ **Respect SOLID** - Principe "D" appliqué

---

# 🏛️ Clean Architecture

## La vision globale

---

## Les 4 couches de la Clean Architecture

```
┌─────────────────────────────────────────────┐
│         PRÉSENTATION (Controllers)          │
│         ↓ dépend de                         │
├─────────────────────────────────────────────┤
│       APPLICATION (Use Cases/Services)      │
│         ↓ dépend de                         │
├─────────────────────────────────────────────┤
│    DOMAINE (Entities, Business Logic)       │
│         ↑ définit des interfaces            │
├─────────────────────────────────────────────┤
│    INFRASTRUCTURE (DB, Email, External)     │
│         ↑ implémente les interfaces         │
└─────────────────────────────────────────────┘
```

### Règle d'or

> **Les dépendances pointent TOUJOURS vers l'intérieur (vers le domaine)**

---

## Couche DOMAINE (Cœur métier)

### Contenu

- **Entités** : `User`, `Article`...
- **Services métier** : `ValidationService`
- **Exceptions métier** : `ValidationException`, `DomainException`
- **Interfaces** : définit les contrats

### Caractéristiques

✅ **Aucune dépendance externe**
- Pas de base de données
- Pas de framework
- Pas d'API externe

✅ **Logique métier pure**

---

## Couche APPLICATION (Use Cases)

### Contenu

- **Services d'orchestration** : `UserService`
- **Interfaces (ports)** : `EmailSenderInterface`
- **DTOs** (Data Transfer Objects) si nécessaire

### Rôle

- Coordonne les cas d'usage
- Utilise le domaine
- Définit les interfaces pour l'infrastructure

---

## Couche INFRASTRUCTURE (Détails techniques)

### Contenu

- **Repositories** : `UserRepository`
- **Services externes** : `SmtpEmailService`
- **Configuration** : connexion DB, credentials
- **Logging** : `AuditService`

### Caractéristiques

- Implémente les interfaces du domaine
- Contient les détails techniques
- Peut être remplacée sans impact sur le métier

---

## Couche PRÉSENTATION (Interface utilisateur)

### Contenu

- **Controllers** : `UserController`
- **Vues** : templates HTML
- **Routes** : configuration des URLs
- **Validation formulaires** : validation côté UI

### Caractéristiques

- Dépend de la couche Application
- Gère l'interaction HTTP/CLI/API
- Transforme les données pour l'affichage

---

## Principe fondamental illustré

```php
// ❌ MAUVAIS : Couplage direct
class UserService {
    public function register() {
        $pdo = new PDO(...);  // ❌ Dépend de PDO
        $stmt = $pdo->prepare(...);
    }
}

// ✅ BON : Dépendance inversée
class UserService {
    public function __construct(
        private UserRepository $repo  // ✅ Dépend d'abstraction
    ) {}
}
```

### Avantages

- On peut changer la DB sans toucher au métier
- On peut tester le métier sans DB
- Le cœur reste indépendant

---

# 🎯 Principes SOLID - Récapitulatif

## Les 5 principes appliqués

---

## S - Single Responsibility Principle

### "Une classe = une seule responsabilité"

✅ **Application dans notre code**

```
UserController      → Gère HTTP uniquement
UserService         → Logique métier d'inscription
ValidationService   → Validation uniquement
UserRepository      → Accès données uniquement
EmailService        → Envoi emails uniquement
AuditService        → Logging uniquement
```

### Bénéfice

- Code **facile à comprendre**
- **Maintenance** simplifiée
- **Testabilité** maximale

---

## O - Open/Closed Principle

### "Ouvert à l'extension, fermé à la modification"

✅ **Application dans notre code**

```php
// On peut ajouter une nouvelle implémentation...
class MailgunEmailService implements EmailSenderInterface {
    // ...
}

// ...SANS modifier le code existant
$userService = new UserService($repo, $validator, $mailgun, $audit);
```

### Bénéfice

- Ajout de fonctionnalités **sans risque**
- Code existant **protégé**

---

## L - Liskov Substitution Principle

### "Les implémentations doivent être interchangeables"

✅ **Application dans notre code**

```php
// Ces deux lignes doivent fonctionner de manière cohérente
$service = new UserService($repo, $validator, new SmtpEmailService(), $audit);
$service = new UserService($repo, $validator, new FakeEmailService(), $audit);
```

### Bénéfice

- Aucune **surprise** lors du remplacement
- Tests et production utilisent le **même code**

---

## I - Interface Segregation Principle

### "Interfaces spécifiques et ciblées"

✅ **Application dans notre code**

```php
// ✅ BON : Interface ciblée
interface EmailSenderInterface {
    public function sendWelcomeEmail(string $email): void;
    public function send(string $to, string $subject, string $msg): void;
}

// ❌ MAUVAIS : Interface "fourre-tout"
interface MegaServiceInterface {
    public function sendEmail();
    public function saveToDb();
    public function validateInput();
    public function logAction();
    // 20 autres méthodes...
}
```

---

## D - Dependency Inversion Principle

### "Dépendre d'abstractions, pas d'implémentations"

✅ **Application dans notre code**

```php
// ✅ BON
class UserService {
    public function __construct(
        private EmailSenderInterface $emailService  // Interface
    ) {}
}

// ❌ MAUVAIS
class UserService {
    public function __construct(
        private SmtpEmailService $emailService  // Implémentation concrète
    ) {}
}
```

### Bénéfice

- **Couplage faible**
- **Flexibilité maximale**

---

# 📊 Avant vs Après

## La transformation complète

---

## ❌ AVANT : Le cauchemar

### Structure

- **1 fichier** de 120 lignes
- Tout mélangé dans le contrôleur

### Caractéristiques

❌ **0 tests possibles**
❌ **0 réutilisabilité** (impossible API/CLI)
❌ HTML dans le contrôleur
❌ SQL dans le contrôleur
❌ Logique métier dans le contrôleur
❌ Email dans le contrôleur
❌ Logs dans le contrôleur

### Risque

⚠️ **Modification = risque de tout casser**

---

## ✅ APRÈS : L'architecture propre

### Structure

- **10 fichiers** bien organisés
- Séparation claire des responsabilités

### Caractéristiques

✅ **Tests unitaires** possibles partout
✅ **Réutilisabilité** totale (API, CLI, Web)
✅ HTML dans les **vues**
✅ SQL dans le **repository**
✅ Logique métier dans **UserService**
✅ Email dans **EmailService**
✅ Logs dans **AuditService**

### Sécurité

🛡️ **Modification = impact limité et contrôlé**

---

## Organisation finale du projet

```
project_tp/
 │
 ├── public/                     ← Seul dossier accessible
 │   ├── register.php            ← Point d'entrée
 │   └── css/style.css
 │
 ├── app/
 │   ├── controllers/            ← Couche Présentation
 │   │   └── UserController.php
 │   │
 │   ├── services/               ← Couche Application + Domaine
 │   │   ├── UserService.php
 │   │   ├── ValidationService.php
 │   │   ├── SmtpEmailService.php
 │   │   ├── FakeEmailService.php
 │   │   └── AuditService.php
 │   │
 │   ├── repositories/           ← Couche Infrastructure
 │   │   └── UserRepository.php
 │   │
 │   ├── entities/               ← Couche Domaine
 │   │   └── User.php
 │   │
 │   ├── interfaces/             ← Contrats
 │   │   └── EmailSenderInterface.php
 │   │
 │   ├── exceptions/             ← Exceptions métier
 │   │   ├── ValidationException.php
 │   │   ├── DomainException.php
 │   │   └── NotFoundException.php
 │   │
 │   ├── views/                  ← Templates
 │   │   └── users/
 │   │       ├── register.php
 │   │       └── success.php
 │   │
 │   └── core/                   ← Classes de base
 │       └── Controller.php
 │
 ├── config/
 │   └── database.php            ← Configuration
 │
 ├── logs/
 │   └── audit.log               ← Fichiers de log
 │
 └── tests/                      ← Tests unitaires
     └── UserServiceTest.php
```

---

## 🎯 Avantages de cette structure

### Navigation

✅ **On sait immédiatement où chercher**
- Un bug de validation ? → `/services/ValidationService.php`
- Un problème de DB ? → `/repositories/`
- Erreur d'affichage ? → `/views/`

### Évolution

✅ **Facile d'ajouter de nouvelles fonctionnalités**
- Nouveau service ? → Créer dans `/services/`
- Nouvelle entité ? → Créer dans `/entities/` + `/repositories/`

### Collaboration

✅ **Plusieurs développeurs en parallèle**
- Dev 1 : Vue et CSS
- Dev 2 : Services métier
- Dev 3 : Repository et DB

---

## 📈 Métriques de qualité

### Complexité

| Métrique | Avant | Après |
|----------|-------|-------|
| Lignes par fichier | 120 | 20-40 |
| Responsabilités/classe | 7+ | 1 |
| Couplage | Fort | Faible |
| Testabilité | 0% | 100%
