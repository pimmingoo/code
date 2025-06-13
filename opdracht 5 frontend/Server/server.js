const express = require('express');
const app = express();
const port = 3001;
const cors = require('cors');

const products = [
  { id: 1, name: 'computer', price: 699.97 },
  { id: 2, name: 'monitor', price: 278.99 },
  { id: 3, name: 'keyboard', price: 119.98 }
];

app.use(cors());

app.get('/products', (req, res) => {
  res.json(products);
});

app.listen(3001, () => {
  console.log(`Server is running on http://localhost:3001`);
});