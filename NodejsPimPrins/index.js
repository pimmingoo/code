import express from "express";
import chalk from "chalk";
const app = express();
const PORT = 3000;

app.get("/", (req, res) => {
res.send(chalk.red("Hallo vanaf je sinterklaas Node-server!"));
});

app.listen(PORT, () => {
console.log(chalk.green(`Server draait op http://localhost:${PORT}`));
});
