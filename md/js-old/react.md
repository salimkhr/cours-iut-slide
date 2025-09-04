# Introduction à React
---
## Composants

<small>Exemple de composant :</small>

```jsx []
import React from 'react';

function HelloWorld() {
    return <h1>Hello, World!</h1>;
}

export default HelloWorld;
```

---
## Composants

<small>Exemple d'utilisation d'un composant :</small>

```jsx [5-11]
import React from 'react';
import ReactDOM from 'react-dom';
import HelloWorld from './HelloWorld';

function App() {
    return (
        <div>
            <HelloWorld />
        </div>
    );
}

ReactDOM.render(<App />, document.getElementById('root'));
```

---
## Props
<small>Les props sont des arguments passés à des composants.</small>

```jsx []
import React from 'react';

function Hello(props) {
    return <h1>Hello, {props.name}!</h1>;
}

export default Hello;
```

```jsx []
<Hello name="Alice" />
```

---
## Gestion d'état avec useState
<small>useState permet aux composants de gérer leur état.</small>

```jsx [1-15|4|8|10]
import React, { useState } from 'react';

function Counter() {
  const [count, setCount] = useState(0);

  return (
    <div>
      <p>Compteur: {count}</p>
      <button 
          onClick={() => setCount(count + 1)}>
          Incrémenter
      </button>
    </div>
  );
}
```
---
## Effets avec useEffect
<small>useEffect permet d'effectuer des opérations en réponse à des changements dans le composant.</small>

```jsx []
import React, { useState, useEffect } from 'react';

function Timer() {
  const [seconds, setSeconds] = useState(0);

  useEffect(() => {
    const timer = setInterval(() => {
      setSeconds(seconds + 1);
    }, 1000);

    return () => clearInterval(timer);
  }, [seconds]);

  return <p>Temps écoulé: {seconds} secondes</p>;
}
```

---
## Contexte en React
<small>Le contexte permet de transmettre des données à travers l'arbre des composants sans avoir besoin de passer explicitement des props à chaque niveau.</small>

```jsx [1-15|4|6-12|14]
import React, { createContext, useContext } from 'react';

// Création du contexte
const ThemeContext = createContext('light');

// Composant fournissant le contexte
function App() {
    return (
        <ThemeContext.Provider value="dark">
            <Toolbar />
        </ThemeContext.Provider>
    );
}

// Composant consommant le contexte
function Toolbar() {
    return (
        <div>
            <ThemedButton />
        </div>
    );
}

// Composant consommant le contexte avec le hook useContext
function ThemedButton() {
    const theme = useContext(ThemeContext);
    return <button>{theme}</button>;
}

export default App;
```
