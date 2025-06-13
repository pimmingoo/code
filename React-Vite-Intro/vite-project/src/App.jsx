// import { useState } from 'react';

// function Voorbeeld() {
//   const [lijst, setLijst] = useState([]);

//   const voegToe = () => {
//     setLijst([...lijst, `Item ${lijst.length + 1}`]);
//   };

//   return (
//     <div>
//       <button onClick={voegToe}>Voeg item toe</button>
//       <ul>
//         {lijst.map((item, index) => <li key={index}>{item}</li>)}
//       </ul>
//     </div>
//   );
// }

// export default function App() {
//   return (
//     <div>
//       <h1>Voorbeeld van een React component</h1>
//       <Voorbeeld />
//     </div>
//   );
// }



// // src/App.jsx
import React from "react";
import Card from "./components/card"; // Zorg ervoor dat het pad naar je Card component correct is
import "./App.css"; // Zorg ervoor dat je CSS-bestand correct is geïmporteerd

export default function App() {
  return (
    <div className="app-container">
      
      <Card
        imageUrl="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRVfEpFB0-EHmG0nNB0ZaC1Fxrfo_w82twyg&s"
        title="Vakantie aan Zee"
        description="Geniet van zon, zee en strand in deze prachtige kustbestemming."
      />

      <Card
        imageUrl="https://www.vakantiediscounter.nl/blog/wp-content/uploads/2016/08/bezienswaardigheden-parij.jpg"
        title="Stedentrip Parijs"
        description="Ontdek de lichtstad en bezoek iconische bezienswaardigheden."
      />

      <Card
        imageUrl="https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcRs8pfAyDu8MYc6bjzezl5wiHgSmVdRELYD_7TBgQ6qo_J8f5n2gRCVI3qnbalA4cmLkwqz5HlCwOL5eAEHkMNRUs-j7FM056NZcoUzmg"
        title="Avontuur in de Bergen"
        description="Ga hiken in de bergen en geniet van adembenemende uitzichten."
      />
    </div>
  );
}


// import { useState } from 'react';
// import Greeting from "./Greeting"

// function App() {
//   const [count, setCount] = useState(0);

//   return (
//     <div>
//       <h1>Mijn React app met Vite</h1>
//       <button onClick={() => setCount((count) => count + 1)}>
//         Je hebt de knop {count} keer aangeklikt
//       </button>
//       <Greeting name="Pim" />
//     </div> );
// }

// export default App;