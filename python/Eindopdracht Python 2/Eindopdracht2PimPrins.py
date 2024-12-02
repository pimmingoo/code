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
            print("6. Inladen van bestand")
            print("7. Statistieken")
            print("8. Afsluiten")
            choice = int(input("Kies een optie (1-8): "))

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
                load_from_file(boekenlijst)

            elif choice == 7:
                time.sleep(1)
                clear_console()
                show_statistics()

            elif choice == 8:
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

def remove_book(boekenlijst): # verwijdert boek uit de lijst
    title = input("Geef het titel van het boek: ")
    for boek in boekenlijst:
        if boek["title"] == title:
            boekenlijst.remove(boek)
            print("Boek is verwijderd.")
            time.sleep(1)

        else:
            print("boek is niet gevonden.")
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
            time.sleep(1)

        else:
            time.sleep(1)
            
        

def save_to_file(boekenlijst): # slaat de lijst van boeken op in een bestand
    with open(os.path.join(os.path.dirname(__file__), "boekenlijst.csv"), 'a') as file: # dit zorgt er voor dat het bestand
        for boek in boekenlijst:                                                        # altijd word geopent in de zelfde map 
            file.write(f"{boek['title']};{boek['Auteur']};{boek['Jaar']}\n")            # waar het script in staat
            boekenlijst.clear()
            print("Boek/Boeken zijn opgeslagen.")
            time.sleep(2)

def load_from_file(boekenlijst): # laadt de lijst van boeken uit een bestand
        with open(os.path.join(os.path.dirname(__file__), "boekenlijst.csv"), 'r') as file:
            next(file)
            for line in file:
                title, author, publication_year = line.strip().split(';')
                boekenlijst.append({"title": title, "Auteur": author, "Jaar": int(publication_year)})
        print("Boek/Boeken zijn ingeladen.")
        time.sleep(2)                                                                                                                                                                                                                                                                                                              

main()