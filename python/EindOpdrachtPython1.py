import os
import time

def clear_console():
    if os.name == 'nt':
        os.system('cls')
    else:
        os.system('clear')

def begroeting_gebruiker():
    clear_console()
    naam = str(input("Chatbot: Goeie (morgen, middag, avond) gebruiker, Wat is je naam?:"))
    time.sleep(2)
    groet = print(f"Chatbot: Goeie (Morgen, Middag, Avond) {naam}!")
    time.sleep(5)
    return groet

def rekenkundige_bewerkingen():
    clear_console()
    nummer1 = float(input("Chatbot: Geef het eerste getal: "))
    keeridk = input("Chatbot: Wat wil je er mee doen (+,-,x,/)?:")
    nummer2 = float(input("Chatbot: Geef het tweede getal: "))
    andwoord1 = nummer1 + nummer2
    andwoord2 = nummer1 - nummer2
    andwoord3 = nummer1 * nummer2

    if keeridk == "+":
        print(f"Chatbot: {nummer1} + {nummer2} = {andwoord1}")
        time.sleep(5)
    elif keeridk == "-":
        print(f"Chatbot: {nummer1} - {nummer2} = {andwoord2}")
        time.sleep(5)
    elif keeridk == "x":
        print(f"Chatbot: {nummer1} x {nummer2} = {andwoord3}")
        time.sleep(5)
    elif keeridk == "/":
        if nummer2 == 0:
            print("Chatbot: Je kan niet delen door 0 jij niet zoon slim persoon!.")
            time.sleep(4)
            rekenkundige_bewerkingen()
        else:
            andwoord4 = nummer1 / nummer2
            print(f"Chatbot: {nummer1} / {nummer2} = {andwoord4}")
            time.sleep(5)
    else:
        print("Chatbot: Ongeldige bewerking.")
        time.sleep(2)
        rekenkundige_bewerkingen()

def persoonlijke_informatie_opslaan(info_lijst):
    clear_console()
    naam = input("Chatbot: Wat is je naam?: ")
    leeftijd = int(input("Chatbot: Wat is je leeftijd?: "))
    geslacht = input("Chatbot: Welk geslacht ben je? (Man of Vrouw): ")
    info_lijst.append((naam, leeftijd, geslacht))
    print("Chatbot: Persoonlijke informatie opgeslagen!")
    time.sleep(3)

def informatie_bekijken(info_lijst):
    clear_console()
    for persoon in info_lijst:
        print(f"Chatbot: Je naam is: {persoon[0]}, Je leeftijd is: {persoon[1]}, Je geslacht is: {persoon[2]}")
        time.sleep(5)

def herhaal_interactie():
    clear_console()
    print(f"Hoi {naam}! Wat wil je doen?")
    print("1. Begroeting")
    print("2. Rekenkundige bewerkingen")
    print("3. Persoonlijke informatie opslaan")
    print("4. Informatie bekijken")
    print("5. Afsluiten")
    bannaan = int(input("Kies een optie (1-5): "))

    if bannaan == 1:
        begroeting_gebruiker()
        herhaal_interactie()
    
    elif bannaan == 2:
        rekenkundige_bewerkingen()
        herhaal_interactie()
    
    elif bannaan == 3:
        persoonlijke_informatie_opslaan(info_lijst)
        herhaal_interactie()
    
    elif bannaan == 4:
        informatie_bekijken(info_lijst)
        herhaal_interactie()
    
    elif bannaan == 5:
        clear_console()
        print("Chatbot: Leuk gepraat te hebben, het programma sluit nu af.")
        time.sleep(2)

    else:
        print("Chatbot: Ongeldige optie, probeer opnieuw.")
        time.sleep(1)
        herhaal_interactie()

info_lijst = []

naam = str(input("Chatbot: Hallo! Ik ben de chatbot wie ben jij?:"))
herhaal_interactie()