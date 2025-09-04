<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS</title>
</head>
<body>
<?php

echo '<form action="formEtAffiche.php" method="get">
        <label for="nom">Saisir un commentaire</label> 
        <textarea name="commentaire" rows="5" cols="40"></textarea>
        
        <input type="text" required name="nom">
        <input type="submit" value="Envoyer">
    </form>';
if (isset($_REQUEST['commentaire'])) {
    $commentaire = $_REQUEST['commentaire'];
    echo "<h2>Dernier commentaire :</h2>";
    echo "<div id=\"commentsSection\">$commentaire</div>";
}
?>

</body>
</html>
<!--
<script>
document.title = "⚠️ Site piraté ⚠️";
    // Sélectionner le premier <textarea> de la page
    const textarea = document.getElementsByTagName('textarea')[0];

    textarea.style.position = 'absolute';

    // Faire clignoter le H2
function clignoter() {
    const h2 = document.querySelector("h2");
    setInterval(function() {
        h2.style.visibility = (h2.style.visibility == 'hidden' ? '' : 'hidden');
    }, 500); // Clignotement toutes les 500 ms
}
clignoter();

    // Position initiale
    let posX = 100;
    let posY = 100;

    // Vitesse de déplacement
    let vitesseX = 2;
    let vitesseY = 2;

    // Fonction qui fait rebondir le textarea
    function rebondDVD() {
        const largeurFenetre = window.innerWidth;
        const hauteurFenetre = window.innerHeight;

        // Dimensions du textarea (mise à jour à chaque rebond)
        const largeurTextarea = textarea.offsetWidth;
        const hauteurTextarea = textarea.offsetHeight;

        // Mise à jour des positions
        posX += vitesseX;
        posY += vitesseY;

        // Rebond sur les bords gauche/droite
        if (posX + largeurTextarea > largeurFenetre || posX < 0) {
            vitesseX *= -1; // Inversion de la direction horizontale
            changerCouleur();
        }

        // Rebond sur les bords haut/bas
        if (posY + hauteurTextarea > hauteurFenetre || posY < 0) {
            vitesseY *= -1; // Inversion de la direction verticale
            changerCouleur();
        }

        // Appliquer les nouvelles positions
        textarea.style.left = posX + 'px';
        textarea.style.top = posY + 'px';
    }

    // Fonction pour changer la couleur du textarea à chaque rebond
    function changerCouleur() {
        const couleurs = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
        const couleurAleatoire = couleurs[Math.floor(Math.random() * couleurs.length)];
        textarea.style.backgroundColor = couleurAleatoire;
    }

    // Déclencher le déplacement toutes les 10ms
    setInterval(rebondDVD, 10);
</script>
-->
