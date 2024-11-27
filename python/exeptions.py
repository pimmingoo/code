import time
import os

# deze functie zorgt ervoor dat elke keer als ik hem gebruik de console leeg word gemaakt
def clear_console():
    if os.name == 'nt':
        os.system('cls')
    else:
        os.system('clear')

# dit programma vraagt voor 2 getallen en gaat ze delen, het maakt gebruik van exeptions
def delen():
    while True:
        clear_console()
        try:
            print("je gaat een getal delen")
            getal1 = float(input("mag ik het eerste getal?:"))
            getal2 = float(input("mag ik het tweede getal?:"))
            andwoord = getal1 / getal2
        except ValueError:
            print("voer alstublieft een geldig getal in")
        except ZeroDivisionError:
            print("je kan niet delen door 0")
        else:
            print(f"{getal1} : {getal2} = {andwoord}")
        finally:
            sinterklaas = str(input("wil je verder (ja/nee)"))
            time.sleep(1)
            if sinterklaas == "ja":
                print("oki :D")
                time.sleep(1)
            elif sinterklaas == "nee":
                print("Het programma word nu afgesloten")
                time.sleep(1)
                break
            else: 
                print("geef een juiste antwoord")
                print("het programma word nu toch afgesloten")
                time.sleep(1)
                break

# dit programma leest een bestand
import time
import os

def clear_console():
    os.system('cls' if os.name == 'nt' else 'clear')

def bestand():
    clear_console()
    try:
        bestand = open("gegevens.txt", "r")
        inhoud = bestand.read()
        time.sleep(1)
    except FileNotFoundError:
        print("Er is een fout met het openen van het bestand.")
        time.sleep(1)
    else:
        print(inhoud)
    finally:
        print("Deze code wordt altijd uitgevoerd.")
        time.sleep(1)
        if 'bestand' in locals() and not bestand.closed:
            bestand.close()


bestand()




