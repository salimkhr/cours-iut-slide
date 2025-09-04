## Les sessions
---
page1.php
```php
<?php
    session_start();
    $_SESSION['username'] = 'Jean';
?>
```
page2.php
```php
<?php
    session_start();
    echo $_SESSION['username']; // Affiche "Jean"
?>
```
---
page1.php
```php
// Sérialiser et stocker un objet utilisateur en session
session_start();
$user = new User("Jean", "Doe"); // Supposons que la classe User soit définie
$_SESSION['user'] = serialize($user);
?>
```
page2.php
```php
<?php
    session_start();
    $user = unserialize($_SESSION['user']);
    echo $user->getFirstName(); // Affiche "Jean"
?>
```
---

```php[7-10|14-20|23-27]
<?php 

class User {

 // Ne pas stocker pour des raisons de sécurité

    public function __construct(
    private string $username;
    private string $email;
    private string $password;
    ) {}

    // Contrôle des données à sérialiser
    public function __serialize(): array {

        return [
            'username' => $this->username,
            'email' => $this->email
        ]; // Exclut le mot de passe
    }

    // Restaure les données de l'objet lors de la désérialisation
    public function __unserialize(array $data): void {
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = ''; // Par sécurité, on ne restaure pas le mot de passe
    }
}
```
