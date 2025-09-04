
# Programmation Orientée Objet (POO)
---

## Définition d’une classe
```php
class Person {
    private string $name;
    private int $age;

    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function __toString(): string {
        return 'Name: ' . $this->name . ', Age: ' . $this->age;
    }
}
```

---

## Définition d’une classe
```php
class Person {

    public function __construct(
    private string $name, 
    private int $age
    ) {}

    public function __toString(): string {
        return 'Name: ' . $this->name . ', Age: ' . $this->age;
    }
}
```

---
## Héritage
```php
class Employee extends Person {

    public function __construct(
    string $name, int $age, 
    private string $position) {
        parent::__construct($name, $age);
        $this->position = $position;
    }

    public function __toString(): string {
        return parent::__toString() . 
        ', Position: ' . $this->position;
    }
}
```

---

## les traits
```php
trait Logger {
public function log(string $message): void {
echo "[LOG] " . $message;
}
}

class Employee extends Person {
use Logger;

    public function work(): void {
        $this->log($this->name . " is working.");
    }
}
```
