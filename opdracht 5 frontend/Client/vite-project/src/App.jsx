import React, { useEffect, useState } from 'react';

function App() {
  const [products, setProducts] = useState([]);
  

  useEffect(() => {
    // Fetch data bij component mount
    fetch('http://localhost:3001/products')
      .then(response => response.json())
      .then(data => setProducts(data))
      .catch(error => console.error('Fout bij ophalen van producten:', error));
  }, []); // Lege dependency array = alleen bij mount

  return (
    <div>
      <h1>Producten</h1>
      <ul>
        {products.map(product => (
          <li key={product.id}>{product.name}</li> // pas aan op basis van je data
        ))}
      </ul>
    </div>
  );
}

export default App;
