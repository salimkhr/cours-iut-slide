# Fetch
## Utilisation des API
## 📦 Le Node Package Manager
## 🌐 Les APIs 
### (Application Programming Interfaces)
### 📄 Formats courants des réponses

{
  "nom": "Alice",
  "age": 25,
  "ville": {
    "nom": "Le Havre",
    "codePostal" : "76600"
  }
}
```
---
### 📄 Formats courants des réponses
- **XML (eXtensible Markup Language)**
    - Plus verbeux, utilisé dans certains services
```xml
<personne>
    <nom>Alice</nom>
    <age>25</age>
    <ville>
        <nom>Le Havre</nom>
        <codePostal>76600</codePostal>
    </ville>
</personne>
```

---

### 📨 Structure d'une requête API
- **Headers** : Métadonnées 
  - Type de contenu
  - Authentification
  - ...
  
- **Body** : Données envoyées (Ex: JSON, FormData...)

- **Status Codes** :
    - ✅ `200 OK` :
    - 🚫 `401 Unauthorized` :
    - ❌ `500 Internal Server Error` :

---

## 🔐 Authentification par Token

---

## 🔐 Authentification par Token

---

## 🔑 JWT Json Web Token

- **Client** : Envoie des requêtes et stocke le JWT
- **Serveur d’authentification** : Génère et signe le token
- **Serveur d’API** : Vérifie le token avant d’accorder l’accès

---

## 🔑 JWT Json Web Token

```txt
1. [Client] -> (Email/Mot de passe) -> [Serveur d'Auth]

2. [Serveur d'Auth] -> (JWT signé) -> [Client]

3. [Client] -> (Requête API avec JWT) -> [Serveur API]

4. [Serveur API] -> (Vérifie JWT) -> [Accès autorisé/refusé]
```
✅ Avantages : Rapide, sans état

⚠️ Attention : Ne pas stocker sans protection
---

## 🔑 OAuth 2.0

- **Client** : Application demandant l’accès
- **Resource Owner** : L’utilisateur
- **Authorization Server** : Vérifie l’utilisateur et génère un token
- **Resource Server** : API qui protège les données

---
## 🔑 OAuth 2.0

```txt
1. [Client] -> (Demande d'autorisation) -> [Authorization Server]

2. [Authorization Server] -> (Redirection) -> [Utilisateur]

3. [Utilisateur] -> (Connexion et consentement) -> [Authorization Server]

4. [Authorization Server] -> (Code d'autorisation) -> [Client]

5. [Client] -> (Échange du code) -> [Authorization Server]

6. [Authorization Server] -> (Token d'accès) -> [Client]

7. [Client] -> (Requête API avec token) -> [Resource Server]

8. [Resource Server] -> (Vérification) -> [Accès autorisé/refusé]
```
✅ Avantages : Sécurisé, standardisé

⚠️ Attention : Plus complexe à implémenter
---

## 🔑 API Keys

### Rôles
- **Client** : Application qui envoie des requêtes
- **Serveur API** : Vérifie et autorise les requêtes basées sur la clé

---

## 🔑 Processus et Rôles - API Keys

```txt
1. [Client] -> (Requête API avec clé) -> [Serveur API]
2. [Serveur API] -> (Vérification de la clé) -> [Accès autorisé/refusé]
```
✅ **Simple et rapide** / ⚠️ **doit être sécurisée**

---

## Les Promises

---
### then, catch, finally
#### Chaînage de Promises
#### Gestion des erreurs

### async/await et gestion des erreurs

#### Simplification du code avec async/await
#### Try/Catch pour une gestion propre des erreurs

---
## Fetch
### Introduction à l’API Fetch
### Requêtes GET et POST avec fetch
### Gestion des erreurs et timeout

---
## Express / TS

### TS
### Express

---

## MongoDB
### Le Not Only SQL
### Ajoute des points ici notamment
---