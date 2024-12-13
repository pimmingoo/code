# Schraken: Een simpele implementatie

# Standaard schaakbord maken
def maak_bord():
    bord = [
        ["r", "n", "b", "q", "k", "b", "n", "r"],  # Torens, paarden, lopers, koningin, koning
        ["p", "p", "p", "p", "p", "p", "p", "p"],  # Pionnen
        [".", ".", ".", ".", ".", ".", ".", "."],
        [".", ".", ".", ".", ".", ".", ".", "."],
        [".", ".", ".", ".", ".", ".", ".", "."],
        [".", ".", ".", ".", ".", ".", ".", "."],
        ["P", "P", "P", "P", "P", "P", "P", "P"],  # Witte pionnen
        ["R", "N", "B", "Q", "K", "B", "N", "R"],  # Witte stukken
    ]
    return bord

# Bord weergeven
def print_bord(bord):
    for rij in bord:
        print(" ".join(rij))
    print()

# Een eenvoudige beweging uitvoeren
def verplaats_stuk(bord, start, eind):
    x1, y1 = start
    x2, y2 = eind

    # Controleer of de startpositie een stuk bevat
    if bord[x1][y1] == ".":
        print("Geen stuk op de startpositie!")
        return

    # Voer de zet uit
    bord[x2][y2] = bord[x1][y1]
    bord[x1][y1] = "."

# Voorbeeld voor Schraken: voeg een speciale regel toe
def schraken_regel(bord, positie):
    x, y = positie
    if bord[x][y].lower() == "p":  # Pion regel
        print("Schraken regel geactiveerd: pion kan extra bewegen!")
        if x > 0:
            bord[x - 1][y] = "P" if bord[x][y].isupper() else "p"

# Hoofdprogramma
if __name__ == "__main__":
    schaakbord = maak_bord()
    print("Beginstand van het bord:")
    print_bord(schaakbord)

    # Verplaats een pion (voorbeeld)
    print("Verplaats pion van (6, 0) naar (4, 0):")
    verplaats_stuk(schaakbord, (6, 0), (4, 0))
    print_bord(schaakbord)

    # Pas een Schraken-regel toe
    print("Activeer Schraken-regel op positie (4, 0):")
    schraken_regel(schaakbord, (4, 0))
    print_bord(schaakbord)
