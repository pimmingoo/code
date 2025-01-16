const products = [
    { naam: "Laptop", prijs: 199.99, beschrijving: "Geweldige laptop voor het coderen van sites zoals deze." },
    { naam: "Telefoon", prijs: 599.99, beschrijving: "Perfect voor het spelen van pokemon go." },
    { naam: "Koptelefoon", prijs: 29.99, beschrijving: "Voor top kwaliteit geluid." },
];

function displayProducts() {
    const productList = document.getElementById("producten-lijst");

    if (!productList) {
        console.error("Element met id 'producten-lijst' niet gevonden");
        return;
    }

    products.forEach((product) => {
        const card = document.createElement("div");
        card.classList.add("producten-card");

        card.innerHTML = `
            <h3>${product.naam}</h3>
            <p>${product.beschrijving}</p>
            <p>Prijs: €${product.prijs}</p>
            <button>Voeg toe aan winkelwagen</button>
        `;

        const button = card.querySelector("button");
        button.addEventListener("click", () => {
            console.log(`${product.naam} toegevoegd aan winkelwagen`);
        });

        productList.appendChild(card);
    });
}

document.addEventListener("DOMContentLoaded", displayProducts);
