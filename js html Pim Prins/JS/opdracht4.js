// a. Selecteer Elementen
const newItemInput = document.getElementById('new-item');
const addItemBtn = document.getElementById('add-item-btn');
const itemList = document.getElementById('item-list');
const removeItemBtn = document.getElementById('remove-item-btn');
const description = document.getElementById('description');
const changeTextBtn = document.getElementById('change-text-btn');
 
// b. Voeg Nieuwe Items Toe aan de Lijst
addItemBtn.addEventListener('click', () => {
    const newItemText = newItemInput.value.trim();
    if (newItemText) {
        const newItem = document.createElement('li');
        newItem.textContent = newItemText;
 
        // Extra uitdaging: Klik op item om te verwijderen
        newItem.addEventListener('click', () => {
            itemList.removeChild(newItem);
        });
 
        itemList.appendChild(newItem);
        newItemInput.value = '';
    }
});
 
// c. Verwijder Laatste Item
removeItemBtn.addEventListener('click', () => {
    const lastItem = itemList.lastElementChild;
    if (lastItem) {
        itemList.removeChild(lastItem);
    }
});
 
// d. Wijzig de Beschrijving
changeTextBtn.addEventListener('click', () => {
    const newText = prompt('Voer een nieuwe beschrijving in:', description.textContent);
    if (newText !== null) {
        description.textContent = newText;
    }
});
 
// Extra uitdaging: Verander achtergrondkleur van lijstitems
itemList.addEventListener('click', (e) => {
    if (e.target.tagName === 'LI') {
        e.target.style.backgroundColor = e.target.style.backgroundColor === 'lightgreen' ? 'lightblue' : 'lightgreen';
    }
});