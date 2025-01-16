const products = [
    { naam: "Laptop", prijs: 988.99, beschrijving: "Geweldige laptop goed voor gamen en meer dingen." },
    { naam: "Telefoon", prijs: 599.99, beschrijving: "Nieuwste van het nieuwste geweldige telefoon." },
    { naam: "Koptelefoon", prijs: 89.99, beschrijving: "Beste noice canceling die er nu is." },
    { naam: "tablet", prijs: 199.99, beschrijving: "Goeie tablet met ingebouwde blauwe filter." },
];

// Winkelwagen object
const winkelwagen = {};

// Producten weergeven
function displayProducts() {
    const productList = document.getElementById("producten-lijst");

    if (!productList) {
        console.error("Element met id 'producten-lijst' niet gevonden");
        return;
    }

    products.forEach((product, index) => {
        const card = document.createElement("div");
        card.classList.add("producten-card");

        card.innerHTML = `
            <h3>${product.naam}</h3>
            <p>${product.beschrijving}</p>
            <p>Prijs: €${product.prijs.toFixed(2)}</p>
            <button data-index="${index}">Voeg toe aan winkelwagen</button>
        `;

        const button = card.querySelector("button");
        button.addEventListener("click", () => addToCart(index));

        productList.appendChild(card);
    });
}

// Product toevoegen aan winkelwagen
function addToCart(productIndex) {
    const product = products[productIndex];

    if (winkelwagen[product.naam]) {
        winkelwagen[product.naam].aantal += 1;
    } else {
        winkelwagen[product.naam] = { ...product, aantal: 1 };
    }

    updateCartUI();
}

// Product verwijderen uit winkelwagen
function removeFromCart(productName) {
    if (winkelwagen[productName]) {
        winkelwagen[productName].aantal -= 1;

        // Verwijder het product als de hoeveelheid 0 is
        if (winkelwagen[productName].aantal <= 0) {
            delete winkelwagen[productName];
        }
    }

    updateCartUI();
}

// Winkelwagen bijwerken in de UI
function updateCartUI() {
    const cartList = document.getElementById("winkelwagen-items");
    cartList.innerHTML = ""; // Verwijder oude inhoud

    Object.values(winkelwagen).forEach((item) => {
        const li = document.createElement("li");

        li.innerHTML = `
            <span>${item.naam} - €${item.prijs.toFixed(2)} x ${item.aantal}</span>
            <button class="winkelwagen-button">Verwijder</button>
        `;

        const removeButton = li.querySelector("button");
        removeButton.addEventListener("click", () => removeFromCart(item.naam));

        cartList.appendChild(li);
    });
}

document.addEventListener("DOMContentLoaded", displayProducts);
