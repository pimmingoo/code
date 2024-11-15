import time # importeert tijd
import os # importeert het kijken van de os

def clear(): # clears de console
    os.system('cls' if os.name == 'nt' else 'clear')

def verander_lange_woorden(woordjes):
    for i in range(len(woordjes)):
        if len(woordjes[i]) > 5:
            woordjes[i] = 'lang'
    return woordjes

woordjes = ['appel', 'banaan', 'kiwi', 'watermeloen']
verander = verander_lange_woorden(woordjes)

def sterren():
    # Vraag de gebruiker om het aantal lagen
    while True:
        n = int(input("Voer het aantal lagen in voor de piramide: "))
        if n >= 10:
            print("te veel voer een getal lager dan 10 in")
            time.sleep(1)
            break
            clear()

# Genereer de piramide
        for i in range(1, n + 1):
    # Bereken het aantal sterretjes voor de huidige laag
            sterren = '*' * (2 * i - 1)
    # Print de sterretjes in het midden door spaties voor de sterretjes toe te voegen
            print(sterren.center(2 * n - 1))
            time.sleep(3)


sterren()