# Les promises
---
```JS
const maPromise = new Promise((resolve, reject) => {
                // Effectuer une opération asynchrone, par exemple une requête HTTP
                setTimeout(() => {
                    const reussite = math.randomInt(2); //0 ou 1
                    if (reussite) {
                        resolve('Résultat de la promesse');
                    } else {
                        reject('Erreur de la promesse');
                    }
                }, 2000); // Simule une opération asynchrone de 2 secondes
            });

            maPromise.then(resultat => {
                console.log(resultat); // Résultat de la promesse
            }).catch(erreur => {
                console.error(erreur); // Erreur de la promesse
            });
        
```
---
```JS
function asyncOperation() {
    return new Promise((resolve, reject) => {
        // Effectuer une opération asynchrone
        setTimeout(() => {
            resolve('Résultat de l\'opération asynchrone');
        }, 2000); // Simule une opération asynchrone de 2 secondes
    });
}

asyncOperation()
    .then(resultat => {
        console.log(resultat); // Résultat de l'opération asynchrone
        return 'Nouvelle donnée';
    })
    .then(nouvelleDonnee => {
        console.log(nouvelleDonnee); // Nouvelle donnée
    })
    .catch(erreur => {
        console.error(erreur);
    });
```
