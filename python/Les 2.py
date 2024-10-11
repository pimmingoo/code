import time
keuze = input("Wat Wil je doen? ( A = Leeftijd over 10 jaar, B = Rekenmachine, C = Gelijkheidschecker):")

if keuze == 'A' : 
    naam = str(input("wat is je naam ?: "))
    print(f"{naam}")
    leeftijd = int(input("Wat is je leeftijd? :"))
    print(f"{leeftijd}")
    leeftijd2 = leeftijd + 10
    print(f"Je leeftijd over 10 jaar is: {leeftijd2}")
    time.sleep(3)

if keuze == 'B':
    getal1 = int(input("Geef het eerste getal: "))
    som = str(input("Wat wil je ermee doen? (+,-,x,:):"))
    getal2 = int(input("Geef het tweede getal: "))
    sommetje1 = getal1 + getal2
    sommetje2 = getal1 - getal2
    sommetje3 = getal1 * getal2
    sommetje4 = getal1 / getal2
    if som == '+':
        print(f"{getal1} + {getal2} = {sommetje1}")
        time.sleep(3)
    elif som == '-':
        print(f"{getal1} - {getal2} = {sommetje2}")
        time.sleep(3)
    elif som == 'x':
        print(f"{getal1} x {getal2} = {sommetje3}")
        time.sleep(3)
    elif som == ':':
        print(f"{getal1} : {getal2} = {sommetje4}")
        time.sleep(3)
    else:
        print("Ongeldige optie")
        time.sleep(3)

if keuze == 'C':
    getal3 = int(input("geef 1e getal:"))
    getal4 = int(input("geef 2e getal:"))
    if getal3 == getal4:
        print("Gelijk")
    else:
        print("Ongelijk")
    time.sleep(3)


else:
    print("Ongeldige optie")
    time.sleep(3)