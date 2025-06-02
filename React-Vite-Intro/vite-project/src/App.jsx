import { useState } from 'react';
import Greeting from "./Greeting"

function App() {
  const [count, setCount] = useState(0);

  return (
    <div>
      <h1>Mijn React app met Vite</h1>
      <button onClick={() => setCount((count) => count + 1)}>
        Je hebt de knop {count} keer aangeklikt
      </button>
      <Greeting name="Pim" />
    </div> );
}

export default App;