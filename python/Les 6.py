import time

def kwadraat_berekenen(getal):
    return getal * getal

getal = int(input("Welk kwadraat wil je weten?:"))
resultaat = kwadraat_berekenen(getal)

print ("Dit kwadraat is:", resultaat)
time.sleep(3)