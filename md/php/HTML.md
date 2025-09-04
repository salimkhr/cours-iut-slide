# Comment fonctionne PHP

---
# HTTP (HyperText Transfer Protocol)

![HTTP PROTOCOL](img/HTTP.png)

---
# 1. URL

- **Protocole :** http://, https://, ftp://, etc.
- **Nom de domaine :** www.example.com
- **Chemin :** /S2/index.html
- **Fragment :** #ancre
- **Paramètres :** ?param1=val1&param2=val2

---
# 2. HTTP

- **GET :** Récupère des données.
- **POST :** Envoie des données.
- **PUT :** Met à jour ou remplace une ressource.
- **DELETE :** Supprime une ressource.

---
# 3. Codes de statut HTTP

- **200 OK :** Succès de la requête.
- **404 Not Found :** Ressource non trouvée.
- **500 Internal Server Error :** Erreur interne du serveur.
- **302 Found (Redirection) :** Ressource déplacée temporairement.

---
# 4. HTML

 ```HTML [1-10|3-6|7-9]
<!DOCTYPE html>
    <html lang="fr" >
    <head>
        <meta charset="utf-8">
        <title>Mon titre</title>
    </head>
    <body>
        Hello world
    </body>
</html>
```
---
# 4. HTML

 ```HTML[8|9-12|14-18|20-23|24-27]
!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Le nom de ma page</title>
    </head>
    <body>
        <h1>Mon titre principal</h1>
        <p>
            Mon texte dans un paragraphe avec un mot <em>en
            italique</em> puis <strong>en gras</strong>
        </p>
        <h6>un tout petit titre</h6>
        <p>
            Un autre paragraphe avec un<br>un saut de ligne, puis
            un trait horizontal:
            <hr/>
        </p>
        
        <ul>
            <li>item 1</li>
            <li>item 2</li>
        </ul>
        <ol>
            <li>item 1</li>
            <li>item 2</li>
        </ol>
    </body>
</html>
```
---
# 4. HTML

 ```HTML [8-26|9-13|15-19]
!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Le nom de ma page</title>
    </head>
    <body>
        <table>
            <tr>
                <th>titre1</th>
                <th>titre2</th>
                <th>titre3</th>
            </tr>
    
            <tr>
                <td>donnée1</td>
                <td>donnée2</td>
                <td>donnée3</td>
            </tr>
    
            <tr>
                <td>donnée4</td>
                <td>donnée5</td>
                <td>donnée6</td>
            </tr>
        </table>
    </body>
</html>
```
---
# 4. HTML

- `<header>` : L'en-tête de la page.
- `<nav>` : La navigation du site.
- `<article>` : Un contenu indépendant.
- `<section>` : Une section thématique.
- `<aside>` : Contenu connexe.
- `<footer>` : Le pied de page.
---
# 4. HTML 5

```HTML[8-11|13-20|22-32|23-26|34-37|39-41]
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exemple de structure HTML5</title>
</head>
<body>
    <header>
        <h1>Mon Site Web</h1>
        <p>Le meilleur site web du monde</p>
    </header>

    <nav>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <section>
        <article>
            <h2>Article 1</h2>
            <p>Ceci est le premier article de mon site web.</p>
        </article>

        <article>
            <h2>Article 2</h2>
            <p>Voici le deuxième article de mon site web.</p>
        </article>
    </section>

    <aside>
        <h3>À propos de l'auteur</h3>
        <p>John Doe est un écrivain talentueux avec une passion pour la technologie.</p>
    </aside>

    <footer>
        <p>&copy; 2023 Mon Site Web - Tous droits réservés.</p>
    </footer>
</body>
</html>
```
