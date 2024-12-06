import time
import os

boekenlijst = []

def clear_console(): # clears the console
    os.system('cls' if os.name == 'nt' else 'clear')

def main():  # geeft het menu weer
    while True:
        clear_console()
        choice = None  # zorgt er voor dat de choice geen verkeerde waarde krijgt
        try:
            print("1. Boek toevoegen")
            print("2. Boek zoeken")
            print("3. Boek verwijderen")
            print("4. Boekenlijst bekijken")
            print("5. Opslaan naar bestand")
            print("6. Statistieken")
            print("7. Afsluiten")
            choice = int(input("Kies een optie (1-7): "))

        except ValueError:
            print("Fout: Ongeldige invoer.")
            continue

        finally:

            if choice not in range(0, 9):
                print("Fout: Kies een geldige optie tussen 1 en 8.")
                time.sleep(2)
                continue

            # Voer de actie uit op basis van de keuze
            if choice == 1:
                time.sleep(1)
                clear_console()
                add_book(boekenlijst)

            elif choice == 2:
                time.sleep(1)
                clear_console()
                search_book(boekenlijst)

            elif choice == 3:
                time.sleep(1)
                clear_console()
                remove_book(boekenlijst)

            elif choice == 4:
                time.sleep(1)
                clear_console()
                view_books(boekenlijst)

            elif choice == 5:
                time.sleep(1)
                clear_console()
                save_to_file(boekenlijst)

            elif choice == 6:
                time.sleep(1)
                clear_console()
                show_statistics(boekenlijst)

            elif choice == 7:
                clear_console()
                print("Programma wordt afgesloten...")
                time.sleep(0.5)
                clear_console()
                print("Programma wordt afgesloten..")
                time.sleep(0.5)
                clear_console()
                print("Programma wordt afgesloten.")
                time.sleep(0.5)
                print("Programma wordt afgesloten")
                time.sleep(0.5)
                clear_console()
                break

def add_book(boekenlijst): # voegt boek to aan de lijst

    title = input("Geef het titel van het boek: ")
    author = input("Geef het auteur van het boek: ")
    publication_year = int(input("Geef het jaar waarin het boek is gemaakt: "))

    boekenlijst.append({"title": title, "Auteur": author, "Jaar": publication_year})

    print("Boek is toegevoegd.")
    time.sleep(1)

def search_book(boekenlijst): # zoeken in de lijst van boeken
    title = input("Geef het titel van het boek: ")
    try:
        for boek in boekenlijst:
            if boek["title"] == title:
                print(f"Titel: {boek['title']}")
                print(f"Auteur: {boek['Auteur']}")
                print(f"Jaar: {boek['Jaar']}")
                time.sleep(3)
            
    except KeyError:
        print("Boek met dit titel is niet gevonden.")
        time.sleep(2)

def remove_book(boekenlijst): # verwijdert boek uit boekenlijst en het bestand
    # Vraag de gebruiker naar de titel van het boek
    title = input("Geef de titel van het boek: ")
    file_path = os.path.join(os.path.dirname(__file__), "boekenlijst.csv")
    
    boek_gevonden = False
    
    # Lees het bestand in en filter de regels
    with open(file_path, 'r') as file:
        lijnen = file.readlines()
    
    nieuwe_lijnen = []
    for lijn in lijnen:
        if lijn.strip().startswith(title + ";"):  # Controleert of de regel met de titel begint
            boek_gevonden = True
        else:
            nieuwe_lijnen.append(lijn) 

    if boek_gevonden:
        # Schrijf de bijgewerkte lijst terug naar het bestand
        with open(file_path, 'w',) as file:
            file.writelines(nieuwe_lijnen)
        
        # Verwijder het boek ook uit de lijst
        for boek in boekenlijst:
            if boek["title"] == title:
                boekenlijst.remove(boek)
             
        print("Boek is verwijderd.")
    else:
        print("Boek niet gevonden.")
    
    time.sleep(1)

def view_books(boekenlijst): # bekijkt de lijst van boeken
    if len(boekenlijst) == 0:
        print("Er zijn nog geen boeken in de lijst.")
        time.sleep(2)

    else:
        for boek in boekenlijst:
            print(f"Titel: {boek['title']}")
            print(f"Auteur: {boek['Auteur']}")
            print(f"Jaar: {boek['Jaar']}")
            print("--------------------")
        doorgaan = input("Click Enter om doortegaan")

        if doorgaan == "":
            time.sleep(0.5)

        else:
            time.sleep(0.5)
            
        

def save_to_file(boekenlijst): 
    file_path = os.path.join(os.path.dirname(__file__), "boekenlijst.csv")
    
    # Lees de bestaande boeken uit het bestand
    bestaande_boeken = set()
    if os.path.exists(file_path):
        with open(file_path, 'r') as file:
            for line in file:
                bestaande_boeken.add(line.strip()) 
    
    # Open het bestand in append-modus
    with open(file_path, 'a') as file:
        boeken_opgeslagen = False
        for boek in boekenlijst:
            boek_regel = f"{boek['title']};{boek['Auteur']};{boek['Jaar']}"
            if boek_regel not in bestaande_boeken:  # Controleer of het boek nog niet bestaat
                file.write(boek_regel + "\n")
                bestaande_boeken.add(boek_regel)  # Voeg toe aan de lijst van opgeslagen boeken
                boeken_opgeslagen = True
        
        if boeken_opgeslagen:
            print("Nieuwe boeken zijn opgeslagen.")
        else:
            print("Geen nieuwe boeken om op te slaan.")
    
    time.sleep(2)


def load_from_file(boekenlijst): # laadt de lijst van boeken uit een bestand
        with open(os.path.join(os.path.dirname(__file__), "boekenlijst.csv"), 'r') as file:
            next(file)

            try:
                for line in file:
                    title, author, publication_year = line.strip().split(';')
                    boekenlijst.append({"title": title, "Auteur": author, "Jaar": int(publication_year)})
                print("Boek/Boeken zijn ingeladen.")
                time.sleep(2)

            except ValueError:
                print("Er is een fout opgetreden of je hebt geen boeken.")

                next_input = input("Klik Enter om door te gaan")
                if next_input == "":
                    time.sleep(0.5)
                else:
                    time.sleep(0.5)
                                                                                                                                                                                                                                                                                                                       
def show_statistics(boekenlijst):
    auteurs = {boek['Auteur'] for boek in boekenlijst}

    print("Statistieken:")
    print(f"Aantal boeken: {len(boekenlijst)}")
    print(f"Aantal auteurs: {len(auteurs)}")

    doorgaan = input("Click Enter om doortegaan")

    if doorgaan == "":
        time.sleep(0.5)

    else:
        time.sleep(0.5)

load_from_file(boekenlijst)
main()