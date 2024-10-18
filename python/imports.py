# all imports
import time 
import os 
import math 
import datetime 
import numpy as np 

def clearconsole(): # Clears console
    os.system('cls' if os.name == 'nt' else 'clear')

def wortels_yum(): # berekent Wortels en Machten
    clearconsole()
    time.sleep(1)

    # vraagt wat je wil machten/wortels
    print("Wat wil je weten?")
    print("1. Een vierkantswortel")
    print("2. Een Macht")
    time.sleep(3)

    sinterklaas = int(input("Enter (1-2):"))

    # Berekent wortels en machten, if statements zijn voor het checken wat de persoon wou
    if sinterklaas == 1:
        getal = float(input("Geef een getal: "))
        print(f"De vierkantswortel van {getal} is {math.sqrt(getal)}")
        time.sleep(3)
    
    elif sinterklaas == 2:
        getal1 = float(input("Geef het eerste getal: "))
        macht = int(input("Geef de macht: "))
        print(f"{getal1} tot de macht {macht} is {math.pow(getal1, macht)}")
        time.sleep(3)

def watch(): 
    clearconsole()
    time.sleep(1)

    # kijkt de tijd
    nu = datetime.datetime.now()
    morgen = nu + datetime.timedelta(days=1)

    # print het resultaat
    print(f"Het is nu {nu} en morgen is het {morgen}.")

def matrix(): # voert een matrix-multiplicatie uit
    clearconsole()
    time.sleep(1)

    # Maak twee numpy-arrays aan
    matrix_a = np.array([[1, 3], [2, 4]])
    matrix_b = np.array([[5, 7], [6, 8]])

    # Voer een matrix-multiplicatie uit
    resultaat = np.dot(matrix_a, matrix_b)

    # Print de resultaten
    print(f"matrix A = {matrix_a}")
    print(f"matrix B = {matrix_b}")
    print("Resultaat van de matrix-multiplicatie:")
    print(resultaat)

